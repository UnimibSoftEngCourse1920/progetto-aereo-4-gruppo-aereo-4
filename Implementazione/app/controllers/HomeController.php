<?php

class HomeController extends Controller {
	
	public function index($name = '') {
		$this->view('home/index');
	}
	
}