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
        if(isset($idVolo) && isset($viaggiatori) && isset($nome) && isset($cognome) && isset($email) && isset($nPosti)) {
            //header('Location: /public/vendita/acquista');
        }
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo,"pass"=>$viaggiatori]);
    }
}
