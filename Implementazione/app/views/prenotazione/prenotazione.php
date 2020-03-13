<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Prenota</title>
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
                    <div class="d-flex mx-auto tariffa selected" id="tar_stand">
                        <em class="fas fa-paper-plane"></em>
                        <p class="mt-auto mx-auto">Tariffa Standard</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="d-flex mx-auto tariffa" id="tar_plus">
                        <em class="fas fa-rocket"></em>
                        <p class="mt-auto mx-auto">Tariffa VoloPlus</p>
                    </div>
                </div>
            </div>
            <div class="row mt-md-4">
                <div class="col">
                    <form class="py-md-4 px-md-5" id="form-prenotazione" action="../../effettuaPrenotazione" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <?php if(isset($_SESSION["id_cliente"])){ ?>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="<?= explode(" ",$_SESSION["nome_cliente"])[0]; ?>" >
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="name" id="nome" placeholder="Nome">
                                <?php } ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <?php if(isset($_SESSION["id_cliente"])){ ?>
                                    <input type="text" class="form-control" name="cognome" id="cognome" placeholder="Cognome" value="<?= explode(" ",$_SESSION["nome_cliente"])[1]; ?>" >
                                <?php } else { ?>
                                    <input type="text" class="form-control" name="cognome" id="cognome" placeholder="Cognome">
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="inputState">E-mail</label>
                                <?php if(isset($_SESSION["email_cliente"])){ ?>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?= $_SESSION["email_cliente"]?>">
                                <?php } else { ?>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail">
                                <?php } ?>
                            </div>
                        </div>

                        <input type="hidden" id="lista-passeggeri" name="lista">
                        <input type="hidden" name="id_volo" value="<?= $data["volo"]->getOID()?>">
                        <input type="hidden" name="nPass" value="<?= $data["pass"]?>">
                        <input type="hidden" id="tariffa" name="tariffa">

                        <?php for($i=1;$i<=$data["pass"];$i++){?>
                        <div class="form-row px-2 py-3">
                            Passeggero <?= $i ?>
                        </div>
                        <div class="form-row nome-cognome-pass">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Nome</label>
                                <input type="text" class="form-control nome" id="nome<?= $i ?>" placeholder="Nome">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputCity">Cognome</label>
                                <input type="text" class="form-control cognome" id="cognome<?= $i ?>" placeholder="Cognome">
                            </div>
                        </div>

                        <?php }?>
                        <?php if(!$data["volo"]->getDisponibilitaPosti($data["pass"])){ ?>
                        <div class="form-row px-3 pt-4 pb-3">
                            <div class="error mx-auto">Non ci sono più posti per questo volo.</div>
                        </div>
                        <?php } else { ?>
                        <div class="form-row pt-4">
                            <div class="form-group col-md-4 mx-auto">
                                <button type="submit" id="prenota-btn" class="btn btn-primary w-100">Prenota</button>
                            </div>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 px-md-5 mt-md-4" id="riepilogo">
            <div class="row pb-md-4">
                <div class="col-6"><h3>Biglietti</h3></div>
                <div class="col-6 text-right">
                    <h3 id="prezzo_base">
                        <?php
                        if($data["volo"]->getPrezzoIntero()==$data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))){
                            echo number_format($data["volo"]->getPrezzoIntero()*$data["pass"],2)."€";
                        } else {
                            echo number_format($data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"],2)."€ </h3><h3><strike style='font-size: 20px'>".number_format($data["volo"]->getPrezzoIntero()*$data["pass"],2)."€</strike>";
                        }?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong><?= $data["volo"]->getAeroportoPartenza()->getCitta()." ".$data["volo"]->getAeroportoPartenza()->getNome()." (".$data["volo"]->getAeroportoPartenza()->getCodice().")" ?></strong>
                        <br><?= $data["volo"]->getDataOraPartenza()?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong><?= $data["volo"]->getAeroportoDestinazione()->getCitta()." ".$data["volo"]->getAeroportoDestinazione()->getNome()." (".$data["volo"]->getAeroportoDestinazione()->getCodice().")" ?></strong>
                        <br><?= $data["volo"]->getDataOraArrivo()?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>
                        <strong>Viaggiatori</strong>
                        <br><?= $data["pass"] ?>
                    </p>
                </div>
            </div>
            <div class="row py-md-4" id="supplemento_row" style="display: none;">
                <div class="col-8"><h3>Supplementi</h3></div>
                <div class="col-4 text-right"><h3>20€</h3></div>
            </div>
            <div class="row" id="tariffa_row" style="display: none;">
                <div class="col">
                    <p>
                        <strong>Tariffa</strong>
                        <br>VoloPlus
                    </p>
                </div>
            </div>
            <div class="row py-md-4">
                <div class="col-6"><h3>Totale</h3></div>
                <div class="col-6 text-right">
                    <h3 id="prezzo_tot">
                        <?php
                        if($data["volo"]->getPrezzoIntero()==$data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))){
                            echo number_format($data["volo"]->getPrezzoIntero()*$data["pass"],2)."€";
                        } else {
                            echo number_format($data["volo"]->getPrezzoScontato(isset($_SESSION["id_cliente"]))*$data["pass"],2)."€";
                        }?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
