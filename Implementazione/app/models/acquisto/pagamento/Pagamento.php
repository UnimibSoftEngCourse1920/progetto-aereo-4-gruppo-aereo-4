<?php

namespace model\acquisto\pagamento;

abstract class Pagamento{
	
    private $idPagamento;
    private $data;
    private $importo;
	
	public function effettua($cliente);
	
} 
