<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>
<?php include("../app/template/menu.php") ?>
<div class="container pb-5 pt-5 mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Completa il tuo acquisto</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mt-md-4">
            <?php if(isset($_SESSION["id_cliente"])) {?>
            <div class="row mt-2">
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa selected" id="button-carta">
                        <em class="fas fa-credit-card"></em>
                        <p class="mt-auto mx-auto">Paga con la carta</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa" id="button-punti">
                        <em class="fas fa-coins"></em>
                        <p class="mt-auto mx-auto">Paga con i punti</p>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="row mt-md-4" id="pagamento-carta">
                <div class="col">
                    <form class="px-md-5" action="/public/vendita/acquistaPrenotazione" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Numero Carta</label>
                                <input type="number" class="form-control" placeholder="Numero carta" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">CVV</label>
                                <input type="number" class="form-control" placeholder="CVV" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Scadenza</label>
                                <input autocomplete="off" type="text" class="form-control date-ym-picker" placeholder="Scadenza" required>
                            </div>
                        </div>
                        <input type="hidden" name="id_prenotazione" value="<?=$data["id_prenotazione"]?>">
                        <input type="hidden" name="id_cliente" value="<?=$data["id_cliente"]?>">
                        <input type="hidden" name="metodo_pagamento" value="carta">
                        <input type="hidden" name="carta" value="test">
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non è stato possibile completare la transazione.</div>
                        </div>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Paga</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(isset($_SESSION["id_cliente"])) {?>
            <div class="row mt-md-4" id="pagamento-punti" style="display:none">
                <div class="col">
                    <form class="pt-md-4 px-md-5" action="/public/vendita/acquistaPrenotazione" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <strong>Punti acquisiti</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                12312312312
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <strong>Punti necessari</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                12312321
                            </div>
                        </div>
                        <div class="form-row pt-3" style="border-top: 1px solid #eee;">
                            <div class="form-group col-md-6">
                                <strong>Punti rimanenti</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                1231232112
                            </div>
                        </div>
                        <input type="hidden" name="id_prenotazione" value="<?=$data["id_prenotazione"]?>">
                        <input type="hidden" name="id_cliente" value="<?=$data["id_cliente"]?>">
                        <input type="hidden" name="metodo_pagamento" value="punti">
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non hai punti a sufficienza.</div>
                        </div>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Paga</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col text-center">
                    <small>oppure</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 pt-md-4">
                    <a href="/public/vendita/confermaPrenotazione">
                        <button type="submit" class="btn btn-primary w-100">Paga più tardi</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-md-5 mt-md-4" id="riepilogo">
            <div class="row pb-md-4">
                <?php if(!isset($data["tassa_cambio"])) { ?>
                <div class="col-6"><h3>Biglietti</h3></div>
                <div class="col-6 text-right">
                    <h3 id="prezzo_base">
                        <?php
                        if($data["volo"]->getPrezzoIntero()==$data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))){
                            echo number_format($data["volo"]->getPrezzoIntero()*$data["pass"],2)."€";
                        } else {
                            echo number_format($data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"],2)."€ </h3><h3><strike style='font-size: 20px'>".number_format($data["volo"]->getPrezzoIntero()*$data["pass"],2)."€</strike>";
                        }?>
                    </h3>
                </div>
                <?php } else { ?>
                <div class="col-8"><h3>Tassa cambio</h3></div>
                <div class="col-4 text-right">
                    <h3 id="prezzo_base"><?=$data["tassa_cambio"]?>€</h3>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong><?= $data["volo"]->getAeroportoPartenza()->getCitta()." ".$data["volo"]->getAeroportoPartenza()->getNome()." (".$data["volo"]->getAeroportoPartenza()->getCodice().")" ?></strong>
                        <br><?= $data["volo"]->getDataOraPartenza()?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong><?= $data["volo"]->getAeroportoDestinazione()->getCitta()." ".$data["volo"]->getAeroportoDestinazione()->getNome()." (".$data["volo"]->getAeroportoDestinazione()->getCodice().")" ?></strong>
                        <br><?= $data["volo"]->getDataOraArrivo()?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Viaggiatori</strong>
                        <br><?= $data["pass"] ?>
                    </p>
                </div>
            </div>
            <?php if($data["tariffa"] == "plus") { ?>
            <?php if(!isset($data["tassa_cambio"])) { ?>
            <div class="row py-md-4" id="supplemento_row">
                <div class="col-8"><h3>Supplementi</h3></div>
                <div class="col-4 text-right"><h3>20€</h3></div>
            </div>
            <?php } ?>
            <div class="row" id="tariffa_row">
                <div class="col">
                    <p>
                        <strong>Tariffa</strong>
                        <br>VoloPlus
                    </p>
                </div>
            </div>
            <?php } ?>
            <div class="row py-md-4">
                <div class="col-6"><h3>Totale</h3></div>
                <div class="col-6 text-right">
                    <h3 id="prezzo_tot">
                        <?php if(!isset($data["tassa_cambio"])) { ?>
                            <?php if($data["tariffa"] == "plus") { ?>
                                <?=number_format($data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"]+20,2)?>€
                            <?php } else { ?>
                                <?=number_format($data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"],2)?>€
                            <?php } ?>
                        <?php } else { ?>
                            <?=$data["tassa_cambio"]?>€
                        <?php } ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>
</html>