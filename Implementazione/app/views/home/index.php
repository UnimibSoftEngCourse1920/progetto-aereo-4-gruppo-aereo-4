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
	<?php include("../app/template/footer.php") ?>
</body>

</html>
