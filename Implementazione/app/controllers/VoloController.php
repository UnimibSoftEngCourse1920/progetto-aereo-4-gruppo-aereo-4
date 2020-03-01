<?php


namespace controller;

use model\prenotazione\RegistroPrenotazioni;
use model\servizi\DB;
use model\servizi\Mailer;
use model\volo\RegistroVoli;


abstract class tipoAvviso{
    const CANCELLAZIONE = 'CANCELLAZIONE';
    const MODIFICA = 'MODIFICA';
}


class VoloController extends Controller {

    private $registroVoli;
    private $registroPrenotazioni;
    private $mailer;

    public function __construct(){
        $this -> registroVoli = new RegistroVoli();
        $this -> registroPrenotazioni = new RegistroPrenotazioni();
        $this -> mailer = new Mailer();
    }

    public function modificaVolo($codiceVolo, $datiVolo){
        $voloMod = $this -> registroVoli -> getVolo($codiceVolo);
        $voloMod -> modificaDati($datiVolo);
        DB::getIstance() -> update($voloMod);
        // vedo esito delle op. prima
        $this -> avvisaClienti(tipoAvviso::MODIFICA, $voloMod);
    }

    public function inserisciVolo($datiVolo){
        $this -> registroVoli -> aggiungiVolo($datiVolo);
    }

    private function avvisaClienti($tipo, $volo){
        $listaClienti = $this -> registroPrenotazioni -> getClientiVolo($volo -> codiceVolo);
        foreach ($listaClienti as $cliente){
            $this -> mailer -> sendEmailVolo($tipo, $cliente, $$volo);
        }
    }
}