<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Gestione della prenotazione</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="container body-cont">
    <div class="row">
        <div class="login-form col-md-12 mt-5">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-12">
                        <h2>Gestione della prenotazione #<?= $data["idPrenotazione"] ?></h2>
                    </div>
                    <?php
                    $dataOraPartenza = DateTime::createFromFormat('Y-m-d H:i:s', $data["volo"]->getDataOraPartenza());
                    $dataOraArrivo = DateTime::createFromFormat('Y-m-d H:i:s', $data["volo"]->getDataOraArrivo());
                    ?>
                    <div class="row volo p-md-5 w-100">
                        <div class="col-md-3"></div>
                        <div class="col-md-2 text-center">
                            <div class="orario"><?=$dataOraPartenza->format('H:i');?> <?=$data["volo"]->getAeroportoPartenza()->getCodice()?></div>
                            <div class="data"><?=$dataOraPartenza->format('Y-m-d');?></div>
                        </div>
                        <div class="col-md-2 align-self-center" style="position:relative;">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8  px-0">
                                    <div class="flight-line"></div>
                                    <em class="fas fa-plane-departure float-left pr-1"></em>
                                    <em class="fas fa-plane-arrival float-right pl-1"></em>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <div class="orario"><?=$dataOraArrivo->format('H:i');?> <?=$data["volo"]->getAeroportoDestinazione()->getCodice()?></div>
                            <div class="data"><?=$dataOraArrivo->format('Y-m-d');?></div>
                        </div>
                    </div>
                    <?php if(!$data["acquistato"]){ ?>
                        <div class="row mt-5 w-100">
                            <div class="col-md-4"></div>
                            <form id="acquistoForm" action="../../vendita/acquistaPrenotazione" method="post" style="min-height: 0px">
                                <input type="hidden" name="idPrenotazione" value="<?= $data["idPrenotazione"]?>">
                                <input type="hidden" name="idCliente" value="<?= $data["idCliente"]?>">
                            </form>
                            <div class="col-md-4 text-center">
                                <div class="d-flex mx-auto tariffa selected" id="acquista">
                                    <em class="fas fa-wallet"></em>
                                    <p class="mt-auto mx-auto" >Completa il tuo acquisto</p>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row mt-5 w-100">
                            <div class="col-md-3"></div>
                            <div class="col-md-3 text-center">
                                <a href="../../cliente/downloadBiglietti/<?= $data["idPrenotazione"]?>">
                                    <div class="d-flex mx-auto tariffa selected">
                                        <em class="fas fa-file-download"></em>
                                        <p class="mt-auto mx-auto">Scarica Biglietti</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3 text-center">
                               <a href="../../vendita/cercaDateDisponibili/<?= $data["idPrenotazione"]?>">
                                   <div class="d-flex mx-auto tariffa selected">
                                        <em class="fas fa-calendar-alt"></em>
                                        <p class="mt-auto mx-auto">Modifica Data</p>
                                    </div>
                               </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#acquista").click(function(){
        $("#acquistoForm").submit();
    });
</script>
<style>
    .tariffa.selected:before{
        content: '' !important;
        background: none !important;
    }
</style>
<?php include("../app/template/footer.php") ?>
</body>

</html>
