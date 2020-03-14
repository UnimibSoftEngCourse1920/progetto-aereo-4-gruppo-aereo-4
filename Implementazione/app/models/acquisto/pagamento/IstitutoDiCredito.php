<?php


class IstitutoDiCredito
{
    private $nome;

    public function getNome()
    {
        return $this->nome;
    }

    public function autorizzaPagamento($carta) {
        //Eventuali controlli/operazioni sui dati della carta
        if($carta) {
            $this->nome = "Banca Bicocca";
            return (mt_rand() / mt_getrandmax() <= 0.9);
        }
	}
}


