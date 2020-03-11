<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Modifica volo</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="container body-cont">
    <div class="row">
        <div class="login-form col-md-12">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-3">
                        <a href="voli">
                            <button class="btn btn-primary"> <em class="fas fa-arrow-left"></em> Indietro </button>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <h2>Modifica del volo #<?php echo $data["volo"]->getOID()?></h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-6 p-0">
                        <strong>Da:</strong> <?=$data["volo"]->getAeroportoPartenza()->getCodice()?>
                    </div>
                    <div class="col-md-6 ">
                        <strong>A:</strong> <?=$data["volo"]->getAeroportoDestinazione()->getCodice()?>
                    </div>
                    <div class="col-md-12">
                        <form action="modificaVolo" method="post">
                            <input type="hidden"> <?php echo $data["volo"]->getOID()?> </input>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
