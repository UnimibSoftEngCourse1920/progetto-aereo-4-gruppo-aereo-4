<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>

    <?php
       include("../app/template/menu.php");
       $promozioneBanner = $data["promozioneBanner"];
       $voli = $data["voli"];
     ?>

    <div class="container-fluid">
        <div class="row" id="promozione">
            <div class="col p-2 text-center">
                <span style="color: white"> <em><?= $promozioneBanner->getNome() ?></em> risparmia il <?= $promozioneBanner->getSconto() ?>% fino al <?= $promozioneBanner->getDataFine() ?> su una selezione di voli.</span>
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
                $index++;
            }
            ?>
        </script>
        <div class="row" id="header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position: absolute;  bottom: 0;">
                <path fill="#fff" fill-opacity="1" d="M0,160L48,165.3C96,171,192,181,288,170.7C384,160,480,128,576,117.3C672,107,768,117,864,138.7C960,160,1056,192,1152,192C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-auto">
                <form class="bg-dark py-md-4 px-md-5" id="form-ricerca" action="/public/vendita/consultaVoli" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="da">Da</label>
                            <input type="text" class="form-control aeroporto" id="da" placeholder="Città o aeroporto" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="a">A</label>
                            <input type="text" class="form-control aeroporto" id="a" name="a" placeholder="Città o aeroporto" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="data_partenza">Data</label>
                            <input type="text" autocomplete="off" class="form-control datepicker" id="data_partenza" name="data_partenza" placeholder="Data di partenza" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="viaggiatori">Viaggiatori</label>
                            <input type="number" id="viaggiatori" name=viaggiatori" value="1" min="1" required>
                        </div>
                        <div class="form-group col-md-3 mt-auto">
                            <button type="submit" class="btn btn-primary w-100">Cerca voli</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="container pb-5 mb-5">
        <div class="row pt-md-5 mt-md-5 pb-md-5 px-md-5">
            <h2>In promozione</h2>
        </div>
        <div class="row pb-md-5 mb-md-5">
        <?php
            $i = 0;
            foreach ($voli as $volo){
                if($i<3){?>
            <div class="col-md-4">
                <div class="promozione" style="background: url('https://source.unsplash.com/featured/?<?= $volo->getAeroportoDestinazione()->getCitta() ?>')">
                    <div class="volo p-md-3">
                        <div class="tratta"><?= $volo->getAeroportoPartenza()->getCitta()?> - <?= $volo->getAeroportoDestinazione()->getCitta()?></div>
                        <div class="data"><?= explode(" ",$volo->getDataOraPartenza())[0]?></div>
                        <div class="prezzo">
                            <?= $volo->getPrezzoScontato(false)?>€
                            <strike><?= $volo->getPrezzoIntero()?>€</strike>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $i++;
                }
            } ?>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
