<?php

require_once "../app/models/servizi/DBFacade.php";

class RegistroClienti
{
    public static $AVVISACANCELLAZIONEFEDELTA = "CANCELLAZIONEFEDELTA";
    public static $AVVISACLIENTEINFEDELE = "CLIENTEINFEDELE";

    public $mailer;

    //lista clienti

    public function __construct()
    {
        $this->mailer = new Mailer();
    }

    public function checkEmailClienteFedelta($email)
    {
        $mailExists = DBFacade::getIstance() -> emailFedeltaExists($email);
        return $mailExists;
    }

    private function generaCodiceFedelta()
    {
        //La generazione del codice è ancora da vedere
        //Chiede al DB oppure lui sa qual'è l'ultimo (Attenzione! Se sono più di uno è un macello)
        return '';
    }

    public function nuovoClienteFedelta($nome, $cognome, $email, $dataNascita, $indirizzo, $username, $password)
    {
        $codice = $this -> generaCodiceFedelta();
        $OID = OIDGenerator::getIstance()->getNewOID();
        $nuovoCliente = new ClienteFedelta($nome, $cognome, $email, $dataNascita, $codice, $indirizzo, $username, $password, $OID);
        $esito = DBFacade::getIstance() -> put($nuovoCliente);
        //devo controllare che esito mi ritorna il DB e tornarlo al controller
        //per ora ritorno sempre true
        if ($esito)
            return $nuovoCliente;
        else
            return null;
    }

    public function getCliente($codiceFedelta){
        //per ora è deprecated
        return DBFacade::getIstance() -> get($codiceFedelta);
    }

    public function annullaIscrizione($OID){
        $db = DBFacade::getIstance();
        $cliente = $db->get($OID);
        if ($cliente != null) {
            $cliente->annullaIscrizioneFedelta();
            $esito = DBFacade::getIstance()->update($cliente);
            $this->mailer->inviaCancellazioneFedelta($cliente);
            return true && $esito;
        }
        return false;
    }

    public function avvisaCliente($OID, $tipologiaAvviso){
        $cliente = DBFacade::getIstance()->get($OID);

        switch ($tipologiaAvviso){
            case RegistroClienti::$AVVISACANCELLAZIONEFEDELTA:
                $this->mailer->inviaCancellazioneFedelta($cliente);
                break;

            case RegistroClienti::$AVVISACLIENTEINFEDELE:
                $this->mailer->inviaComunicazioneInfedelta($cliente);
                break;

        }
    }

    public function setClienteInfedele($OID){
        $cliente = DBFacade::getIstance()->get($OID);
        if($cliente!=null) {
            $cliente->setStato(ClienteFedelta::$STATOINFEDELE);
            $esito = DBFacade::getIstance()->update($cliente);
            $this->mailer->inviaComunicazioneInfedelta($cliente);
            //Controllo anche esito del mailer? NO
            return $esito;
        }
        return false;
    }

	
	/*public function getCliente($idCliente) {
		$cliente = DBFacade::getIstance()->getCliente($idCliente);
		return $cliente;
	}*/
		
	public function aggiornaCliente($cliente) {
		DBFacade::getIstance()->aggiornaCliente($cliente);
	}

	public function login($email, $password) {
        $cliente = DBFacade::getIstance()->userLogin($email, md5($password));
        return $cliente;
    }

}

