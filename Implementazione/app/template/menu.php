<nav class="navbar navbar-light bg-light navbar-expand-lg px-4 py-3">
    <a class="navbar-brand" href="/"><img id="logo" src="/public/img/logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/public/cliente/registrati">Registrati</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/public/cliente/accedi">Accedi</a>
            </li>
        </ul>

    </div>
</nav>

<!--<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/public/">Gruppo Aereo 4</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php
                if(!isset($_SESSION["id_cliente"])) {?>
                    <a class="nav-link" href="/public/cliente/accedi">Login/Registrazione</a>
                <?php } else { ?>
                    <a class="nav-link" href="/public/cliente/prenotazioni"><?=$_SESSION["nome_cliente"];?> (<a href="/public/cliente/esci">Esci</a>)</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>-->