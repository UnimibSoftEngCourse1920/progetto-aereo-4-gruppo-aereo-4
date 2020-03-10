<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>
    <?php include("../app/template/menu.php") ?>
    <div class="container-fluid mb-5">
        <div class="row" id="promozione">
            <div class="col p-2 text-center">
                <a href="#">Sconto del 20% fino al 20/03/2020 su una selezione di voli.</a>
            </div>
        </div>
        <script>
            var aeroporti = [];
            var codiciAeroporti = [];
            <?php
            $index = 0;
            foreach($data["aeroporti"] as $aeroporto) {
                $oid = $aeroporto->getOID();
                $nome = $aeroporto->getCitta()." ".$aeroporto->getNome()." (".$aeroporto->getCodice().")";
            ?>
                aeroporti["<?=$index?>"] = "<?=$nome?>";
                codiciAeroporti["<?=$nome?>"] = "<?=$oid?>";
            <?php
                if($oid == $data["partenza"]) {
                    $data["partenza"] = $nome;
                }
                if($oid == $data["destinazione"]) {
                    $data["destinazione"] = $nome;
                }
                $index++;
            }
            ?>
        </script>
        <div class="row bg-dark">
            <div class="col-md-12 mt-auto">
                <form class="bg-dark py-md-4 px-md-5" id="form-ricerca" action="/public/vendita/consultaVoli" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-2"></div>
                        <div class="form-group col-md-2">
                            <label for="da">Da</label>
                            <input type="text" class="form-control aeroporto" id="da" value="<?=$data["partenza"]?>" placeholder="Città o aeroporto" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="a">A</label>
                            <input type="text" class="form-control aeroporto" id="a" value="<?=$data["destinazione"]?>" name="a" placeholder="Città o aeroporto" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="data_partenza">Data</label>
                            <input type="text" autocomplete="off" class="form-control datepicker" id="data_partenza" value="<?=$data["data"]?>" name="data_partenza" placeholder="Data di partenza" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="viaggiatori">Viaggiatori</label>
                            <input type="number" id="viaggiatori" value="<?=$data["viaggiatori"]?>" name=viaggiatori" value="1" min="1" required>
                        </div>
                        <div class="form-group col-md-1 mt-auto">
                            <button type="submit" class="btn btn-primary w-100">Cerca voli</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-5">
    <?php foreach($data["voli"] as $volo) {
        $dataOraPartenza = DateTime::createFromFormat('Y-m-d H:i:s', $volo->getDataOraPartenza());
        $dataOraArrivo = DateTime::createFromFormat('Y-m-d H:i:s', $volo->getDataOraArrivo());
        $prezzoScontato = number_format($volo->getPrezzoScontato(isset($_SESSION["id_cliente"])),2);
        $prezzoIntero = $volo->getPrezzoIntero();?>
        <div class="row volo p-md-5">
            <div class="col-md-2 text-center">
                <div class="orario"><?=$dataOraPartenza->format('H:i');?> <?=$volo->getAeroportoPartenza()->getCodice()?></div>
                <div class="data"><?=$dataOraPartenza->format('Y-m-d');?></div>
            </div>
            <div class="col-md-2 align-self-center" style="position:relative;">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8  px-0">
                        <div class="flight-line"></div>
                        <i class="fas fa-plane-departure float-left pr-1"></i>
                        <i class="fas fa-plane-arrival float-right pl-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-2 text-center">
                <div class="orario"><?=$dataOraArrivo->format('H:i');?> <?=$volo->getAeroportoDestinazione()->getCodice()?></div>
                <div class="data"><?=$dataOraArrivo->format('Y-m-d');?></div>
            </div>
            <div class="col-md-3 text-center">
                <div class="prezzo">
                    <?=$prezzoScontato?>€
                    <?php if($prezzoScontato != $prezzoIntero ) { ?>
                    <div class="prezzo-precedente"><strike><?=$prezzoIntero?>€</strike></div>
                    <?php } ?>
                </div>

                <div class="totale">
                    <?php if ($data["viaggiatori"] > 1) {
                        echo number_format($prezzoScontato*$data["viaggiatori"],2)."€";
                    }?>
                    totale
                </div>

            </div>
            <div class="col-md-3 text-center">
                <a href="/public/prenotazione/prenota/<?=$volo->getOID()?>/<?=$data["viaggiatori"]?>">
                    <button class="mx-auto">Prenota questo volo</button>
                </a>
            </div>
        </div>
        <?php }?>
    </div>
    <?php include("../app/template/footer.php") ?>
</body>

</html>

<?php /*<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Risultati della ricerca</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="body-cont px-4">
    <div class="row">
        <div class="col-md-12 px-5 table-responsive">
            <h4 class="py-2">La tua ricerca ha prodotto i seguenti risultati:</h4>
            <table class="table table-striped " aria-describedby="tabella_voli_disponibili">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Da</th>
                    <th scope="col">A</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Data</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <?php foreach($data["voli"] as $volo) {?>
                <tbody>
                    <tr>
                        <th scope="row"><?=$volo->getOID()?></th>
                        <td><?=$volo->getAeroportoPartenza()?></td>
                        <td><?=$volo->getAeroportoDestinazione()?></td>
                        <td><?=$volo->getOrarioPartenza()?></td>
                        <td><?=$volo->getData()?></td>
                        <td><?=$volo->getPrezzoBiglietto()?></td>
                        <td>
                            <a href="/public/prenotazione/prenota/<?=$volo->getOID()?>"">
                                <button class="btn btn-select-flight"> Scegli questo volo <i class="fas fa-arrow-right"></i> </button>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <?php }?>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo $dir ?>js/script.js"></script>
<?php include("../app/template/footer.php") ?>
</body>

</html>*/
?>