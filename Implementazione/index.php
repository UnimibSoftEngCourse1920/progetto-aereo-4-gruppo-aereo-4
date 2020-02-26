<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gruppo Aereo 4</title>
    <?php include("template/header.php") ?>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
</head>
<body>
    <?php include("template/menu.php") ?>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
				    <div class="col-md-3"></div>
					<div class="booking-form col-md-6">
						<form>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Da</span>
										<input class="form-control" type="text" placeholder="Città o aeroporto">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">A</span>
										<input class="form-control" type="text" placeholder="Città o aeroporto">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<span class="form-label">Partenza</span>
										<input class="form-control" type="date" required>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<span class="form-label">Adulti</span>
										<select class="form-control">
											<option>1</option>
											<option>2</option>
											<option>3</option>
										</select>
										<span class="select-arrow"></span>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<span class="form-label">Ragazzi</span>
										<select class="form-control">
											<option>0</option>
											<option>1</option>
											<option>2</option>
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
	</div>
	<?php include("template/footer.php") ?>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
