<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Area fedeltà</title>
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
            <div class="col-md-10 mt-2">
                <h2 style="display: inline-block; margin-right: 20px;"><?= $_SESSION["nome_cliente"] ?></h2>
                <span><em class="fas fa-coins"></em>  <?= $data["cliente"]->getSaldoPunti(); ?> </span><br>
                <span> <?= $data["cliente"]->getIndirizzo(); ?> </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 px-5 table-responsive">
                <h4 class="py-2">Le tue prenotazioni:</h4>
                <table class="table table-striped " aria-describedby="tabella_prenotazioni">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Da</th>
                        <th scope="col">A</th>
                        <th scope="col">Data</th>
                        <th scope="col">Pagamento</th>
                        <th scope="col">Punti</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data["prenotazioni"] as $prenotazione){ ?>
                        <tr>
                            <th scope="row"><?= $prenotazione->getOID() ?></th>
                            <td><?= $prenotazione->getVolo()->getAeroportoPartenza()->getCitta() ?> </td>
                            <td><?= $prenotazione->getVolo()->getAeroportoDestinazione()->getCitta() ?> </td>
                            <td><?= $prenotazione->getData() ?></td>
                            <td>
                                <?php
                                    $listaAcquisti = $prenotazione->getListaAcquisti();
                                    if($listaAcquisti!=null) {
                                        echo "Pagato";
                                    } else {
                                        echo "Non Pagato";
                                    }
                                    ?>
                            </td>
                            <td>
                                <?php
                                    $sommaPunti = 0;
                                    foreach ($listaAcquisti as $acquisto){
                                        $sommaPunti+=$acquisto->getPuntiAccumulati();
                                    }
                                    echo $sommaPunti;
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-md-12">
                <a href="richiediEstrattoConto/<?=$_SESSION["id_cliente"]?>" style="text-decoration: none;"><button> Richiedi estratto conto </button>
                <a href="annullaIscrizione/<?=$_SESSION["id_cliente"]?>"  style="text-decoration: none;"><button> Elimina account </button></a>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $dir ?>js/script.js"></script>
<?php include("../app/template/footer.php") ?>
</body>

</html>
