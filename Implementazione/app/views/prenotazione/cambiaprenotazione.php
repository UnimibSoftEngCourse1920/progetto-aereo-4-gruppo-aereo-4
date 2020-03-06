<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Modifica Prenotazione</title>
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
                            <h2>Modifica la tua prenotazione</h2>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6 p-0">
                                <strong>#:</strong>
                            </div>
                            <div class="col-md-6 ">
                                <strong>Numero persone:</strong>
                            </div>
                            <div class="col-md-6 p-0">
                                <strong>Da:</strong>
                            </div>
                            <div class="col-md-6 ">
                                <strong>A:</strong>
                            </div>
                        </div>
                    </div>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Data</span>
                                <input class="form-control" type="date" placeholder="Data">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Ora</span>
                                <select class="form-control" placeholder="Ora">
                                    <option> 9.30</option>
                                    <option> 12.30</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            </div>
                        <div class="col-md-6">
                            <div class="form-btn">
                                <button class="submit-btn">Modifica prenotazione</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
