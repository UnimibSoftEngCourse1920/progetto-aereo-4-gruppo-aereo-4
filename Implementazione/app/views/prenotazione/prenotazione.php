<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Prenota</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="container pb-5 pt-5 mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Conferma la tua prenotazione</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mt-md-4">
            <div class="row mt-2">
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa selected" id="tar_stand">
                        <em class="fas fa-paper-plane"></em>
                        <p class="mt-auto mx-auto">Tariffa Standard</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa" id="tar_plus">
                        <em class="fas fa-rocket"></em>
                        <p class="mt-auto mx-auto">Tariffa VoloPlus</p>
                    </div>
                </div>
            </div>
            <div class="row mt-md-4">
                <div class="col">
                    <form class="py-md-4 px-md-5" action="acquisto.html" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputState">E-mail</label>
                                <input type="email" class="form-control" placeholder="E-mail">
                            </div>
                        </div>
                        <?php for($i=1;$i<=$data["pass"];$i++){?>
                        <div class="form-row px-2 py-3">
                            Passeggero <?= $i ?>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome<?= $i ?>" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome<?= $i ?>" placeholder="Cognome">
                            </div>
                        </div>
                        <?php }?>
                        <?php if(!$data["volo"]->getDisponibilitaPosti($data["pass"])){ ?>
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non ci sono più posti per questo volo.</div>
                        </div>
                        <?php } else { ?>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Prenota</button>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-md-5 mt-md-4" id="riepilogo">
            <div class="row pb-md-4">
                <div class="col-6"><h3>Biglietti</h3></div>
                <div class="col-6 text-right">
                    <h3 id="prezzo_base">
                        <?php
                            if($data["volo"]->getPrezzoIntero()==$data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))){
                                echo $data["volo"]->getPrezzoIntero()*$data["pass"]."€";
                            } else {
                                echo $data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"]."€ </h3><h3><strike style='font-size: 20px'>".$data["volo"]->getPrezzoIntero()*$data["pass"]."€</strike>";
                            }?>
                    </h3>
                </div>
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
            <div class="row py-md-4" id="supplemento_row" style="display: none;">
                <div class="col-8"><h3>Supplementi</h3></div>
                <div class="col-4 text-right"><h3>20€</h3></div>
            </div>
            <div class="row" id="tariffa_row" style="display: none;">
                <div class="col">
                    <p>
                        <strong>Tariffa</strong>
                        <br>VoloPlus
                    </p>
                </div>
            </div>
            <div class="row py-md-4">
                <div class="col-8"><h3>Totale</h3></div>
                <div class="col-4 text-right"><h3 id="prezzo_tot"><?= $data["volo"]->getPrezzoIntero()*$data["pass"]?>€</h3></div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
