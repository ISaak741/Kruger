<?php

namespace Application;

class Request
{
  public $data, $method, $url;
  public function __construct($method, $url)
  {
    $this->method = $method;
    $this->data = ($method == "GET") ? $_GET : $_POST;
    $this->url = explode('?', $url)[0];
  }
}
