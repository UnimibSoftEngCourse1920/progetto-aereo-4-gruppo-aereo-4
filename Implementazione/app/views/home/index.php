<!doctype html>
<html lang="en">
<head>
    <title>Gruppo Aereo 4</title>
    <?php include("../app/template/header.php") ?>
</head>
<body>
    <?php include("../app/template/menu.php") ?>
    <div class="container-fluid">
        <div class="row" id="promozione">
            <div class="col p-2">
                <center><a href="#">Sconto del 20% fino al 20/03/2020 su una selezione di voli.</a></center>
            </div>
        </div>
        <div class="row" id="header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" style="position: absolute;  bottom: 0;">
                <path fill="#fff" fill-opacity="1" d="M0,160L48,165.3C96,171,192,181,288,170.7C384,160,480,128,576,117.3C672,107,768,117,864,138.7C960,160,1056,192,1152,192C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-auto">
                <form class="bg-dark py-md-4 px-md-5" id="form-ricerca" action="consulta.html" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Da</label>
                            <input type="text" class="form-control aeroporto" id="inputEmail4" placeholder="Città o aeroporto">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">A</label>
                            <input type="text" class="form-control aeroporto" id="inputPassword4" placeholder="Città o aeroporto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Data</label>
                            <input type="text" class="form-control datepicker" id="datepicker" placeholder="Data di partenza">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputState">Viaggiatori</label>
                            <input type="number" id="inputNumber" name="inputNumber" value="1" min="1">
                        </div>
                        <div class="form-group col-md-3 mt-auto">
                            <button type="submit" class="btn btn-primary w-100">Cerca voli</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="container pb-5 mb-5">
        <div class="row pt-md-5 mt-md-5 pb-md-5 px-md-5">
            <h2>In promozione</h2>
        </div>
        <div class="row pb-md-5 mb-md-5">
            <div class="col-md-4">
                <div class="promozione" style="background: url('img/roma.jpg')">
                    <div class="volo p-md-3">
                        <div class="tratta">Milano - Roma</div>
                        <div class="data">07/03/2020</div>
                        <div class="prezzo">
                            60€
                            <strike>70€</strike>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="promozione" style="background: url('img/parigi.jpg')">
                    <div class="volo p-md-3">
                        <div class="tratta">Firenze - Parigi</div>
                        <div class="data">10/03/2020</div>
                        <div class="prezzo">
                            72€
                            <strike>80€</strike>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="promozione" style="background: url('img/londra.jpg')">
                    <div class="volo p-md-3">
                        <div class="tratta">Roma - Londra</div>
                        <div class="data">15/03/2020</div>
                        <div class="prezzo">
                            85€
                            <strike>93€</strike>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php include("../app/template/footer.php") ?>
</body>

</html>
