<?php

require_once __DIR__ . "/../core/Controller.php";

class PrenotazioneController extends Controller
{
    private $registroPrenotazioni;


    public function cancellaPrenotazioniScadute(){
        $this->registroPrenotazioni->cancellaPrenotazioniScadute();
    }

    //Metodo temporaneo
    public function prenota($idVolo, $viaggiatori, $nome = "", $cognome = "", $email = "", $nPosti = "") {
        if(isset($idVolo) && isset($nome) && isset($cognome) && isset($email) && isset($nPosti)) {
            header('Location: /public/vendita/acquista');
        }
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo]);
    }
}
