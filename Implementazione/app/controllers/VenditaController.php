<?php

require_once "../app/core/Controller.php";

class VenditaController extends Controller
{
	//TODO: DB e controllo
	public function consultaVoli($partenza, $destinazione, $data, $nPosti) {
		$registro = $this->model('volo/RegistroVoli');
		$aeroporti = $registro->getAeroporti();
		$voli = $registro->cercaVoli($partenza, $destinazione, $data, $nPosti);
		$this->view('vendita/consulta', ["voli" => $voli, "partenza" => $partenza, "destinazione" => $destinazione,
                                                "data" => $data, "viaggiatori" => $nPosti, "aeroporti" => $aeroporti]);
	}
	
	//TODO: DB e restituire voli anziché date
	public function cercaDateDisponibili($idVolo, $nPosti) {
		$registro = $this->model('RegistroVoli');
		$voli = $registro->cercaDateDisponibili($idVolo, $nPosti);
		$this->view('vendita/cambiaprenotazione', $voli);
	}
	
	//TODO: DB
	public function cambiaData($idPrenotazione, $idCliente, $idNuovoVolo, $nuovaTariffa, $metodoPagamento, $carta = "") {
        $registroPrenotazioni = $this->model('prenotazione/RegistroPrenotazioni');
        $registroVoli = $this->model('volo/RegistroVoli');
        $registroClienti = $this->model('cliente/RegistroClienti');
        $prenotazione = $registroPrenotazioni->getPrenotazione($idPrenotazione);
        $cliente = $prenotazione->getCliente();
        if ($idCliente == $cliente->getOID()) {
            $volo = $prenotazione->getVolo();
            var_dump($prenotazione);
            var_dump($volo);
            exit;
            $registroVoli = $this->model('volo/RegistroVoli');
            $nuovoVolo = $registroVoli->getVolo($idNuovoVolo);
            $esitoCambioData = $registroPrenotazioni->cambiaData($prenotazione, $cliente, $nuovoVolo, $nuovaTariffa, $metodoPagamento, $carta);
            if ($esitoCambioData) {
                //Aggiornare prenotazione (anche biglietti e acquisto), cliente, volo vecchio e volo nuovo per i posti
                $registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
                $registroPrenotazioni->aggiornaPrentoazione($prenotazione);
                $registroClienti->aggiornaCliente($cliente);
                $registroVoli->aggiornaVolo($volo);
                $registroVoli->aggiornaVolo($nuovoVolo);
                //TODO: view con successo
            } else {
                //TODO: view con errore
            }
        }
	}

	public function acquistoPrenotazione($idPrenotazione, $idCliente, $metodoPagamento, $carta = "") {
        $registroPrenotazioni = $this->model('prenotazione/RegistroPrenotazioni');
        $prenotazione = $registroPrenotazioni->getPrenotazione($idPrenotazione);
        $cliente = $prenotazione->getCliente();
        if ($idCliente == $cliente->getOID()) {
            $esitoPagamento = $registroPrenotazioni->acquistaPrenotazione($prenotazione, $cliente, $metodoPagamento, $carta);
            if ($esitoPagamento) {
                //TODO: Testare queste istruzioni
                //$registroPrenotazioni->generaBiglietti($prenotazione, $cliente);
                $registroPrenotazioni->aggiornaAcquisti($prenotazione);
                exit;
                $registroClienti = $this->model('cliente/RegistroClienti');
                $registroClienti->aggiornaCliente($cliente);
                //TODO: view con successo
            } else {
                //TODO: view con errore
            }
        }
	}

	public function acquista($idPrenotazione = "", $idCliente = "") {
        $this->view('vendita/acquisto', ["id_prenotazione" => $idPrenotazione, "id_cliente" => $idCliente]);
    }

    public function confermaPrenotazione() {
        $this->view('vendita/conferma', ["success" => "La tua prenotazione è stata confermata!"]);
    }

    public function confermaAcquisto() {
        $this->view('vendita/conferma', ["success" => "Il tuo acquisto è stato confermato!"]);
    }
}