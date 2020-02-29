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
        <div class="col-md-12 px-5">
            <h4 class="py-2">La tua ricerca ha prodotto i seguenti risultati:</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Da</th>
                    <th scope="col">A</th>
                    <th scope="col">Ora</th>
                    <th scope="col">Data</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1023</th>
                    <td>Milano </td>
                    <td>Barcellona</td>
                    <td>9:30</td>
                    <td>2/3/2020</td>
                    <td>40€</td>
                    <td><button class="btn btn-select-flight"> Scegli questo volo <i class="fas fa-arrow-right"></i> </button></td>
                </tr>
                <tr>
                    <th scope="row">2212</th>
                    <td>Milano </td>
                    <td>Barcellona</td>
                    <td>12:30</td>
                    <td>2/3/2020</td>
                    <td>40€</td>
                    <td><button class="btn btn-select-flight"> Scegli questo volo <i class="fas fa-arrow-right"></i> </button></td>
                </tr>
                <tr>
                    <th scope="row">3022</th>
                    <td>Milano </td>
                    <td>Barcellona</td>
                    <td>17:30</td>
                    <td>2/3/2020</td>
                    <td>40€</td>
                    <td><button class="btn btn-select-flight"> Scegli questo volo <i class="fas fa-arrow-right"></i> </button></td>
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
