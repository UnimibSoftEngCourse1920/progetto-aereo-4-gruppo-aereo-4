<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Registrazione</title>
    <?php include("../template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../template/menu.php") ?>
<div class="body-cont px-4">
    <div class="row">
        <div class="col-md-2">
            <div id="containercircle"></div>
            <div class="col-md-12 pt-3">
            <h5>I tuoi dati:</h5>
            Nome <br>
                Cognome <br>
                Email <br>
                Indirizzo <br>
                <button type="button" class="btn btn-danger mt-2">Elimina account</button>
            </div>
        </div>
        <div class="col-md-10 px-5">
            <h4 class="py-2">Le tue prenotazioni:</h4>
            <table class="table table-striped">
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?php echo $dir ?>js/script.js"></script>
<?php include("../template/footer.php") ?>
</body>

</html>
