<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Estratto conto</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="body-cont px-4">
    <div class="container">
        <div class="row px-5 py-3 pb-5">
            <div class="col-md-2">
                <div class="fidelity-profile-image">
                    <?=substr($_SESSION["nome_cliente"], 0, 1);?>
                </div>
            </div>
            <div class="col-md-10 mt-3">
                <h2 style="display: inline-block; margin-right: 20px;"><?= $_SESSION["nome_cliente"] ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 px-5 table-responsive">
                <h4 class="py-2">Estratto conto</h4>
                <?php if(isset($data["estrattoconto"])){ ?>
                <table class="table table-striped " aria-describedby="tabella_prenotazioni">
                    <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Volo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Saldo punti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data["estrattoconto"]->getRighe() as $riga){ ?>
                        <tr>
                            <th scope="row"><?= $riga->getDataoraPartenza() ?></th>
                            <td><?= $riga->getDatiVolo() ?></td>
                            <td><?= $riga->getTipologia() ?></td>
                            <td><?= $riga->getPunti() ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <strong>Saldo: </strong><span class="py-2"><?= $data["estrattoconto"]->getSaldo() ?></span>
                    </div>
                </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <span class="py-2">Non c'è niente da visualizzare qui! Comincia a fare acquisti per accumulare punti.</span>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $dir ?>js/script.js"></script>
<?php include("../app/template/footer.php") ?>
</body>

</html>
