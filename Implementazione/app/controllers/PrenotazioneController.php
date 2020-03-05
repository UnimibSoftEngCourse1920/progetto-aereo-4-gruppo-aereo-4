<?php

require_once __DIR__ . "/../core/Controller.php";

class PrenotazioneController extends Controller
{
    public function prenota($idVolo) {
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo]);
    }
}