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
            <h2>Cambia la data del volo</h2>
        </div>
    </div>
    <div class="row volo p-md-5">
        <div class="col-md-3"></div>
        <div class="col-md-2 text-center">
            <div class="orario">13:00 MXP</div>
            <div class="data">18/03/2020</div>
        </div>
        <div class="col-md-2 align-self-center" style="position:relative;">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8  px-0">
                    <div class="flight-line"></div>
                    <i class="fas fa-plane-departure float-left pr-1"></i>
                    <i class="fas fa-plane-arrival float-right pl-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-2 text-center">
            <div class="orario">14:30 ORY</div>
            <div class="data">18/03/2020</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-auto">
            <form class="py-md-4 px-md-5" action="logged.html" method="post">
                <div class="form-row">
                    <div class="form-group col">
                        <label for="inputCity">Nuova Data</label>
                        <input type="text" class="form-control datepicker hasDatepicker" id="datepicker" placeholder="Nuova data di partenza">
                    </div>
                </div>
                <div class="form-row pt-4">
                    <div class="form-group col-md-4 mx-auto">
                        <button type="submit" class="btn btn-primary w-100">Cerca voli</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-md-4">
            <div class="row">
                <div class="col-md-8" style="border-right: 1px solid #eee">
                    <div class="row mb-5">
                        <div class="col-md-6 text-center">
                            <div class="d-flex mx-auto tariffa selected">
                                <p class="mx-auto my-auto">
                                    <b>Partenza</b><br>
                                    2020-06-10 12:00<br><br>
                                    <b>Arrivo</b><br>
                                    2020-06-10 14:00
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="d-flex mx-auto tariffa">
                                <p class="mx-auto my-auto">
                                    <b>Partenza</b><br>
                                    2020-06-10 12:00<br><br>
                                    <b>Arrivo</b><br>
                                    2020-06-10 14:00
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="d-flex mx-auto tariffa">
                                <p class="mx-auto my-auto">
                                    <b>Partenza</b><br>
                                    2020-06-10 12:00<br><br>
                                    <b>Arrivo</b><br>
                                    2020-06-10 14:00
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="d-flex mx-auto tariffa">
                                <p class="mx-auto my-auto">
                                    <b>Partenza</b><br>
                                    2020-06-10 12:00<br><br>
                                    <b>Arrivo</b><br>
                                    2020-06-10 14:00
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row  mb-5">
                        <div class="col-md-12 text-center">
                            <div class="d-flex mx-auto tariffa">
                                <i class="fas fa-paper-plane"></i>
                                <p class="mt-auto mx-auto">Tariffa Standard</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="d-flex mx-auto tariffa selected">
                                <i class="fas fa-rocket"></i>
                                <p class="mt-auto mx-auto">Tariffa VoloPlus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 mt-auto">
            <form class="py-md-4 px-md-5" action="logged.html" method="post">
                <div class="form-row pt-4">
                    <div class="form-group col-md-4 mx-auto">
                        <button type="submit" class="btn btn-primary w-100">Cambia data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include("../app/template/footer.php") ?>
</body>
</html>