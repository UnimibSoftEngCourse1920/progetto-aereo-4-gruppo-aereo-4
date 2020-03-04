<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Login</title>
    <?php include("../app/template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include("../app/template/menu.php") ?>
    <div class="container body-cont">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="login-form col-md-6">
                <form action="" method="post">
                    <div class="container">
                        <div class="row text-center mb-3">
                            <h2>Accedi al pannello di amministrazione</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">Username</span>
                                <input class="form-control" type="text" name="username" placeholder="Username">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="form-label">Password</span>
                                <input class="form-control" type="password" name="password" placeholder="Password">
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
            </div>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
