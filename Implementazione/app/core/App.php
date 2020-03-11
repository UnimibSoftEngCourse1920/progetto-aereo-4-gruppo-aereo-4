<?php

class App {
	
	protected $controller = 'HomeController';
	protected $method = 'index';
	protected $params = [];
	
	public function __construct() {
		$url = $this->parseUrl();
		
		//Recupero il controller e lo istanzio
        $url[0] = ucfirst($url[0])."Controller";
		if(file_exists('../app/controllers/'.$url[0].'.php')) {
			$this->controller = $url[0];
			unset($url[0]);
		}
		require_once '../app/controllers/'.$this->controller.'.php';
		$this->controller = new $this->controller;

		//Recupero metodo e parametri
		if(isset($url[1]) && method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
		}

		$this->params = $url ? array_values($url) : [];

		//Chiamo il metodo, passando anche i parametri in post
		call_user_func_array([$this->controller, $this->method], array_merge($this->params, $_POST));
	}
	
	public function parseUrl() {
		if(isset($_GET['url'])) { //Cambiare senza htaccess ??? $_REQUEST
			return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
	
}