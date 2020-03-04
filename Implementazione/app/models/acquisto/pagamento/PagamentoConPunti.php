<?php


namespace model\acquisto\pagamento;


class PagamentoconPunti extends Pagamento{
	
    private $puntiUtilizzati;
	
	public function __construct($importo) {
	    parent::__construct($importo);
	}

	
	public function effettua($cliente) {
	    //Da rivedere
		$punti = $this->getPunti();
		if($punti <= $cliente->getPunti()) {
			$esitoPagamento = $cliente->sottraiPunti($punti);			
		} else {
			$esitoPagamento = false;
		}
		return $esitoPagamento;
	}
	
}
