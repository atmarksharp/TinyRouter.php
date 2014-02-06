<?php

class TinyRouter {
	public $requestType;
	public $params;
	public $url;
	public $query;
	public $path;
	private $_basePath;

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
        $this->query = $pd['query'];
    }

	public function __construct($basePath = ''){
		global $_SERVER,$_GET,$_POST;

		$this->_basePath = $basePath;
		$this->layoutFile = $this->defaultLayout;
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
    			$p = mb_ereg_replace("^$reg$",$filepath,$path);
    			$parsed = parse_url($p);
    			$newpath = $parsed['path'];
    			parse_str($parsed['query'], $_GET);
    			$this->renderPhp($newpath);
    		}
    	}
    }

    public function renderPhp($file){
    	include $file;
    }
}
?>