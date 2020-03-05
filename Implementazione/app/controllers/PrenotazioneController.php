<?php

require_once __DIR__ . "/../core/Controller.php";

class PrenotazioneController extends Controller
{
    private $registroPrenotazioni;



    public function cancellaPrenotazioniScadute(){
        $this->registroPrenotazioni->cancellaPrenotazioniScadute();
    }

}