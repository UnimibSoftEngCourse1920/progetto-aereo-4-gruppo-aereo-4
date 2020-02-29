<?php


namespace model\cliente;


use model\servizi\DB;

class RegistroClienti
{
    //lista clienti

    public function checkEmailClientefedelta($email)
    {
        $mailExists = DB::getIstance() -> emailFedeltaExists($email);
        return $mailExists;
    }

    private function generaNuovoCodice()
    {
        //Chiede al DB oppure lui sa qual'è l'ultimo (Attenzione! Se sono più di uno è un macello)
        return '';
    }

    public function nuovoClienteFedelta($datiCliente)
    {
        $codice = $this -> generaNuovoCodice();
        $nuovoCliente = new ClienteFedelta($datiCliente, $codice);
        $esito = DB::getIstance() -> put($nuovoCliente);
        //devo controllare che esito mi ritorna il DB e tornarlo al controller
        //per ora ritorno sempre true
        if ($esito)
            return $nuovoCliente;
        else
            return null;

    }

    public function getCliente($codiceFedelta){
        return DB::getIstance() -> get($codiceFedelta);
    }

}

