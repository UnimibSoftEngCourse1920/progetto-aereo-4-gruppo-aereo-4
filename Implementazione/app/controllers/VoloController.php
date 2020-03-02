<?php


namespace controller;

use model\prenotazione\RegistroPrenotazioni;
use model\servizi\DB;
use model\servizi\Mailer;
use model\volo\RegistroVoli;



class VoloController extends Controller {

    private $registroVoli;
    private $registroPrenotazioni;
    private $mailer;

    public function __construct(){
        $this->registroVoli = new RegistroVoli();
        $this->registroPrenotazioni = new RegistroPrenotazioni();
        $this->mailer = new Mailer();
    }

    public function modificaVolo($OIDVolo, $nuovaData, $nuovoOrarioPart, $nuovoOrarioArr){
        $voloMod = $this->registroVoli -> modificaVolo($OIDVolo, $nuovaData, $nuovoOrarioPart, $nuovoOrarioArr);
        DB::getIstance() -> update($voloMod);
        // vedo esito delle op. prima
        //
        $listaClienti = $this->registroPrenotazioni -> getClientiVolo($voloMod -> OIDVolo);
        $this->mailer -> inviaEmailModificaVolo($listaClienti, $voloMod);
    }

    public function inserisciVolo($orarioPartenza, $orarioArrivo, $data, $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo){
        //manca esito operazione
        $this->registroVoli -> inserisciVolo($orarioPartenza, $orarioArrivo, $data, $OIDAereoportoPart, $OIDAereoportArr, $OIDAereo);
    }

    public function cancellaVolo($OIDVolo){
        $volo = $this->registroVoli -> rimuoviVolo($OIDVolo);
        $listaClienti = $this->registroPrenotazioni -> getClientiVolo($volo -> OIDVolo);
        $this->mailer -> inviaEmailCancellazioneVolo($listaClienti, $volo);
    }
}