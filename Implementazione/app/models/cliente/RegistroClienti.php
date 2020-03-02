<?php


namespace model\cliente;


use model\servizi\DB;
use model\servizi\OIDGenerator;

class RegistroClienti
{
    //lista clienti

    public function checkEmailClienteFedelta($email)
    {
        $mailExists = DB::getIstance() -> emailFedeltaExists($email);
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
        $esito = DB::getIstance() -> put($nuovoCliente);
        //devo controllare che esito mi ritorna il DB e tornarlo al controller
        //per ora ritorno sempre true
        if ($esito)
            return $nuovoCliente;
        else
            return null;
    }

    public function getCliente($codiceFedelta){
        //per ora è deprecated
        return DB::getIstance() -> get($codiceFedelta);
    }

    public function annullaIscrizione($codiceFedelta){
        $db = DB::getIstance();
        $cliente = $db->get($codiceFedelta);
        if ($cliente != null) {
            $cliente->annullaIscrizioneFedelta();
            DB::getIstance()->update($cliente);
            //cosa faccio se non va a buon fine
        }
        return $cliente;
    }

}

