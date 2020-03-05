<?php

require_once __DIR__ . "/../core/Controller.php";

class PrenotazioneController extends Controller
{
    private $registroPrenotazioni;


    public function cancellaPrenotazioniScadute(){
        $this->registroPrenotazioni->cancellaPrenotazioniScadute();
    }

    public function prenota($idVolo) {
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo]);
    }
}
