<!--<div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
        <div class="bg-dark p-4">
            <h4 class="text-white title-menu">Gruppo Aereo 4</h4>
                <div class="menu-voice">
                    <a href="<?php echo $dir ?>"> <span>Home</span> </a>
                </div>
                <div class="menu-account">
                    <a href="/public/cliente/login">
                        <span> <i class="fas fa-user"></i> Login / Registrati </span>
                    </a>
                </div>
        </div>
    </div>
    <nav class="navbar navbar-dark bg-transparent">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="/"><img id="logo" src="<?php echo $dir ?>img/logo.png" /></a>
    </nav>
</div>-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/public/">Gruppo Aereo 4</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php
                if(!isset($_SESSION["id_cliente"])) {?>
                    <a class="nav-link" href="/public/cliente/login">Login/Registrazione</a>
                <?php } else { ?>
                    <a class="nav-link" href="/public/cliente/prenotazioni"><?=$_SESSION["nome_cliente"];?> </a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>