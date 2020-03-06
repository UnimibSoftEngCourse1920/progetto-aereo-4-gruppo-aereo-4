<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Gestione voli</title>
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
                        <h2>Gestione dei voli</h2>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#nuovoVoloModal"> + Aggiungi volo </button>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-12">
                        <table class="table table-striped " aria-describedby="tabella_voli">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Da</th>
                                <th scope="col">A</th>
                                <th scope="col">Data e ora partenza</th>
                                <th scope="col">Data e ora arrivo</th>
                                <th scope="col">Miglia</th>
                                <th scope="col">Operazioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                foreach ($data["voli"] as $volo){
                                    echo "<tr>
                                            <th scope='row'>".$volo->getOID()."</th>
                                            <td>".$volo->getAeroportoPartenza()." </td>
                                            <td>".$volo->getAeroportoDestinazione()."</td>
                                            <td>".$volo->getDataOraPartenza()."</td>
                                            <td>".$volo->getDataOraArrivo()."</td>
                                            <td>".$volo->getMiglia()."</td>
                                            <td>
                                                <button class='btn btn-danger'> <em class='fas fa-trash-alt'></em> Elimina </button>
                                                <button class='btn btn-warning'> <em class='fas fa-pencil-alt'></em> Modifica </button>
                                            </td>
                                            </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="nuovoVoloModal" tabindex="-1" role="dialog" aria-labelledby="nuovoVoloModal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="inserisciVolo" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Nuovo volo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="model">Data e ora di partenza</label>
                                    <input type="datetime-local" class="form-control" name="giornopartenza" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="model">Data e ora di partenza</label>
                                    <input type="datetime-local" class="form-control" name="giornoarrivo" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="title">Partenza</label>
                                    <select name="partenza" class="form-control">
                                        <?php
                                            foreach ($data["aeroporti"] as $aeroporto){
                                               echo "<option value='".$aeroporto->getOID()."'>".$aeroporto->getNome()."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dataset">Destinazione</label>
                                    <select name="destinazione" class="form-control">
                                        <?php
                                        foreach ($data["aeroporti"] as $aeroporto){
                                            echo "<option value='".$aeroporto->getOID()."'>".$aeroporto->getNome()."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Codice Aereo</label>
                                    <select name="aereo" class="form-control">
                                        <?php
                                        foreach ($data["aerei"] as $aereo){
                                            echo "<option value='".$aereo->getOID()."'>".$aereo->getMarcaModello()."</option>";
                                        }
                                        ?>
                                    </select>
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
