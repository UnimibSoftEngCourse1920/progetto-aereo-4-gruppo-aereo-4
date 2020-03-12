<?php

require_once __DIR__ . "/Pagamento.php";
require_once "../app/models/acquisto/pagamento/IstitutoDiCredito.php";

class PagamentoConCarta extends Pagamento{

    private $istituto;

	public function __construct($importo) {
	    parent::__construct($importo);
	}
    
	public function effettua($carta) {
		$this->istituto = new IstitutoDiCredito("Banca Bicocca");
		$esitoPagamento = $this->istituto->autorizzaPagamento($carta);
		return $esitoPagamento;
	}

	public function getIstituto(){
	    if(get_class($this->istituto) != IstitutoDiCredito::class){
            return DBFacade::getIstance() ->get($this->istituto, IstitutoDiCredito::class);
        }
	    else {
            return $this->istituto;
        }
    }
}