<?php

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

    public function annullaIscrizione($codiceFedelta){
        $db = DBFacade::getIstance();
        $cliente = $db->get($codiceFedelta);
        if ($cliente != null) {
            $cliente->annullaIscrizioneFedelta();
            DBFacade::getIstance()->update($cliente);
            //cosa faccio se non va a buon fine
        }
        return $cliente;
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
        $cli = DBFacade::getIstance()->get($OID);
        $cli->setStato(ClienteFedelta::$STATOINFEDELE);
        DBFacade::getIstance()->update($cli);
        //ritorno esito di tutte le op.
        return true;
    }
	
	/*public function getCliente($idCliente) {
		$cliente = DBFacade::getIstance()->getCliente($idCliente);
		return $cliente;
	}*/
		
	public function aggiornaCliente($cliente) {
		DBFacade::getIstance()->aggiornaCliente($cliente);
	}

}

