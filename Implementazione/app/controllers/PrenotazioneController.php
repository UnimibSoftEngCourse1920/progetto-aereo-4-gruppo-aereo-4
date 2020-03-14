<?php

require_once __DIR__ . "/../core/Controller.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/models/cliente/RegistroClienti.php";

class PrenotazioneController extends Controller
{
    private $registroPrenotazioni;
    private $registroClienti;

    public function __construct()
    {
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->registroClienti = new RegistroClienti();
    }

    public function controlloPrenotazioniScadute(){
        $this->registroPrenotazioni->controlloPrenotazioniScadute();
    }

    public function prenota($idVolo, $viaggiatori) {
        $registro = $this->model('volo/RegistroVoli');
        $volo = $registro->getVolo($idVolo);
        $this->view('prenotazione/prenotazione', ["volo"=> $volo,"pass"=>$viaggiatori]);
    }

    public function effettuaPrenotazione($nome = "", $cognome = "", $email = "",$dataNascita,$listaPasseggeri,$idVolo,$nPosti = "",$tariffa) {
        if(isset($_SESSION["id_cliente"])){
            $cliente = $this->registroClienti->getCliente($_SESSION["id_cliente"]);
        } else {
            $cliente = new Cliente($nome, $cognome, $email, $dataNascita);
        }
        $p = $this->registroPrenotazioni->effettuaPrenotazione($cliente,json_decode($listaPasseggeri,true),$idVolo,$nPosti,$tariffa);
        if($p!=false){
            $this->view('prenotazione/prenotazione', ["idCliente"=> $cliente->getOID(),"prenotazione"=>$p->getOID()]);
        } else {
            $this->view('prenotazione/prenotazione',["error","Errore durante la prenotazione"]);
        }
    }

    public function gestionePrenotazione($idPrenotazione){
        $prenotazione = $this->registroPrenotazioni->getPrenotazione($idPrenotazione);
        $cliente = $prenotazione->getCliente();
        $acquistato = false;
        if($prenotazione->getListaAcquisti() != null){
            $acquistato = true;
        }

        $this->view('prenotazione/gestioneprenotazione', ["idPrenotazione"=>$idPrenotazione,"idCliente","acquistato"=>$acquistato]);
    }
}
