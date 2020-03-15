<?php

require_once "../app/core/Controller.php";
require_once "../app/models/volo/RegistroVoli.php";
require_once "../app/models/volo/RegistroPromozioni.php";


class HomeController extends Controller {

    private $registroVoli;

    public function __construct()
    {
        $this->registroVoli = new RegistroVoli();
        $this->registroPromozioni = new RegistroPromozioni();
    }

    public function index() {
	    $aeroporti = $this->registroVoli->getAeroporti();
	    $promozione = $this->registroPromozioni->getMigliorPromozioneAttiva();
        $promozioniVoli = $this->registroVoli->getVoliConPromozione();

		$this->view('home/index', ["aeroporti" => $aeroporti,"promozioneBanner" => $promozione,"voli"=>$promozioniVoli]);
	}
	
}