<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Login</title>
    <?php include("../template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include("../template/menu.php") ?>
    <div class="container body-cont">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="login-form col-md-6">
                <form>
                    <div class="container">
                        <div class="row text-center mb-3">
                            <h2>Accedi alla tua area riservata</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">E-mail:</span>
                                <input class="form-control" type="text" placeholder="Email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">Password</span>
                                <input class="form-control" type="password" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            </div>
                        <div class="col-md-6">
                            <div class="form-btn">
                                <button class="submit-btn">Login</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <span style="font-size:10px;"> OPPURE </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center pt-2">
                            <a href="https://gruppoaereo4.000webhostapp.com/view/registration.view.php" style="font-size:20px;"> Registrati </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php include("../template/footer.php") ?>
</body>

</html>
