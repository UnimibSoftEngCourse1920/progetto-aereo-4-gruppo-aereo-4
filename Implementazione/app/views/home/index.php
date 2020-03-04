<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>

</head>
<body>
    <?php include("../app/template/menu.php") ?>
	<div id="booking" class="section">
        <div class="container py-5">
            <div class="row py-5 my-5">
                <div class="col-md-3"></div>
                <div class="booking-form col-md-6 my-5">
                    <form action="/public/vendita/consultaVoli" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="form-label">Da</span>
                                    <input class="form-control"  id="partenza" type="text" placeholder="Città test o aeroporto" name="partenza">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="form-label">A</span>
                                    <input class="form-control"  type="text" placeholder="Città o aeroporto" name="destinazione">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <span class="form-label">Partenza</span>
                                    <input class="form-control" type="date" required name="data">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <span class="form-label">Passeggeri</span>
                                    <select class="form-control" name="numAdulti">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                    <span class="select-arrow"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-btn">
                                    <button class="submit-btn">Mostra voli</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
	</div>
    <style>
        .navbar-dark .navbar-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,<svg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'><path stroke='rgba(102, 102, 102, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/></svg>");
        }
        .navbar:after {
            display: block;
            content: '';
            width: 700px;
            height: 500px;
            top: 0;
            left: 0;
            position: absolute;
            transform: translate(-50%, -50%);
            background: radial-gradient(rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 20%, rgba(255, 255, 255, 0) 70%);
        }
    </style>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
