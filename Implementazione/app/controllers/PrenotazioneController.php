<?php

require_once __DIR__ . "/../core/Controller.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";

class PrenotazioneController extends Controller
{
    private $registroPrenotazioni;

    public function __construct()
    {
        $this->registroPrenotazioni = new RegistroPrenotazioni();
    }

    public function controlloPrenotazioniScadute(){
        $this->registroPrenotazioni->controlloPrenotazioniScadute();
    }

    public function prenota($idVolo, $viaggiatori) {
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo,"pass"=>$viaggiatori]);
    }

    public function effettuaPrenotazione($nome = "", $cognome = "", $email = "",$listaPasseggeri,$idVolo,$nPosti = "",$tariffa) {
        $cliente = new Cliente($nome,$cognome,$email,null);
        $p = $this->registroPrenotazioni->effettuaPrenotazione($cliente,json_decode($listaPasseggeri,true),$idVolo,$nPosti,$tariffa);
        var_dump($p);
        //$this->view('prenotazione/prenotazione', ["volo"=> $volo,"pass"=>$viaggiatori]);
    }
}
