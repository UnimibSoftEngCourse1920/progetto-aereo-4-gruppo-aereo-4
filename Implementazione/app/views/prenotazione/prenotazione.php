<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Completa Prenotazione</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include("../app/template/menu.php") ?>
    <div class="container body-cont">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="login-form col-md-6">
                    <div class="container">
                        <div class="row text-center mb-3">
                            <h2>Conferma la tua prenotazione</h2>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-12 p-0">
                                <h5>Dettagli Volo</h5>
                            </div>
                            <div class="col-md-6 p-0">
                                <b>Da:</b> <?=$data["volo"]->getAeroportoPartenza()?>
                            </div>
                            <div class="col-md-6 ">
                                <b>A:</b> <?=$data["volo"]->getAeroportoDestinazione()?>
                            </div>
                            <div class="col-md-6 p-0">
                                <b>Il giorno:</b> <?=$data["volo"]->getData()?>
                            </div>
                            <div class="col-md-6 ">
                                <b>Alle ore:</b> <?=$data["volo"]->getOrarioPartenza()?>
                            </div>
                        </div>
                    </div>
                <form action="/public/prenotazione/prenota" method="post">
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <span class="form-label">E-mail:</span>
                                <input class="form-control" type="text" placeholder="Email">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="form-label">Passeggeri</span>
                                <select class="form-control" name="numAdulti">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                                <span class="select-arrow"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            </div>
                        <div class="col-md-6">
                            <div class="form-btn">
                                <button class="submit-btn">Paga subito</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span style="font-size:10px;"> OPPURE </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center pt-2">
                            <a href="" style="font-size:20px;"> Paga più avanti </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
