<?php

class Mailer{
    //Da inserire nel diagramma
    private $email;
    private $password;

    public function inviaCancellazioneFedelta($cliente){

    }

    //Sarebbe meglio fare un nuovo thread per questo
    public function inviaEmailModificaVolo($listaClienti, $volo){

        $recipients = $this->generateRecipients($listaClienti);
        $message = "Gentile cliente, \n
                    Ti informiamo che il tuo volo è stato modificato. \n
                    Riportiamo di seguito le nuove informazioni aggiornate:\n
                    Partenza: $volo->getAereoportoPart()->getNome() \n
                    $volo->getData() - $volo->getOrarioPartenza() \n\n
                    Arrivo: $volo->getAereoportoDest()->getNome()\n
                    $volo->getOrarioArrivo()\n\n
                    Ci scusiamo per il disguido,
                    Buona giornata\n\n
                    GruppoAereo4";

        mail($recipients , "Avviso modifica volo",$message);
    }

    //Sarebbe meglio fare un nuovo thread per questo
    public function inviaEmailCancellazioneVolo($listaClienti, $volo){

        $recipients = $this->generateRecipients($listaClienti);
        $message = "Gentile cliente, \n
                    Ti informiamo che il tuo volo \n
                    Partenza: $volo->getAereoportoPart()->getNome() \n
                    $volo->getData() - $volo->getOrarioPartenza() \n\n
                    Arrivo: $volo->getAereoportoDest()->getNome()\n
                    $volo->getOrarioArrivo()\n\n
                    E' stato cancellato. \n
                    Ci scusiamo per il disguido,
                    Buona giornata\n\n
                    GruppoAereo4";

        mail($recipients , "Avviso cancellazione volo",$message);
    }

    public function inviaEmailCodiceFedelta($email, $codiceFedelta){
        $message = "Gentile cliente, \n
                    Grazie per esserti iscritto al nostro programma fedeltà!\n
                    Il tuo codice è: $codiceFedelta \n
                    Utilizzalo per acquistare ed accumulare punti.\n
                    Buona giornata\n\n
                    GruppoAereo4
                    ";

        mail($email, 'Conferma iscrizione programma fedeltà', $message);
    }

    public function inviaComunicazioneInfedelta($cliente){
        $message = 'INFEDELEEEE!!!!';
        mail($cliente->getEmail(), 'Avviso infedeltà', $message);
    }

    private function generateRecipients($listaClienti){
        $recipients = array();
        foreach ($listaClienti as $cliente){
            array_push($recipients, $cliente->getEmail());
        }
        return implode(',',$recipients);
    }
}


