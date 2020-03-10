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
                <form class="bg-dark py-md-4 px-md-5" id="form-ricerca" action="consulta.html" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-2"></div>
                        <div class="form-group col-md-2">
                            <label for="inputCity">Da</label>
                            <input type="text" class="form-control aeroporto" id="inputEmail4" value="<?=$data["partenza"]?>" placeholder="Città o aeroporto">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCity">A</label>
                            <input type="text" class="form-control aeroporto" id="inputPassword4" value="<?=$data["destinazione"]?>" placeholder="Città o aeroporto">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputCity">Data</label>
                            <input type="text" autocomplete="off" class="form-control datepicker" id="datepicker" value="<?=$data["data"]?>" placeholder="Data di partenza">
                        </div>
                        <div class="form-group col-md-1">
                            <label for="inputState">Viaggiatori</label>
                            <input type="number" id="inputNumber" name="inputNumber" value="<?=$data["viaggiatori"]?>"" min="1">
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
        <?php foreach($data["voli"] as $volo) {?>
            <?php var_dump($volo) ?>
            <?php var_dump($volo->getOID()); ?>
            <?php var_dump($volo->getAeroportoPartenza()); ?>
        <div class="row volo p-md-5">
            <div class="col-md-2 text-center">
                <div class="orario">13:00 <?=$volo->getAeroportoPartenza()?></div>
                <div class="data">18/03/2020</div>
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
                <div class="orario">14:30 ORY</div>
                <div class="data">18/03/2020</div>
            </div>
            <div class="col-md-3 text-center">
                <div class="prezzo"><?=$volo->getPrezzoBiglietto()?>€</div>
                <div class="totale">120€ totale</div>
            </div>
            <div class="col-md-3 text-center">
                <a href="/public/prenotazione/prenota/<?=$volo->getOID()?>/<?=$data["viaggiatori"]?>">
                    <button class="mx-auto">Prenota questo volo</button>
                </a>
            </div>
        </div>
        <?php }?>
        <!--<div class="row volo p-md-5">
            <div class="col-md-2 text-center">
                <div class="orario">13:00 MXP</div>
                <div class="data">18/03/2020</div>
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
                <div class="orario">14:30 ORY</div>
                <div class="data">18/03/2020</div>
            </div>
            <div class="col-md-3 text-center">
                <div class="prezzo">48€ <div class="prezzo-precedente"><strike>60€</strike></div></div>
                <div class="totale">96€ totale</div>
                <div class="totale"><strike>120€ totale</strike></div>
            </div>
            <div class="col-md-3 text-center">
                <button class="mx-auto">Prenota questo volo</button>
            </div>
        </div>-->
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