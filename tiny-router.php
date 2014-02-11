<?php

class TinyRouter {
    public $requestType;
    public $params;
    public $url;
    public $query;
    public $path;
    public $notmatch = true;
    private $_user;
    private $_password;
    private $_basePath;

    public function user($str = ''){
        if($str){
            $this->_user = $str;
            $this->init();
        }

        return $this->_user;
    }

    public function password($str = ''){
        if($str){
            $this->_password = $str;
            $this->init();
        }

        return $this->_password;
    }

    public function basePath($str = ''){
        if($str){
            $this->_basePath = $str;
            $this->init();
        }

        return $this->_basePath;
    }
    
    private function init(){
        $bp = $this->_basePath;
        $pd = parse_url($this->url);
        $this->path = mb_ereg_replace("^$bp",'',$pd['path']);
        if(array_key_exists('query', $pd)){
            $this->query = $pd['query'];
        }
    }

    public function __construct($basePath = ''){
        global $_SERVER,$_GET,$_POST;

        $this->_basePath = $basePath;
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->params = ($this->requestType == 'GET')? $_GET : $_POST;
        $this->init();
    }

    public function response($method, $reg, $filepath){
        $req = $this->requestType;
        $path = $this->path;
        $params = $this->params;
        $mt = str_replace(' ','',$method);

        if($req == $mt || $mt == 'GET|POST' || $mt == 'POST|GET'){
            if(mb_ereg_match("^$reg$", $path)){
                $this->notmatch = false;
                $p = mb_ereg_replace("^$reg$",$filepath,$path);
                $parsed = parse_url($p);
                $newpath = $parsed['path'];
                parse_str($parsed['query'], $_GET);
                $this->renderPhp($newpath);
            }
        }
    }

    public function responseAuth($method, $reg, $filepath){
        if(!isset($_SERVER["PHP_AUTH_USER"])) {
            header("WWW-Authenticate: Basic realm=\"Authorization Required\"");
            header("HTTP/1.0 401 Unauthorized");

            die("Authorization Required");
        }
        else {
            if ($_SERVER['PHP_AUTH_USER'] == $this->_user && $_SERVER['PHP_AUTH_PW'] == $this->_password){
                $this->response($method, $reg, $filepath);
            }else {
                die("Authorization Required");
            }
        }
    }

    public function renderPhp($file){
        include $file;
    }
}
?>