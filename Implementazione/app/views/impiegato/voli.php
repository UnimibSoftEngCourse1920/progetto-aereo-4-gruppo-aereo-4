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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#nuovoVoloModal"> <i class="fas fa-arrow-left"></i> Indietro </button>
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
                        <table class="table table-striped ">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Da</th>
                                <th scope="col">A</th>
                                <th scope="col">Data</th>
                                <th scope="col">Ora</th>
                                <th scope="col">Miglia</th>
                                <th scope="col">Operazioni</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Milano </td>
                                <td>Barcellona</td>
                                <td>2/3/2020</td>
                                <td>9:30</td>
                                <td>100</td>
                                <td>
                                    <button class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Elimina </button>
                                    <button class="btn btn-warning"> <i class="fas fa-pencil-alt"></i> Modifica </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Milano </td>
                                <td>Barcellona</td>
                                <td>2/3/2020</td>
                                <td>6:30</td>
                                <td>100</td>
                                <td>
                                    <button class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Elimina </button>
                                    <button class="btn btn-warning"> <i class="fas fa-pencil-alt"></i> Modifica </button>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Milano </td>
                                <td>Barcellona</td>
                                <td>2/3/2020</td>
                                <td>14:30</td>
                                <td>100</td>
                                <td>
                                    <button class="btn btn-danger"> <i class="fas fa-trash-alt"></i> Elimina </button>
                                    <button class="btn btn-warning"> <i class="fas fa-pencil-alt"></i> Modifica </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="nuovoVoloModal" tabindex="-1" role="dialog" aria-labelledby="nuovoVoloModal" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Nuovo volo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Partenza</label>
                                <input type="text" class="form-control" id="title" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="dataset">Destinazione</label>
                                <input type="text" class="form-control" id="dataset" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="model">Miglia</label>
                                <input type="text" class="form-control" id="model" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="model">Data</label>
                                <input type="date" class="form-control" id="model" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="model">Ora</label>
                                <input type="time" class="form-control" id="model" placeholder="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Annulla</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="add-request">Salva</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
