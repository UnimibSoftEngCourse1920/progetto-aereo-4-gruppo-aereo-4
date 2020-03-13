<?php

require_once __DIR__ . "/Pagamento.php";
require_once "../app/models/acquisto/pagamento/IstitutoDiCredito.php";

class PagamentoConCarta extends Pagamento{

    private $istituto;
    
	public function effettua($carta) {
		$istituto = new IstitutoDiCredito();
		$esito = $istituto->autorizzaPagamento($carta);
		$this->istituto = $istituto->getNome();
		return $esito;
	}

	public function getIstituto(){
	    return $this->istituto;
    }
}