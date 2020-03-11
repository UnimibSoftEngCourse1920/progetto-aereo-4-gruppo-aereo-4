<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Gestione promozioni</title>
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
                        <a href="admin">
                            <button class="btn btn-primary"> <em class="fas fa-arrow-left"></em> Indietro </button>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <h2>Gestione promozioni</h2>
                    </div>
                    <div class="col-md-3"> <button class="btn btn-primary" data-toggle="modal" data-target="#nuovaPromozioneModal"> + Aggiungi promozione </button></div>
                </div>
            </div>
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-12">
                        <table class="table table-striped " aria-describedby="tabella_promozioni">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Data di inizio</th>
                                <th scope="col">Data di fine</th>
                                <th scope="col">Codice volo</th>
                                <th scope="col">Sconto</th>
                                <th scope="col">Fedeltà</th>
                                <th scope="col">Operazioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($data["promozioni"] as $promozione){
                                $fed = "No";
                                if($promozione->isFedelta()) {
                                    $fed = "Si";
                                }

                                echo "<tr>
                                            <th scope='row'>".$promozione->getOID()."</th>
                                            <td>".$promozione->getNome()." </td>
                                            <td>".$promozione->getDataInizio()."</td>
                                            <td>".$promozione->getDataFine()."</td>
                                            <td> WIP </td>
                                            <td>".$promozione->getSconto()."</td>
                                            <td>".$fed."</td>
                                            <td>
                                                <a href='cancellaPromozione/".$promozione->getOID()."'><button class='btn btn-danger'> <em class='fas fa-trash-alt'></em> Cancella </button></a>
                                            </td>
                                            </tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="nuovaPromozioneModal" tabindex="-1" role="dialog" aria-labelledby="nuovaPromozioneModal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="inserisciPromozione" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Nuova promozione</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="title">Nome</label>
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="dataset">Sconto (in percentuale)</label>
                                    <input type="text" class="form-control" name="sconto" id="sconto" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="model">Data inizio</label>
                                    <input type="date" class="form-control" name="datainizio" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="model">Data fine</label>
                                    <input type="date" class="form-control" name="datafine" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="model">Volo</label>
                                    <select name="volo" class="form-control" multiple>
                                        <option value="no">Nessuno</option>
                                        <?php
                                        foreach ($data["voli"] as $volo){
                                            echo "<option value='".$volo->getOID()."'>".$volo->getOID()."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="model">Promozione fedeltà</label><br>
                                    <input type="radio" id="si" name="fedelta" value=1>
                                    <label for="male">Si</label><br>
                                    <input type="radio" id="no" name="fedelta" value=0>
                                    <label for="female">No</label><br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Annulla</button>
                                <button type="submit" class="btn btn-success">Salva</button>
                            </div>
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
