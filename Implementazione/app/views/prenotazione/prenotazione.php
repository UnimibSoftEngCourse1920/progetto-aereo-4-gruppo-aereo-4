<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Login</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="container pb-5 pt-5 mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Conferma la tua prenotazione</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mt-md-4">
            <div class="row mt-2">
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa">
                        <em class="fas fa-paper-plane"></em>
                        <p class="mt-auto mx-auto">Tariffa Standard</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa selected">
                        <em class="fas fa-rocket"></em>
                        <p class="mt-auto mx-auto">Tariffa VoloPlus</p>
                    </div>
                </div>
            </div>
            <div class="row mt-md-4">
                <div class="col">
                    <form class="py-md-4 px-md-5" action="acquisto.html" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputState">E-mail</label>
                                <input type="email" class="form-control" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="form-row px-2 py-3">
                            Passeggero #1
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="form-row px-2 py-3">
                            Passeggero #2
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="form-row px-2 py-3">
                            Passeggero #3
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome">
                            </div>
                        </div>
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non ci sono più posti per questo volo.</div>
                        </div>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Prenota</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-md-5 mt-md-4" id="riepilogo">
            <div class="row pb-md-4">
                <div class="col-8"><h3>Biglietti</h3></div>
                <div class="col-4 text-right"><h3>340€</h3></div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Milano Malpensa (MXP)</strong>
                        <br>2020-04-04 04:30
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Londra Stansted (STN)</strong>
                        <br>2020-04-04 19:00
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Viaggiatori</strong>
                        <br>3
                    </p>
                </div>
            </div>
            <div class="row py-md-4">
                <div class="col-8"><h3>Supplementi</h3></div>
                <div class="col-4 text-right"><h3>10€</h3></div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Tariffa</strong>
                        <br>VoloPlus
                    </p>
                </div>
            </div>
            <div class="row py-md-4">
                <div class="col-8"><h3>Totale</h3></div>
                <div class="col-4 text-right"><h3>350€</h3></div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
