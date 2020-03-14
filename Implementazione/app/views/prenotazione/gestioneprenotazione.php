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
                    <?php if($data["acquistato"]){ ?>
                        <div class="row mt-5 w-100">
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <div class="d-flex mx-auto tariffa selected">
                                    <em class="fas fa-wallet"></em>
                                    <p class="mt-auto mx-auto">Completa il tuo acquisto</p>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row mt-5 w-100">
                            <div class="col-md-2"></div>
                            <div class="col-md-4 text-center">
                                <div class="d-flex mx-auto tariffa selected">
                                    <em class="fas fa-file-download"></em>
                                    <p class="mt-auto mx-auto">Scarica Biglietti</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="d-flex mx-auto tariffa selected">
                                    <em class="fas fa-calendar-alt"></em>
                                    <p class="mt-auto mx-auto">Modifica Data</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
