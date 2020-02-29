<?php


namespace model\cliente;


class RegistroClienti
{
    //lista clienti

    public function checkEmailClientefedelta($email)
    {
        $mailExists = DB . getIstance() . emailFedeltaExists($email);
        return $mailExists;
    }

    public function getNuovoCodiceFedelta()
    {
        //Chiede al DB oppure lui sa qual'è l'ultimo (Attenzione! Se sono più di uno è un macello)
    }

    public function nuovoClienteFedelta($datiCliente)
    {
        $codice = getNuovoCodiceFedelta();
        $nuovoCliente = new ClienteFedele($datiCliente, $codice);
        DB . getIstance() . put($nuovoCliente);
    }
}

