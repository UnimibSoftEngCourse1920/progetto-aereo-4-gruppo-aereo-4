<?php

class Mailer{
    //TODO Da inserire nel diagramma
    private $email;
    private $password;

    public function inviaCancellazioneFedelta($cliente){
        $message = "Sei stato cancellato dal progarmma fedeltà";
        mail($cliente->getEmail(), "Cancellazione programma fedeltà", $message);
    }

    public function inviaEmailModificaVolo($listaClienti, $volo){

        $recipients = $this->generateRecipients($listaClienti);
        $message = "Gentile cliente, \n
                    Ti informiamo che il tuo volo è stato modificato. \n
                    Riportiamo di seguito le nuove informazioni aggiornate:\n
                    Partenza: %s    %s\n
                    Arrivo:   %s    %s\n
                    Ci scusiamo per il disguido,
                    Buona giornata\n\n
                    GruppoAereo4";

        $message = sprintf($message, $volo->getaeroportoPartenza()->getNome(), $volo->getDataOraPartenza(), $volo->getaeroportoDestinazione(), $volo -> getDataOraArrivo());

        mail($recipients , "Avviso modifica volo",$message);
    }

    public function inviaEmailCancellazioneVolo($listaClienti, $volo){

        $recipients = $this->generateRecipients($listaClienti);
        $message = "Gentile cliente, \n
                    Ti informiamo che il tuo volo \n
                    Partenza: %s    %s \n
                    Arrivo:   %s    %s \n
                    E' stato cancellato. \n
                    Ci scusiamo per il disguido,
                    Buona giornata\n\n
                    GruppoAereo4";

        $message = sprintf($message, $volo->getAeroportoPartenza()->getNome(), $volo->getDataOraPartenza(), $volo->getaeroportoDestinazione()->getNome(), $volo -> getDataOraArrivo());
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

    public function inviaEmailBiglietti($email, $pdf){
        $email = "o.zaher@campus.unimib.it";
        $content = file_get_contents($pdf);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));

        $header = "From: Gruppo Aereo 4 <gruppoaereo4@gmail.com>\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

        $plainMessage = "Gentile cliente, \n".
                    "In allegato trovi i biglietti da te acquistati.\n".
                    "Buona giornata\n\n".
                    "GruppoAereo4";

        $message = "--".$uid."\r\n";
        $message .= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message .= $plainMessage."\r\n\r\n";
        $message .= "--".$uid."\r\n";
        $message .= "Content-Type: application/octet-stream; name=\"".$pdf."\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n";
        $message .= "Content-Disposition: attachment; filename=\"".$pdf."\"\r\n\r\n";
        $message .= $content."\r\n\r\n";
        $message .= "--".$uid."--";

        mail($email, 'Biglietti acquistati', $message, $header);
    }

    public function inviaComunicazioneInfedelta($cliente){
        $message = 'INFEDELEEEE!!!!';
        mail($cliente->getEmail(), 'Avviso infedeltà', $message);
    }

    public function avvisaClientiPromozioni($listaClienti, $listaPromozioni){
        //Genero testo dalla lista promozioni
        mail($this->generateRecipients($listaClienti), 'Scopri le nuove promozioni', 'Lista promozioni');
    }

    public function avvisaPrenotazioneInScadenza($listaClienti){
        mail($this->generateRecipients($listaClienti), "Prenotazione cancellata", "La tua prenotazione è stata cancellata");
    }

    private function generateRecipients($listaClienti){
        $recipients = array();
        foreach ($listaClienti as $cliente){
            array_push($recipients, $cliente->getEmail());
        }
        return implode(',',$recipients);
    }
}


