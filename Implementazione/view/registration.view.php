<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Gruppo Aereo 4 - Registrazione</title>
    <?php include("../template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="../css/style.css" />
</head>

<body>
<?php include("../template/menu.php") ?>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
				    <div class="col-md-3"></div>
					<div class="booking-form col-md-6">
						<form>
                            <div class="container">
                                <div class="row text-center mb-3">
                                    <h2>Registrati al programma fedeltà</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Nome</span>
                                        <input class="form-control" type="text" placeholder="Nome">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span class="form-label">Cognome</span>
                                        <input class="form-control" type="text" placeholder="Cognome">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <span class="form-label">Indirizzo</span>
                                        <input class="form-control" type="text" placeholder="Indirizzo">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <span class="form-label">Data di nascita</span>
                                        <input class="form-control" type="date" placeholder="">
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<span class="form-label">E-mail</span>
										<input class="form-control" type="text" placeholder="Email">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<span class="form-label">Password</span>
										<input class="form-control" type="password" placeholder="Password">
									</div>
								</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="form-label">Ripeti password</span>
                                        <input class="form-control" type="password" placeholder="Password">
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
		</div>
	</div>
	<?php include("../template/footer.php") ?>
</body>

</html>
