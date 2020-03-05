<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gruppo Aereo 4 - Admin</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../app/template/menu.php") ?>
<div class="container body-cont">
    <div class="row">
        <div class="login-form col-md-12 mt-5">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                       <a href="voli">
                           <button class="btn btn-primary btn-lg mb-3">
                            <h4> <i class="fas fa-plane-departure"></i> Gestione dei voli</h4>
                        </button>
                       </a><br>
                        <a href="promozioni">
                        <button  class="btn btn-primary btn-lg mt-3">
                            <h4> <i class="fas fa-percentage"></i> Gestione delle promozioni</h4>
                        </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>

</html>
