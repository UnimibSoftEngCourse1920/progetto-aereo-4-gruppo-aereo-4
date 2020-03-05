<!DOCTYPE html>
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
            <table class="table table-striped ">
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
                        <td><button class="btn btn-select-flight"> Scegli questo volo <i class="fas fa-arrow-right"></i> </button></td>
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

</html>
