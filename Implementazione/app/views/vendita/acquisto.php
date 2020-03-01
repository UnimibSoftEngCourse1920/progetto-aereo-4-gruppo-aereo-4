<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Acquisto</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="body-cont px-4">
    <div class="row">
        <div class="container">

            <div class="login-form">
                <h4 class="py-2">Completa il tuo acquisto</h4>
                <span>Per ogni passeggero inserisci nome e cognome:</span>
                <form >
                    <div class="container p-0 mt-3">
                        <div class="row">
                        <?php
                            for($i=0; $i<3; $i++){?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Nome</span>
                                        <input class="form-control" type="text" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Cognome</span>
                                        <input class="form-control" type="text" placeholder="Cognome">
                                    </div>
                                </div>
                         <?php  } ?>
                        </div>
                    </div>
                    <?php if(isset($_SESSION["fedelta"])) {?>

                    <?php } else { ?>
                        <h4 class="py-2">Inserisci i dati di pagamento</h4>
                        <div class="container p-0 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Nome intestatario carta </span>
                                        <input class="form-control" type="text" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Cognome intestatario carta</span>
                                        <input class="form-control" type="text" placeholder="Cognome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Numero carta</span>
                                        <input class="form-control" type="text" placeholder="Numero carta">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <span class="form-label">CVV</span>
                                        <input class="form-control" type="text" placeholder="CVV">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <span class="form-label">Scadenza</span>
                                        <input class="form-control" type="month" placeholder="Scadenza">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6">
                            <div class="form-btn">
                                <button class="submit-btn">Completa acquisto</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $dir ?>js/script.js"></script>
<?php include("../app/template/footer.php") ?>
</body>

</html>
