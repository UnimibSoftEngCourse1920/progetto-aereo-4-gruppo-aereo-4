<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>
<?php include("../app/template/menu.php") ?>
<div class="container pb-5 pt-5 mt-5">
    <div class="row">
        <div class="col text-center">
            <h2>Accedi alla tua area personale</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-auto">
            <form class="py-md-4 px-md-5" action="" method="post">
                <div class="form-row px-3 mb-4">
                    <div class="success mx-auto">Account registrato! Accedi compilando il form.</div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="email">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Indirizzo e-mail">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-row px-3 pt-4 pb-3">
                    <div class="error mx-auto">Combinazione e-mail/password non trovata.</div>
                </div>
                <div class="form-row pt-4">
                    <div class="form-group col-md-4 mx-auto">
                        <button type="submit" class="btn btn-primary w-100">Accedi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>
</html>