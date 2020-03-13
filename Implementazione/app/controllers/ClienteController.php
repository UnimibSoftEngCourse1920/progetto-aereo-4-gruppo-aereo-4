<?php

require_once "../app/models/cliente/RegistroClienti.php";
require_once "../app/models/volo/RegistroPromozioni.php";
require_once "../app/models/prenotazione/RegistroPrenotazioni.php";
require_once "../app/core/Controller.php";

class ClienteController extends Controller{

    private $registroClienti;
    private $registroPrenotazioni;
    private $registroPromozioni;

    public function __construct(){
        $this->registroClienti = new RegistroClienti();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->registroPromozioni = new RegistroPromozioni();
    }

    public function annullaIscrizione($codiceFedelta){
        $esito = $this->registroClienti -> annullaIscrizione($codiceFedelta);
        if($esito) {
            session_destroy();
            header("Location: https://gruppoaereo4.000webhostapp.com/public/");
        }
        else {
            //TODO esito negativo
        }
    }

    public function iscrizioneFedelta($nome = "", $cognome = "", $email = "", $dataNascita = "", $indirizzo = "",
                                        $password = "", $confermaPassword = "") {
        //$registroClienti = $this->model('cliente/RegistroClienti');
        $error = "";
        if($nome != "" && $cognome != "" && $indirizzo != "" && $dataNascita != "" && $email != "" && $password != "") {
            if($password == $confermaPassword) {
                //Converto il formato della data
                $esito = $this->registroClienti ->nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo,
                                                                        $password);
                if ($esito) {
                    header("Location: /public/cliente/registrato");
                } else {
                    $error = "L'indirizzo e-mail è già registrato.";
                }
            } else {
                $error = "Le due password non coincidono.";
            }
        }
        $this->view('cliente/registrazione', ["error" => $error]);
    }

    public function ricercaClientiInfedeli(){
        $this->registroPrenotazioni->controlloInfedeli();
    }

    public function avvisaPromozioniFedelta() {
        $listaPromozioni = $this->registroPromozioni -> getPromozioniFedelta();
        $this->registroClienti->avvisaClientiFedelta($listaPromozioni, RegistroClienti::$AVVISAPROMOZIONI);
    }

    public function registrato() {
        $this->accedi("", "", "Account registrato! Accedi compilando il form.");
    }

    public function accedi($email = "", $password = "", $success = "") {
        $error = "";
        if($email != "" && $password != "") {
            $esitoLogin = $this->login($email, $password);
            if($esitoLogin) {
                header("Location: /");
            } else {
                $error = "Combinazione email/password non trovata.";
            }
        }
        $this->view('cliente/login', ["error" => $error, "success" => $success]);
    }

    public function login($email, $password) {
        $registroClienti = $this->model('cliente/RegistroClienti');
        $cliente = $registroClienti->login($email, $password);
        if ($cliente->getOID()) {
            $_SESSION['id_cliente'] = $cliente->getOID();
            $_SESSION['nome_cliente'] = $cliente->getNome() . " " . $cliente->getCognome();
            return true;
        } else {
            return false;
        }
    }

    public function esci() {
        session_destroy();
        header('Location: /');
    }

    public function prenotazioni() {
        $cliente = $this->registroClienti->getCliente($_SESSION["id_cliente"]);
        $prenotazioni = $this->registroPrenotazioni->getPrenotazioniCliente($_SESSION["id_cliente"]);
        $this->view('cliente/fedelta', ["prenotazioni" => $prenotazioni, "cliente" => $cliente]);
    }

    public function richiediEstrattoConto($OIDCliente){
        //TODO implementare errori
        $estrattoConto = $this->registroPrenotazioni->generaEstrattoConto($OIDCliente);
        if($estrattoConto != null){
            echo "ESTRATTO OK";
        }
        echo "ERRORE";
    }

}
