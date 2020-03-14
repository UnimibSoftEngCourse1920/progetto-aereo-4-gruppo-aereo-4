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
                    <div class="col-md-12">
                        <h2>Pannello di amministrazione</h2>
                    </div>
                    <div class="row mt-5 w-100">
                        <div class="col-md-3"></div>
                        <div class="col-md-3 text-center">
                            <a href="voli">
                                <div class="d-flex mx-auto tariffa selected">
                                    <em class="fas fa-paper-plane"></em>
                                    <p class="mt-auto mx-auto">Voli</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="promozioni">
                                <div class="d-flex mx-auto tariffa selected">
                                    <em class="fas fa-ad"></em>
                                    <p class="mt-auto mx-auto">Promozioni</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .tariffa.selected:before{
        content: '' !important;
        background: none !important;
    }
</style>
<?php include("../app/template/footer.php") ?>
</body>

</html>
