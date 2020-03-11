<?php

require_once "../app/models/servizi/Mailer.php";
require_once "../app/models/cliente/RegistroClienti.php";
require_once "../app/models/prenotazione/Prenotazione.php";
require_once "../app/models/cliente/EstrattoConto.php";

abstract class Tariffa
{
    //TODO: sistemare tutti in base a questo formato??
    //Fare maiuscoli?
    const STANDARD = "standard";
    const PLUS = "plus";
}

class RegistroPrenotazioni{

    private $mailer;
    private $registroClienti;

    public function __construct()
    {
        $this->mailer = new Mailer();
        $this->registroClienti = new RegistroClienti();
    }

    public function getListaClientiVolo($OIDVolo){
        $listaClienti = DBFacade::getIstance() -> getPasseggeriVolo($OIDVolo);
        return $listaClienti;
    }

    public function generaEstrattoConto($OIDCliente){
        //se faccio tutto con il codice fedelta non devo controllare sia fedelta
        $db = DBFacade::getIstance();
        $cli = $db->get($OIDCliente, Cliente::class);
        if($cli != null && $cli->isFedelta()){
            $listaPrenotazioni = $db->getPrenotazioniCliente($cli->getOID(), true);
            $ec = new EstrattoConto();
            foreach ($listaPrenotazioni as $prenotazione){
                $prenotazione->generaEstrattoContoParziale($ec);
                //Usare il return??
            }
            //$this->mailer->inviaEstrattoConto($cli, $estrattoConto);
            return $ec;
        }
        return null;
    }

    public function controlloInfedeli(){
        //ritorna la lista di clienti che hanno fatto l'ultima prenotazione $anniTrascorsi anni fa
        //NB!! Questo metodo mi DOVREBBE ritornare una lista di clienti, la chiamata al DB probabilmente ritorna la lista di prenotazioni
         $clientePrenotazione = DBFacade::getIstance()->getFedeltaUltimaPrenotazione();
        foreach ($clientePrenotazione as $cliente) {
            $anni = $this->anniPassati($cliente[1]);
            if($anni == 3) {
                $this->registroClienti->annullaIscrizione($cliente[0]);
            }
            else if(anni == 2){
                $this->registroClienti->setClienteInfedele($cliente[0]);
            }
         }
    }

    private function anniPassati($data){
        $data = new DateTime($data);
        $oggi = new DateTime(date('Y-m-d'));
        return ($oggi->diff($data)) -> y;
    }

    public function effettuaPrenotazione($cliente,$listaPasseggeri,$codVolo,$numPosti,$tariffa){
        $univoca = DBFacade::getIstance()->checkPrenotazioneUnivoca($cliente->email,$codVolo);
        if($univoca){
            DBFacade::getIstance()->put($cliente);
            $registroVoli = new RegistroVoli();
            $disp = $registroVoli->checkDisponibilitaPosti($numPosti,$codVolo);

            if($disp){
                $v = $registroVoli->getVolo($codVolo);
                $nuovaPrenotazione = new Prenotazione($cliente,$listaPasseggeri,$codVolo,$numPosti,$tariffa);
                $nuovaPrenotazione->registraPrenotazione();
                $volo = DBFacade::getIstance()->getVolo($codVolo);
                $nuovaPrenotazione->listaPosti = $volo->prenota($numPosti);
                $nuovaPrenotazione->generaBiglietti();
                return $nuovaPrenotazione;
            }
            else{
                return false;
            }
        } else{
            return false;
        }
    }
	
	public function cambiaData($prenotazione, $cliente, $nuovoVolo, $nuovaTariffa, $metodoPagamento, $carta) {
		$tariffa = $prenotazione->getTariffa();
		$tassa = $this->calcolaTassa($tariffa, $nuovaTariffa);
		$esitoCambioData = $prenotazione->cambiaData($metodoPagamento, $cliente, $nuovoVolo, $tassa, $carta);
		return $esitoCambioData;
	}
	
	private function calcolaTassa($tariffa, $nuovaTariffa) {
		$tassa = 0;
		if($tariffa != Tariffa::PLUS) {
			$tassa += 10;		
			if($nuovaTariffa == Tariffa::PLUS) {
				$tassa += 10;
			}
		}
		return $tassa;
	}
	
	public function acquistaPrenotazione($prenotazione, $cliente, $metodoPagamento, $carta) {
		$importo = $prenotazione->getImporto();
		var_dump($importo);
		exit;
		$esitoPagamento = $prenotazione->acquista($metodoPagamento, $cliente, $importo, $carta);
		if($esitoPagamento) {
			$punti = $this->calcolaPunti($importo);
			$cliente->aggiungiPunti($punti);
			$cliente->setStato(ClienteFedelta::$STATOFEDELE);
		}
		return $esitoPagamento;
	}
	
	public function generaBiglietti($prenotazione, $cliente) {
		$biglietti = $prenotazione->getBiglietti();
		foreach($biglietti as $biglietto) {
			$biglietto->generaPDF();
		}
		$email = $cliente->getEmail();
		Mailer::getIstance()->inviaBiglietti($biglietti, $email);
	}
	
	private function calcolaPunti($importo) {
		return $importo/10;
	}
	
	public function getPrenotazione($idPrenotazione) {
		$prenotazione = DBFacade::getIstance()->get($idPrenotazione, 'Prenotazione');
		return $prenotazione;
	}
	
	public function aggiornaPrenotazione($prenotazione) {
		DBFacade::getIstance()->aggiornaPrenotazione($prenotazione);
	}

	public function cancellaPrenotazioniScadute(){
        $listaPrenotazioni = \model\servizi\DBFacade::getIstance() -> getPrenotazioniScaduteIn(72);
        $listaClienti = array();
        foreach ($listaPrenotazioni as $prenotazione){
            \model\servizi\DBFacade::getIstance()->delete($prenotazione->getOID(), "Prenotazione");
        }

        $listaPrenotazioni = \model\servizi\DBFacade::getIstance() -> getPrenotazioniScaduteIn(96);
        foreach ($listaPrenotazioni as $prenotazione){
            $listaClienti[] = $prenotazione->getCliente()->getEmail();
        }
        $this->mailer->avvisaPrenotazioneInScadenza($listaClienti);
    }
	
}
?>