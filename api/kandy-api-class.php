<?php
// KANDY USER FILTERING STATUS
define('KANDY_USER_ALL', 1);
define('KANDY_USER_ASSIGNED', 2);
define('KANDY_USER_UNASSIGNED', 3);
define('KANDY_USER_NUM_FIRST_VISIT', 10);
class KandyApi{
    /**
     * Get Kandy User Data for assignment table.
     *
     * @param int $limit
     *   Limit User
     * @param int $offset
     *   Offset
     * @return array
     *   Array User Object
     */
    public static function isFristVisit()
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT COUNT(*) AS COUNT FROM wp_kandy_users', OBJECT );
        if($results[0]->COUNT > 0) return false;
        else return true;
    }

    public static function autoAssignmentUsers()
    {
        $done_count=0;
        $usercount = count_users()['total_users'];
        $users = KandyApi::getUserData($usercount);
        $kandyUsers = KandyApi::listUsers(KANDY_USER_UNASSIGNED);
        $kandy_user_count = count($kandyUsers);
        foreach($users as $user)
        {
            if($user['kandy_user_id'] == '') {
                if ($kandy_user_count == 0) break;
                $kandy_user_id = $kandyUsers[$kandy_user_count - 1]->user_id;
                KandyApi::assignUser($kandy_user_id, $user['ID']);
                $kandy_user_count--;
                $done_count++;
            }
        }
        return $done_count;
    }

    public static function getUserData($limit = 10, $offset = 0)
    {
        global $wpdb;
        $query='SELECT u.*, ku.user_id FROM wp_users u LEFT JOIN wp_kandy_users ku ON u.ID = ku.main_user_id ORDER BY u.id LIMIT '.$offset.','.$limit;
        $results = $wpdb->get_results( $query, OBJECT );

        $rows = array();
        foreach ($results as $row) {
            $url = self::page_url(
                array(
                    "action" => "edit",
                    "id" => $row->ID
                )
            );
            $tableCell = array(
                'ID'  => $row->ID,
                'username' => $row->user_login,
                'name' => $row->display_name,
                "kandy_user_id"=> ($row->user_id) ? $row->user_id : null,
                "action" => "<a href='". $url."' class='button kandy_edit'>". __("Edit", 'kandy'). "</a>"
            );
            $rows[] = $tableCell;
        }
        return $rows;
    }


    /**
     * Get domain access token
     * @return array A list of message and data
     * @throws RestClientException
     */
    public static function getDomainAccessToken()
    {
        require_once dirname(__FILE__) . '/RestClient.php';

        $kandyApiKey = get_option('kandy_api_key', KANDY_API_KEY);
        $kandyDomainSecretKey = get_option(
            'kandy_domain_secret_key',
            KANDY_DOMAIN_SECRET_KEY
        );
        $params = array(
            'key'               => $kandyApiKey,
            'domain_api_secret' => $kandyDomainSecretKey
        );

        $fieldsString = http_build_query($params);
        $url = KANDY_API_BASE_URL . 'domains/accesstokens' . '?'
            . $fieldsString;

        try {
            $restClientObject = new RestClient();
            $response = $restClientObject->get($url)->getContent();
        } catch (Exception $ex) {

            return array(
                'success' => false,
            );
        }

        $response = json_decode($response);
        if ($response->message == 'success') {
            return array(
                'success' => true,
                'data'    => $response->result->domain_access_token,
            );
        } else {
            return array(
                'success' => false,
                'message' => $response->message
            );
        }
    }

    /**
     * Get user access token
     *
     * @param string $userId
     * @return array A list of message and data
     * @throws RestClientException
     */
    public static function getUserAccessToken($userId)
    {
        require_once dirname(__FILE__) . '/RestClient.php';

        $kandyApiKey = get_option('kandy_api_key', KANDY_API_KEY);
        $kandyDomainSecretKey = get_option(
            'kandy_domain_secret_key',
            KANDY_DOMAIN_SECRET_KEY
        );
        $params = array(
            'key'               => $kandyApiKey,
            'domain_api_secret' => $kandyDomainSecretKey,
            'user_id' => $userId
        );

        $fieldsString = http_build_query($params);
        $url = KANDY_API_BASE_URL . 'domains/users/accesstokens' . '?'
            . $fieldsString;

        try {
            $response = (new RestClient())->get($url)->getContent();
        } catch (Exception $ex) {
            return array(
                'success' => false,
                'message' => $ex->getMessage()
            );
        }

        $response = json_decode($response);
        if ($response->message == 'success') {
            return array(
                'success' => true,
                'data'    => $response->result->user_access_token,
            );
        } else {
            return array(
                'success' => false,
                'message' => $response->message
            );
        }
    }

    /**
     * Get a Kandy anonymous user
     *
     * @return array
     * @throws RestClientException
     */
    public function getAnonymousUser()
    {
        $result = $this->getDomainAccessToken();
        if ($result['success'] == true) {
            $this->domainAccessToken = $result['data'];
        } else {
            // Catch errors
        }

        $params = array(
            'key' => $this->domainAccessToken
        );

        $fieldsString = http_build_query($params);
        $url = KANDY_API_BASE_URL . 'domains/access_token/users/user/anonymous' . '?' . $fieldsString;
        $headers = array(
            'Content-Type: application/json'
        );

        try {
            $response = (new RestClient())->get($url, $headers)->getContent();
        } catch (Exception $ex) {
            return array(
                'success' => false,
                'message' => $ex->getMessage()
            );
        }

        $response = json_decode($response);
        if ($response) {
            if (!empty($response->result)) {
                $res = $response->result;
                $user = new stdClass();
                $user->user_id = $res->user_name;
                $user->password = $res->user_password;
                $user->email = $res->full_user_id;
                $user->full_user_id = $res->full_user_id;
                $user->domain_name = $res->domain_name;
                $user->user_access_token = $res->user_access_token;
                return array(
                    'success' => true,
                    'user' => $user
                );
            } else {
                if (!empty($response->message)) {
                    $message = $response->message;
                } else {
                    $message = "Can not create anonymous user";
                }

                return array(
                    'success' => false,
                    'message' => $message
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => "Can not create anonymous user"
            );
        }
    }

    /**
     * List Kandy User from database
     * @param $type
     * @param bool $remote
     * @return array
     */
    public static function listUsers($type = KANDY_USER_ALL, $remote = false)
    {
        $result = array();
        require_once dirname(__FILE__) . '/RestClient.php';
        // get data from server
        if ($remote) {
            $getTokenResponse = self::getDomainAccessToken();
            if ($getTokenResponse['success']) {
                $domainAccessToken = $getTokenResponse['data'];
                $params = array(
                    'key' => $domainAccessToken
                );

                $fieldsString = http_build_query($params);
                $url = KANDY_API_BASE_URL . 'domains/users' . '?'
                    . $fieldsString;
                $headers = array(
                    'Content-Type: application/json'
                );

                try {
                    $restClientObject = new RestClient();
                    $response = $restClientObject->get($url, $headers)->getContent();
                } catch (Exception $ex) {

                    return array(
                        'success' => false,
                        'message' => $ex->getMessage()
                    );
                }
                $response = json_decode($response);

                if ($response) {
                    $data = $response->result;
                    $result = $data->users;
                }
            }
        } else {
            global $wpdb;
            $getDomainNameResponse = self::getDomain();
            if($getDomainNameResponse['success']){
                $domainName = $getDomainNameResponse['data'];
                if ($type == KANDY_USER_ALL) {


                    $result = $wpdb->get_results(
                        "SELECT *
                             FROM {$wpdb->prefix}kandy_users
                             WHERE domain_name = '". $domainName ."'"
                    );
                } else {
                    if ($type == KANDY_USER_ASSIGNED) {

                        $result = $wpdb->get_results(
                            "SELECT *
                             FROM {$wpdb->prefix}kandy_users
                             WHERE main_user_id IS NOT NULL
                             AND domain_name = '". $domainName ."'");

                    } else {
                        if ($type == KANDY_USER_UNASSIGNED) {
                            $result = $wpdb->get_results(
                                "SELECT *
                             FROM {$wpdb->prefix}kandy_users
                             WHERE (main_user_id = '' || main_user_id IS NULL)
                             AND domain_name = '". $domainName ."'");
                        }
                    }
                }
            }


        }

        return $result;
    }

    /**
     * get Assigned Kandy User By main_user_id
     * @param $mainUserId
     * @return mixed
     */
    public static function getAssignUser($mainUserId)
    {
        global $wpdb;
        $result = null;
        $getDomainNameResponse = self::getDomain();

        if ($getDomainNameResponse['success']) {
            $domainName = $getDomainNameResponse['data'];
            $result = $wpdb->get_results(
                            "SELECT *
                             FROM {$wpdb->prefix}kandy_users
                             WHERE main_user_id = ". $mainUserId ."
                             AND domain_name = '". $domainName ."'");
        }
        if(!empty($result)){
            return $result[0];
        }else {
            $result = null;
        }

        return $result;
    }

    /**
     * get kandy user by user_id
     * @param $kandyUserId
     * @return mixed
     */
    public static function getUserByUserId($kandyUserId){
        global $wpdb;
        $result = null;
        $getDomainNameResponse = self::getDomain();

        if ($getDomainNameResponse['success']) {
            $domainName = $getDomainNameResponse['data'];

            $result = $wpdb->get_results(
                "SELECT *
                             FROM {$wpdb->prefix}kandy_users
                             WHERE user_id = '". $kandyUserId ."'
                             AND domain_name = '". $domainName ."'");

        }
        if(!empty($result)){
            return $result[0];
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * get kandy user by email
     * @param $kandyUserId
     * @return mixed
     */
    public static function getUserByKandyUserMail($kandyUserMail){
        global $wpdb;
        $result = null;
        $getDomainNameResponse = self::getDomain();

        if ($getDomainNameResponse['success']) {
            $domainName = $getDomainNameResponse['data'];

            $parseResult = explode('@', $kandyUserMail);
            $userId = '';
            if (!empty($parseResult[0])) {
                $userId = $parseResult[0];
            }

            $result = $wpdb->get_results(
                "SELECT main_user_id
                             FROM {$wpdb->prefix}kandy_users
                             WHERE user_id = '". $userId ."'
                             AND domain_name = '". $domainName ."'");

        }
        if(!empty($result)){
            $mainUserId = $result[0]->main_user_id;
            if (!empty($mainUserId)) {
                $result = get_user_by('id', $mainUserId);
            }
            else {
                $result = KANDY_UN_ASSIGN_USER;
            }

        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * Get the domain from domain key in the configuration.
     *
     * @param bool $sync
     *   Force to sync(true).
     *
     * @return array
     *   Domain name result.
     */
    public static function getDomain($sync = false)
    {
        $myDomainName = get_option("kandy_domain_name");

        //no sync use database value
        if(!empty($myDomainName) && !$sync){
            return array(
                'success' => true,
                'data'    => $myDomainName,
            );
        }
        require_once dirname(__FILE__) . '/RestClient.php';

        $kandyApiKey = get_option('kandy_api_key', KANDY_API_KEY);
        $getTokenResponse = self::getDomainAccessToken();
        if ($getTokenResponse['success']) {
            $domainAccessToken = $getTokenResponse['data'];
            $params = array(
                'key'               => $domainAccessToken,
                'domain_api_key' => $kandyApiKey
            );

            $fieldsString = http_build_query($params);
            $url = KANDY_API_BASE_URL . 'accounts/domains/details' . '?'
                . $fieldsString;

            try {
                $restClientObject = new  RestClient();
                $response = $restClientObject->get($url)->getContent();
            } catch (Exception $ex) {

                return array(
                    'success' => false,
                    'message' => $ex->getMessage()
                );
            }

            $response = json_decode($response);
            if ($response->message == 'success') {
                update_option("kandy_domain_name",  $response->result->domain->domain_name);
                return array(
                    'success' => true,
                    'data'    => $response->result->domain->domain_name,
                );
            } else {
                return array(
                    'success' => false,
                    'message' => $response->message
                );
            }
        } else {
            return array(
                'success' => false,
                'message' => 'Invalid Domain Request'
            );
        }
    }

    /**
     * Get all users from Kandy and import/update to kandy_user
     *
     * @return array A json status and message
     */
    public static function syncUsers()
    {
        global $wpdb;
        $kandyUsers = self::listUsers(KANDY_USER_ALL, true);
        $getDomainNameResponse = self::getDomain();

        if ($getDomainNameResponse['success']) {
            $domainName = $getDomainNameResponse['data'];

            // The transaction opens here.
            $wpdb->query('START TRANSACTION');
            $receivedUsers = array();
            try {
                foreach($kandyUsers as $kandyUser){
                    $receivedUsers[] = $kandyUser->user_id;
                    $format = array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    );

                    $dataValues = array(
                        'user_id' => $kandyUser->user_id,
                        'first_name' => $kandyUser->user_first_name,
                        'last_name' => $kandyUser->user_last_name,
                        'email' => $kandyUser->user_email,
                        'domain_name' => $kandyUser->domain_name,
                        'api_key' => $kandyUser->user_api_key,
                        'api_secret' => $kandyUser->user_api_secret,
                        'updated_at' => date("Y-m-d H:i:s"),
                    );

                    if (!empty($kandyUser->user_password)) {
                        $dataValues['password'] = $kandyUser->user_password;
                    } else {
                        $dataValues['password'] = '';
                    }
                    
                    $kandyUserModel = self::getUserByUserId($kandyUser->user_id);

                    if(!$kandyUserModel){
                        // insert
                        $format[] = '%s';
                        $dataValues['created_at'] = date("Y-m-d H:i:s");
                        $wpdb->insert($wpdb->prefix. "kandy_users", $dataValues, $format);

                    } else {
                        //update
                        $wpdb->update(
                            $wpdb->prefix . "kandy_users",
                            $dataValues,
                            array('user_id' => $kandyUser->user_id,
                                'domain_name' => $domainName
                            ),
                            $format,
                            array("%s", "%s")
                        );

                    }
                }//end foreach

                if(!empty($receivedUsers)){
                    $inArrayStr = "";
                    foreach($receivedUsers as $receivedUser){
                        $inArrayStr .= "'" . $receivedUser ."',";
                    }
                    $inArrayStr = trim($inArrayStr, ",");
                    $wpdb->query( "DELETE FROM {$wpdb->prefix}kandy_users
                                   WHERE domain_name = '" . $domainName . "'
                                   AND user_id NOT IN (" . $inArrayStr . ")" );
                }

                $wpdb->query('COMMIT');
                $result = array(
                    'success' => true,
                    'message' => "Sync successfully"
                );
            }
            catch (Exception $ex) {
                $wpdb->query('ROLLBACK');

                $result = array(
                    'success' => false,
                    'message' => "Error Data"
                );
            }

        } else {
            $result = array(
                'success' => false,
                'message' => "Cannot get domain name."
            );
        }
        return $result;
    }

    /**
     * Assign Kandy User
     * @param $kandyUserId
     * @param $mainUserId
     * @return bool
     */
    public static function assignUser($kandyUserId, $mainUserId){
        global $wpdb;
        try{
            $getDomainNameResponse = self::getDomain();
            if ($getDomainNameResponse['success'] == true) {
                $domainName = $getDomainNameResponse['data'];

                $wpdb->update(
                    $wpdb->prefix . 'kandy_users',
                    array('main_user_id' => NULL),
                    array(
                        'main_user_id' => $mainUserId,
                        'domain_name'  => $domainName
                    )
                );

                $wpdb->update(
                    $wpdb->prefix . 'kandy_users',
                    array('main_user_id' => $mainUserId),
                    array(
                        'user_id' => $kandyUserId,
                        'domain_name'  => $domainName
                    ),
                    array('%d'),
                    array('%s', '%s')
                );
                return true;
            } else {
                return false;
            }

        } catch(Exception $ex){

            return false;
        }

    }

    /**
     * Unassign kandy user
     * @param $mainUserId
     * @return bool
     */
    public static function unassignUser($mainUserId){
        global $wpdb;
        try{
            $getDomainNameResponse = self::getDomain();
            if ($getDomainNameResponse['success'] == true) {
                $domainName = $getDomainNameResponse['data'];

                $wpdb->update(
                    $wpdb->prefix . 'kandy_users',
                    array('main_user_id' => NULL),
                    array(
                        'main_user_id' => $mainUserId,
                        'domain_name'  => $domainName
                    )
                );

                return true;
            } else {
                return false;
            }
        } catch(Exception $ex){

            return false;
        }
    }

    /**
     * Get Page Url
     * @param null $additional_params
     * @return mixed
     */
    public static  function page_url($additional_params = NULL) {
        $params = array();
        if(!isset($additional_params['page']) && isset($_GET["page"])){
            $params["page"] = $_GET["page"];
        }
        if ( is_array($additional_params) ) {
            $params = array_merge($params, $additional_params);
        }
        return admin_url('admin.php?' . http_build_query($params));
    }

    /**
     * Redirect with a message
     * @param $url
     * @param $message
     * @param string $type
     */
    public static function redirect($url, $message, $type ="updated"){

        echo "<div class ='". $type. "'><p>" . $message. "</p></div>";
        echo "<meta http-equiv='refresh' content='0;url=$url' />";
    }

    /**
     * Kandy Logout
     * @param $userId
     * @return array
     */
    public static function kandyLogout($userId){
        $result = array();
        $assignUser = KandyApi::getAssignUser($userId);

        if($assignUser){
            $userName = $assignUser->user_id;
            $password = $assignUser->password;
            if (empty($password)) {
                if (isset($_SESSION['userAccessToken'][$assignUser->user_id])) {
                    $userAccessToken = $_SESSION['userAccessToken'][$assignUser->user_id];
                } else {
                    $result = KandyApi::getUserAccessToken($assignUser->user_id);
                    if ($result['success'] == true) {
                        $userAccessToken = $result['data'];
                        $_SESSION['userAccessToken'][$assignUser->user_id] = $userAccessToken;
                    } else {
                        return array("success" => false, "message" => $result['message'], 'output' => '');
                    }
                }
            }
            $kandyApiKey = get_option('kandy_api_key', KANDY_API_KEY);
            wp_enqueue_script("kandy_js_url");
            $output = "";
            $output .="<script type='text/javascript' src='". KANDY_JQUERY ."'></script>";
            $output .="<script type='text/javascript' src='". KANDY_JS_URL ."'></script>";
            $output .="<script>
                        if (window.login == undefined){
                            var password = '{$password}';
                            window.login = function() {
                                if (password != '') {
                                    kandy.login('" . $kandyApiKey . "', '" . $userName . "', '" . $password . "',kandyLoginSuccessCallback, kandyLoginFailedCallback );
                                } else {
                                    kandy.loginSSO('" . $userAccessToken . "', kandyLoginSuccessCallback, kandyLoginFailedCallback, '');
                                }                       
                            };
                            window.kandy_logout = function() {
                                KandyAPI.Phone.logout();
                            };
                        }
                        </script>";
            $output .="<script type='text/javascript' src='". KANDY_PLUGIN_URL . "/js/kandyWordpress.js" ."'></script>";
            setcookie( 'kandy_logout', '1', time() - 3600);
            echo $output;
        } else {
            $result = array("success" => false, "message" => 'Can not found kandy user', 'output' => '');
        }

        return $result;
    }

    /**
     * Get last seen of kandy users
     * @param array $users
     * @return mixed|null
     */
    public function getLastSeen($users)
    {
        $result = $this->getDomainAccessToken();
        if ($result['success'] == true) {
            $this->domainAccessToken = $result['data'];
        } else {
            // Catch errors
        }

        $users = json_encode($users);

        $params = array(
            'key' => $this->domainAccessToken,
            'users' => $users
        );
        $url = KANDY_API_BASE_URL . 'users/presence/last_seen?' . http_build_query($params);
        try{
            $response = json_decode((new RestClient())->get($url)->getContent());
        }catch (\Exception $e){
            $response = null;
        }
        return $response;

    }

    /**
     * @return int
     */
    public static function totalListAgents() {
        global $wpdb;
        $kandyUserTable = $wpdb->prefix . 'kandy_users';
        $mainUserTable = $wpdb->prefix . 'users';
        $agentType = KANDY_USER_TYPE_AGENT;
        $rateTable = $wpdb->prefix . 'kandy_live_chat_rate';
        $sql = "SELECT count($kandyUserTable.id)
                FROM $mainUserTable
                INNER JOIN $kandyUserTable ON $mainUserTable.ID = $kandyUserTable.main_user_id
                LEFT JOIN $rateTable ON $mainUserTable.id = $rateTable.main_user_id
                WHERE $kandyUserTable.type = $agentType";
        ;
        $result = $wpdb->get_var($sql);
        return (int) $result;
    }

    public static function getListAgents($limit, $offset) {
        global $wpdb;
        $kandyUserTable = $wpdb->prefix . 'kandy_users';
        $mainUserTable = $wpdb->prefix . 'users';
        $agentType = KANDY_USER_TYPE_AGENT;
        $rateTable = $wpdb->prefix . 'kandy_live_chat_rate';
        $sql = "SELECT $kandyUserTable.id AS id, $mainUserTable.user_email,
                  user_nicename, user_id AS kandy_user, $kandyUserTable.main_user_id, avg($rateTable.point) as average, comment
                FROM $mainUserTable
                INNER JOIN $kandyUserTable ON $mainUserTable.ID = $kandyUserTable.main_user_id
                LEFT JOIN $rateTable ON $mainUserTable.id = $rateTable.main_user_id
                WHERE $kandyUserTable.type = $agentType
                GROUP BY $mainUserTable.ID
                ORDER BY average DESC
                LIMIT $offset,$limit";
        ;
        $users = $wpdb->get_results($sql,ARRAY_A);
        foreach ($users as &$user){
            $urlRemove = self::page_url(
                array(
                    "action" => "remove",
                    "id" => $user['id']
                )
            );
            $urlView = self::page_url(array(
                'action'    => 'view',
                'id'        => $user['main_user_id']
            ));
            $user['action'] = '<a href="'. $urlRemove .'" class="button">Remove</a>';
            $user['action'] .= '<a href="'.$urlView.'" class="button">View</a>';
        }
        return $users;
    }

    /**
     * Get user for agent assignment
     * @return mixed
     */
    public static function getUsersForChatAgent(){
        global $wpdb;
        $kandyUserTable = $wpdb->prefix . 'kandy_users';
        $mainUserTable = $wpdb->prefix . 'users';
        $agentType = KANDY_USER_TYPE_AGENT;
        $sql =  "SELECT $kandyUserTable.id as id, $mainUserTable.user_nicename
                FROM $mainUserTable
                INNER JOIN $kandyUserTable
                ON $mainUserTable.id = $kandyUserTable.main_user_id
                WHERE $kandyUserTable.type is null or $kandyUserTable.type <> $agentType";
        $users = $wpdb->get_results($sql);
        return $users;

    }

    /**
     * @param $agentId
     *
     * @return int
     */
    public static function totalAgentRates($agentId) {
        global $wpdb;
        $tableRate = $wpdb->prefix . 'kandy_live_chat_rate';
        $agentId = intval($agentId);
        $sql = "SELECT count(*) FROM $tableRate WHERE main_user_id = $agentId ORDER BY rated_time DESC";
        $result = $wpdb->get_var($sql);
        return (int) $result;
    }

    /**
     * Get rating info of agent
     * @param $agentId
     * @param $limit
     * @param $offset
     * @return array|null
     */
    public static function getAgentRates($agentId, $limit, $offset)
    {
        global $wpdb;
        $tableRate = $wpdb->prefix . 'kandy_live_chat_rate';
        $agentId = intval($agentId);
        $agentRates = $wpdb->get_results(
            "SELECT * FROM $tableRate WHERE main_user_id = $agentId ORDER BY rated_time DESC LIMIT $offset,$limit",
            ARRAY_A
        );
        return $agentRates;
    }

    public static function logKandyUserStatus($kandyUserId, $userType, $logType = KANDY_USER_STATUS_ONLINE){
        global $wpdb;
        $userLoginTable = $wpdb->prefix . 'kandy_user_login';
        $now = time();
        $affectedRows = $wpdb->update(
            $userLoginTable,
            array(
                'status' => $logType,
                'time'  => $now
            ),
            array(
                'kandy_user_id' => $kandyUserId
            )
        );
        if(!$affectedRows){
            $wpdb->insert(
                $userLoginTable,
                array(
                    'kandy_user_id' => $kandyUserId,
                    'type'          => $userType,
                    'status'        => $logType,
                    'browser_agent' => '',
                    'ip_address'    => $_SERVER['REMOTE_ADDR'],
                    'time'          => $now
                ), array('%s', '%d', '%d', '%s', '%s')
            );
        }

    }
}
