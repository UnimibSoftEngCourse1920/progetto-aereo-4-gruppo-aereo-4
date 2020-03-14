<?php


require_once $_SERVER['DOCUMENT_ROOT']."/app/models/cliente/RegistroClienti.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/cliente/EstrattoConto.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/cliente/Cliente.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/DBFacade.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/PDFGenerator.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/servizi/Mailer.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/volo/RegistroVoli.php";
require_once $_SERVER['DOCUMENT_ROOT']."/app/models/prenotazione/Prenotazione.php";

abstract class Tariffa
{
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
        return DBFacade::getIstance() -> getPasseggeriVolo($OIDVolo);
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
        $univoca = DBFacade::getIstance()->checkPrenotazioneUnivoca($cliente->getEmail(),$codVolo);
        if($univoca){
            if(!$cliente->isFedelta()) {
                DBFacade::getIstance()->put($cliente);
            }
            $registroVoli = new RegistroVoli();
            $disp = $registroVoli->checkDisponibilitaPosti($numPosti,$codVolo);

            if($disp){
                $v = $registroVoli->getVolo($codVolo);
                $nuovaPrenotazione = new Prenotazione($cliente,$listaPasseggeri,$v,$numPosti,$tariffa);
                DBFacade::getIstance()->put($nuovaPrenotazione);
                return $nuovaPrenotazione;
            }
            else{
                return false;
            }
        } else{
            return false;
        }
    }

	public function cambiaData($prenotazione, $cliente, $nuovoVolo, $nuovaTariffa, $metodoPagamento, $carta, $tassaCambio) {
		$esitoCambioData = $prenotazione->cambiaData($metodoPagamento, $cliente, $nuovoVolo, $tassaCambio, $carta);
		return $esitoCambioData;
	}
	
	public function calcolaTassa($tariffa, $nuovaTariffa) {
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
		return $prenotazione->acquista($metodoPagamento, $cliente, $importo, $carta);
	}
	
	public function generaBiglietti($prenotazione, $cliente) {
		$biglietti = $prenotazione->getListaBiglietti();
		$pdf = PDFGenerator::getInstance()->generaBiglietti($biglietti);
		$email = $cliente->getEmail();
		$this->mailer->inviaEmailBiglietti($email, $pdf);
        PDFGenerator::getInstance()->cancellaPDF($pdf);
	}
	
	public function getPrenotazione($idPrenotazione) {
		return DBFacade::getIstance()->get($idPrenotazione, 'Prenotazione');
	}
	
	public function aggiornaAcquisti($prenotazione) {
        foreach($prenotazione->getListaAcquisti() as $acquisto) {
            DBFacade::getIstance()->put($acquisto->getPagamento());
            DBFacade::getIstance()->put($acquisto);
        }
        DBFacade::getIstance()->update($prenotazione);
	}

	public function aggiornaBiglietti($prenotazione) {
        foreach($prenotazione->getListaBiglietti() as $biglietto) {
            DBFacade::getIstance()->update($biglietto);
        }
        DBFacade::getIstance()->update($prenotazione);
    }

	public function controlloPrenotazioniScadute(){
        $listaPrenotazioni = DBFacade::getIstance() -> getPrenotazioniScaduteIn(72);
        foreach ($listaPrenotazioni as $prenotazione){
            DBFacade::getIstance()->delete($prenotazione->getOID(), Prenotazione::class);
        }
        $listaPrenotazioni = DBFacade::getIstance() -> getPrenotazioniScaduteIn(96);
        $listaClienti = array();
        foreach ($listaPrenotazioni as $prenotazione){
            $listaClienti[] = $prenotazione->getCliente();
        }
        $this->mailer->avvisaPrenotazioneInScadenza($listaClienti);
    }

    public function getPrenotazioniCliente($OIDCliente){
        return DBFacade::getIstance()->getPrenotazioniCliente($OIDCliente, false);
    }
	
}
?>