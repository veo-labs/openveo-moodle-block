<?php

class RestClientException extends Exception{}

/**
 * Defines a REST Curl client with common GET, POST, PUT, DELETE HTTP 
 * methods.
 */
class RestCurlClient{
  
  /** Curl handle */
  public $handle;
  
  /** Curl options */
  public $httpOptions;

  /**
   * Builds a new RestCurlClient.
   */
  function __construct(){}

  /**
   * Init A curl object for WS authentication
   * Get an authentication token
   * @param array $headers A list of headers   
   */
  function initCurl($headers = array()){
    $curlCookieJar = tempnam(sys_get_temp_dir(), "cookies_");

    // Prepare curl default options
    $this->httpOptions = array();
    $this->httpOptions[CURLOPT_HTTPHEADER] = $headers;
    $this->httpOptions[CURLOPT_RETURNTRANSFER] = true;
    $this->httpOptions[CURLOPT_FOLLOWLOCATION] = false;
    $this->httpOptions[CURLOPT_COOKIESESSION] = false;
    $this->httpOptions[CURLOPT_COOKIEJAR] = $curlCookieJar;
    $this->httpOptions[CURLOPT_COOKIEFILE] = $curlCookieJar;
    $this->httpOptions[CURLOPT_HEADER] = false;
    $this->httpOptions[CURLOPT_CONNECTTIMEOUT] = 1;
    $this->httpOptions[CURLOPT_TIMEOUT] = 30;
    
    // Initialize curl session
    $this->handle = curl_init();
  }

  /**
   * Executes curl request.
   * Curl object is destroy after a call.
   */
  function execCurl(){
    if($this->handle){
      $this->responseObject = curl_exec($this->handle);
      curl_close($this->handle);
    }
  }

  /**
   * Performs a GET call to server.
   *
   * @param string $url The url to make the call to.
   * @param array $httpOptions Extra option to pass to curl handle.
   * @return string The response from curl if any
   */
  function get($url, $httpHeaders = array(), $httpOptions = array()){
    $this->initCurl($httpHeaders);
    $httpOptions = $httpOptions + $this->httpOptions;
    $httpOptions[CURLOPT_CUSTOMREQUEST] = 'GET';
    $httpOptions[CURLOPT_URL] = $url;

    if(!curl_setopt_array($this->handle, $httpOptions))
      throw new RestClientException('Error setting cURL request options');
      
    $this->execCurl();
    return $this->responseObject;
  }

  /**
   * Performs a POST call to the server
   *
   * @param string $url The url to make the call to.
   * @param string|array The data to post. Pass an array to make a http form post.
   * @param array $httpOptions Extra option to pass to curl handle.
   * @return string The response from curl if any
   */
  function post($url, $fields = array(), $httpHeaders = array(), $httpOptions = array()){
    $this->initCurl($httpHeaders);
    $httpOptions = $httpOptions + $this->httpOptions;
    $httpOptions[CURLOPT_POST] = true;
    $httpOptions[CURLOPT_URL] = $url;
    $httpOptions[CURLOPT_POSTFIELDS] = $fields;
    if(is_array($fields)){
      $httpOptions[CURLOPT_HTTPHEADER] = array(
          'Content-Type: multipart/form-data'
      );
    }
    if(!curl_setopt_array($this->handle, $httpOptions))
      throw new RestClientException('Error setting cURL request options.');
    
    $this->execCurl();
    return $this->responseObject;
  }

  /**
   * Performs a PUT call to the server
   *
   * @param string $url The url to make the call to.
   * @param string|array The data to post.
   * @param array $httpOptions Extra option to pass to curl handle.
   * @return string The response from curl if any
   */
  function put($url, $data = '', $httpHeaders = array(), $httpOptions = array()){
    $this->initCurl($httpHeaders);
    $httpOptions = $httpOptions + $this->httpOptions;
    $httpOptions[CURLOPT_CUSTOMREQUEST] = 'PUT';
    $httpOptions[CURLOPT_POSTFIELDS] = $data;
    $httpOptions[CURLOPT_URL] = $url;
    if(!curl_setopt_array($this->handle, $httpOptions))
      throw new RestClientException('Error setting cURL request options.');

    $this->execCurl();
    return $this->responseObject;
  }

  /**
   * Performs a DELETE call to server
   *
   * @param string $url The url to make the call to.
   * @param array $httpOptions Extra option to pass to curl handle.
   * @return string The response from curl if any
   */
  function delete($url, $httpHeaders = array(), $httpOptions = array()){
    $this->initCurl($httpHeaders);
    $httpOptions = $httpOptions + $this->httpOptions;
    $httpOptions[CURLOPT_CUSTOMREQUEST] = 'DELETE';
    $httpOptions[CURLOPT_URL] = $url;
    if(!curl_setopt_array($this->handle, $httpOptions))
      throw new RestClientException('Error setting cURL request options.');
    
    $this->execCurl();
    return $this->responseObject;
  }

}
