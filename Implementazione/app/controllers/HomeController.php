<?php

require_once "../app/core/Controller.php";
require_once "../app/models/servizi/DBFacade.php";

class HomeController extends Controller {
	
	public function index() {
	    $aeroporti = DBFacade::getIstance()->getAll("Aeroporto");
		$this->view('home/index', ["aeroporti" => $aeroporti]);
	}
	
}