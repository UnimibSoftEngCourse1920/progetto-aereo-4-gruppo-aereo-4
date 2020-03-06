<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Registrazione</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include("../app/template/menu.php") ?>
    <div class="container body-cont">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="login-form col-md-6">
                <form action="/public/cliente/registrati" method="post">
                    <div class="container">
                        <div class="row text-center mb-3">
                            <h2>Registrati al programma fedeltà</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Nome</span>
                                <input class="form-control" type="text" placeholder="Nome" name="nome">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-label">Cognome</span>
                                <input class="form-control" type="text" placeholder="Cognome" name="cognome">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <span class="form-label">Indirizzo</span>
                                <input class="form-control" type="text" placeholder="Indirizzo" name="indirizzo">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <span class="form-label">Data di nascita</span>
                                <input class="form-control" type="date" placeholder="" name="data_nascita">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">E-mail</span>
                                <input class="form-control" type="text" placeholder="Email" name="email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">Password</span>
                                <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">Ripeti password</span>
                                <input class="form-control" type="password" placeholder="Password" name="conferma_password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            </div>
                        <div class="col-md-6">
                            <div class="form-btn">
                                <button class="submit-btn">Registrati</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
