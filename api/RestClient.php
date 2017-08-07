<?php
class RestClientException extends Exception
{
}

class RestClient
{
    protected $_submitted = false;
    protected $_headers = array();
    protected $_body = '';

    /**
     * Http Request to server use method GET
     *
     * @param $uri
     * @param array $headers
     * @param int $timeout
     * @return $this
     * @throws RestClientException
     */
    public function get($uri, $headers = array(), $timeout = 30)
    {
        if (!function_exists('curl_init')) {
            throw new RestClientException('curl_init functions are not available.');
        }

        $ch = curl_init($uri);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            KANDY_SSL_VERIFY
        );
        if (is_array($headers) && count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (curl_errno($ch)) {
            throw new RestClientException(curl_errno($ch));
        }
        $this->_submitted = true;
        $this->_body = curl_exec($ch);
        $this->_headers = curl_getinfo($ch);

        curl_close($ch);
        return $this;
    }

    /**
     * Http Request to server use method POST.
     *
     * @param $uri
     * @param $payload
     * @param array $headers
     * @param int $timeout
     * @return $this
     * @throws RestClientException
     */
    public function post($uri, $payload, $headers = array(), $timeout = 30)
    {
        if (!function_exists('curl_init')) {
            throw new RestClientException('curl_init functions are not available.');
        }

        $ch = curl_init($uri);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            KANDY_SSL_VERIFY
        );
        if (is_array($headers) && count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (curl_errno($ch)) {
            throw new RestClientException(curl_errno($ch));
        }

        $this->_submitted = true;
        $this->_body = curl_exec($ch);
        $this->_headers = curl_getinfo($ch);
        curl_close($ch);
        return $this;
    }

    /**
     * Http Request to server use method PUT.
     *
     * @param $uri
     * @param $payload
     * @param array $headers
     * @param int $timeout
     * @return $this
     * @throws RestClientException
     */
    public function put($uri, $payload, $headers = array(), $timeout = 30)
    {
        if (!function_exists('curl_init')) {
            throw new RestClientException('curl_init functions are not available.');
        }

        $ch = curl_init($uri);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            KANDY_SSL_VERIFY
        );
        if (is_array($headers) && count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (curl_errno($ch)) {
            throw new RestClientException(curl_errno($ch));
        }

        $this->_submitted = true;
        $this->_body = curl_exec($ch);
        $this->_headers = curl_getinfo($ch);

        curl_close($ch);
        return $this;
    }

    /**
     * Http Request to server use method DELETE.
     * @param $uri
     * @param array $headers
     * @param int $timeout
     * @return $this
     * @throws RestClientException
     */
    public function delete($uri, $headers = array(), $timeout = 30)
    {
        if (!function_exists('curl_init')) {
            throw new RestClientException('curl_init functions are not available.');
        }

        $ch = curl_init($uri);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_SSL_VERIFYPEER,
            KANDY_SSL_VERIFY
        );
        if (is_array($headers) && count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if (curl_errno($ch)) {
            throw new RestClientException(curl_errno($ch));
        }
        $this->_submitted = true;
        $this->_body = curl_exec($ch);
        $this->_headers = curl_getinfo($ch);

        curl_close($ch);
        return $this;
    }

    /**
     * Get status text from response.
     * @return int|string
     */
    public function getStatusText()
    {
        if ($this->_submitted) {
            return $this->getStatusCode();
        }
        return 'UNKNOWN';
    }

    /**
     * Get status code from response.
     * @return int|string
     */
    public function getStatusCode()
    {
        if ($this->_submitted) {
            return $this->getHeader('http_code');
        }
        return 0;
    }

    /**
     * Get Header from Response.
     * @param $index
     * @return string
     */
    public function getHeader($index)
    {
        if (isset($this->_headers[$index])) {
            return $this->_headers[$index];
        }
        return 'N/A';
    }

    /**
     * Get content from respone.
     * @return string
     */
    public function getContent()
    {
        return $this->_body;
    }

    /**
     * Get Header from response.
     * @return array
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Get time from response.
     * @return string
     */
    public function getTime()
    {
        return $this->getHeader('total_time');
    }
}
