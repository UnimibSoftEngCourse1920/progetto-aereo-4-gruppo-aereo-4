<?php

require_once __DIR__ . "/Pagamento.php";
require_once "../app/models/acquisto/pagamento/IstitutoDiCredito.php";

class PagamentoConCarta extends Pagamento{

    private $istituto;
    
	public function effettua($carta) {
		$this->istituto = new IstitutoDiCredito("Banca Bicocca");
		return $this->istituto->autorizzaPagamento($carta);
	}

	public function getIstituto(){
	    return $this->istituto;
    }
}