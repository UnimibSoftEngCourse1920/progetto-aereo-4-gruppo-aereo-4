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
            <h2>Cambia la data del volo</h2>
        </div>
    </div>
    <?php
    $formatoGiornoConSecondi = 'Y-m-d H:i:s';
    $formatoGiono = 'Y-m-d H:i';
    $dataOraPartenza = DateTime::createFromFormat($formatoGiornoConSecondi, $data["volo"]->getDataOraPartenza());
    $dataOraArrivo = DateTime::createFromFormat($formatoGiornoConSecondi, $data["volo"]->getDataOraArrivo());
    ?>
    <div class="row volo p-md-5">
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
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-auto">
            <form class="py-md-4 px-md-5" action="" method="post">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="data_partenza">Nuova data</label>
                        <input type="text" autocomplete="off" class="form-control datepicker" id="data_partenza" name="data_partenza" placeholder="Nuova data di partenza" required>
                    </div>
                </div>
                <?php if(!is_null($data["voli"]) && count($data["voli"]) == 0) { ?>
                    <div class="form-row px-3 pt-4 pb-3">
                        <div class="error mx-auto">Non ci sono voli disponibili in questa data.</div>
                    </div>
                <?php } ?>
                <input type="hidden" id="id_prenotazione" name="id_prenotazione" value="<?=$data["id_prenotazione"]?>">
                <div class="form-row pt-4">
                    <div class="form-group col-md-4 mx-auto">
                        <button type="submit" class="btn btn-primary w-100">Cerca voli</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if($data["voli"]) {?>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-md-4">
            <div class="row">
                <div class="col-md-8" style="border-right: 1px solid #eee">
                    <div class="row mb-5">
                        <div class="col-md-6 text-center">
                            <div data-volo="<?=$data["voli"][0]->getOID();?>" class="d-flex mx-auto data-disponibile selected">
                                <p class="mx-auto my-auto">
                                    <?php
                                    $dataOraPartenza = DateTime::createFromFormat($formatoGiornoConSecondi, $data["voli"][0]->getDataOraPartenza());
                                    $dataOraArrivo = DateTime::createFromFormat($formatoGiornoConSecondi, $data["voli"][0]->getDataOraArrivo());
                                    ?>
                                    <strong>Partenza</strong><br>
                                    <?=$dataOraPartenza->format($formatoGiono)?><br><br>
                                    <strong>Arrivo</strong><br>
                                    <?=$dataOraPartenza->format($formatoGiono)?>
                                </p>
                            </div>
                        </div>

                        <?php
                        $nVoli = count($data["voli"]);
                        for($i = 1; $i < $nVoli; $i++) {
                            if ($i % 2 == 0) {
                                if(floor($i/2) != floor($nVoli/2)) {?>
                                    </div>
                                    <div class="row mb-5">
                                <?php } else { ?>
                                    </div>
                                    <div class="row">
                                <?php }
                            } ?>
                                <div class="col-md-6 text-center">
                                    <div data-volo="<?=$data["voli"][$i]->getOID();?>" class="d-flex mx-auto data-disponibile">
                                        <p class="mx-auto my-auto">
                                            <?php
                                            $dataOraPartenza = DateTime::createFromFormat($formatoGiornoConSecondi, $data["voli"][$i]->getDataOraPartenza());
                                            $dataOraArrivo = DateTime::createFromFormat($formatoGiornoConSecondi, $data["voli"][$i]->getDataOraArrivo());
                                            ?>
                                            <strong>Partenza</strong><br>
                                            <?= $dataOraPartenza->format($formatoGiono) ?><br><br>
                                            <strong>Arrivo</strong><br>
                                            <?= $dataOraPartenza->format($formatoGiono) ?>
                                        </p>
                                    </div>
                                </div>
                        <?php
                        } ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row  mb-5">
                        <div class="col-md-12 text-center">
                            <div data-tariffa="standard" class="d-flex mx-auto tariffa <?php if($data["tariffa"] == "standard") {?>selected<?php }?>">
                                <em class="fas fa-paper-plane"></em>
                                <p class="mt-auto mx-auto">Tariffa Standard</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div data-tariffa="plus" class="d-flex mx-auto tariffa <?php if($data["tariffa"] == "plus") {?>selected<?php }?>">
                                <em class="fas fa-rocket"></em>
                                <p class="mt-auto mx-auto">Tariffa VoloPlus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-auto">
            <form class="py-md-4 px-md-5" id="form-data" action="/public/vendita/cambiaData" method="post">
                <input type="hidden" id="id_prenotazione" name="id_prenotazione" value="<?=$data["id_prenotazione"]?>">
                <input type="hidden" id="id_cliente" name="id_cliente" value="<?=$_SESSION["id_cliente"]?>">
                <input type="hidden" id="id_nuovo_volo" name="id_nuovo_volo">
                <input type="hidden" id="nuova_tariffa" name="nuova_tariffa">
                <div class="form-row pt-4">
                    <div class="form-group col-md-4 mx-auto">
                        <button type="submit" class="btn btn-primary w-100">Cambia data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
</div>
<?php include("../app/template/footer.php") ?>
</body>
</html>