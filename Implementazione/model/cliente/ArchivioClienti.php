<?php
class ArchivioClienti{
  //lista clienti

  public function checkEmailClientefedelta($email){
    mail_exists = DB.getIstance().emailFedeltaExists($email);
    return mail_exists;
  }

  public function getNuovoCodiceFedelta(){
    //Chiede al DB oppure lui sa qual'è l'ultimo (Attenzione! Se sono più di uno è un macello)
  }

  public function nuovoClienteFedelta($datiCliente){
    $codice = getNuovoCodiceFedelta();
    $nuovoCliente = new ClienteFedele($datiCliente, $codice);
    DB.getIstance().put($nuovoCliente);
  }
} ?>
