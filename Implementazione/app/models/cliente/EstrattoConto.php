<?php


class EstrattoConto
{
    public static $PAGAMENTO = 'Pagamento';
    public static $ACQUISTO = 'Acquisto';

    private $righe;
    private $saldo;

    public function __construct()
    {
        $this->righe = array();
    }

    public function addRiga($volo, $tipologia, $punti){
        $this->righe[] = new EstrattoContoRow($volo, $tipologia, $punti);
        $this->saldo += $punti;
    }

    public function getRighe(){
        return $this->righe;
    }

    public function getSaldo(){
        return $this->saldo;
    }
}

class EstrattoContoRow{

    private $datiVolo;
    private $dataoraPartenza;
    private $tipologia;
    private $punti;

    public function __construct(Volo $volo, $tipologia, $punti)
    {
        $this->datiVolo = $volo->getAeroportoPartenza()->getCodice() . " - " .$volo->getAeroportoDestinazione()->getCodice();
        $this->dataoraPartenza = $volo->getDataoraPartenza(); //non so se funziona
        $this->tipologia = $tipologia;
        $this->saldo = $punti;
    }

    /**
     * @return string
     */
    public function getDatiVolo()
    {
        return $this->datiVolo;
    }

    /**
     * @return mixed
     */
    public function getDataoraPartenza()
    {
        return $this->dataoraPartenza;
    }

    /**
     * @return mixed
     */
    public function getTipologia()
    {
        return $this->tipologia;
    }

    /**
     * @return mixed
     */
    public function getPunti()
    {
        return $this->punti;
    }




    //FORMATO DATAVOLO-AEREOPORTOPART-AEROPORTODEST-TIPOLOGIA(ACQUISTO; PAGAMENTO)-SALDO PUNTI (+1000, -500 ecc..)


}