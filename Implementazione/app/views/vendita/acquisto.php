<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>
<?php include("../app/template/menu.php") ?>
<div class="container pb-5 pt-5 mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Completa il tuo acquisto</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mt-md-4">
            <?php if(isset($_SESSION["id_cliente"])) {?>
            <div class="row mt-2">
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa selected" id="button-carta">
                        <em class="fas fa-credit-card"></em>
                        <p class="mt-auto mx-auto">Paga con la carta</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa" id="button-punti">
                        <em class="fas fa-coins"></em>
                        <p class="mt-auto mx-auto">Paga con i punti</p>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="row mt-md-4" id="pagamento-carta">
                <div class="col">
                    <form class="px-md-5" action="logged.html" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control" id="cognome" placeholder="Cognome" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Numero Carta</label>
                                <input type="number" class="form-control" placeholder="Numero carta" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">CVV</label>
                                <input type="number" class="form-control" placeholder="CVV" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Scadenza</label>
                                <input autocomplete="off" type="text" class="form-control date-ym-picker" placeholder="Scadenza" required>
                            </div>
                        </div>
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non è stato possibile completare la transazione.</div>
                        </div>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Paga</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if(isset($_SESSION["id_cliente"])) {?>
            <div class="row mt-md-4" id="pagamento-punti" style="display:none">
                <div class="col">
                    <form class="pt-md-4 px-md-5" action="/public/vendita/acquistaPrenotazione" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <strong>Punti acquisiti</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                12312312312
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <strong>Punti necessari</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                12312321
                            </div>
                        </div>
                        <div class="form-row pt-3" style="border-top: 1px solid #eee;">
                            <div class="form-group col-md-6">
                                <strong>Punti rimanenti</strong>
                            </div>
                            <div class="form-group col-md-6 text-right">
                                1231232112
                            </div>
                        </div>
                        <input type="hidden" name="id_prenotazione" value="<?=$data["id_prenotazione"]?>">
                        <input type="hidden" name="id_cliente" value="<?=$data["id_cliente"]?>">
                        <input type="hidden" name="metodo_pagamento" value="punti">
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non hai punti a sufficienza.</div>
                        </div>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" class="btn btn-primary w-100">Paga</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php } ?>
            <small class="text-center">oppure</small>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 pt-md-4">
                    <button type="submit" class="btn btn-primary w-100">Paga più tardi</button>
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