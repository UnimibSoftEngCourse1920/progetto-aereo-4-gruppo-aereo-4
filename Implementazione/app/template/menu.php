<nav class="navbar navbar-light bg-light navbar-expand-lg px-4 py-3">
    <a class="navbar-brand" href="/"><img id="logo" src="/public/img/logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <?php
            if(!isset($_SESSION["id_cliente"])) {?>
            <li class="nav-item">
                <a class="nav-link" href="/public/cliente/registrati">Registrati</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/public/cliente/accedi">Accedi</a>
            </li>
            <?php } else { ?>
            <li class="nav-item">
                <div class="profile-image">
                    <?=substr($_SESSION["nome_cliente"], 0, 1);?>
                </div>
                <div class="dropdown">
                    <p class="dropdown-toggle mb-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?=$_SESSION["nome_cliente"];?>
                    </p>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="/public/cliente/prenotazioni">Le tue prenotazioni</a>
                        <a class="dropdown-item" href="/public/cliente/esci">Esci</a>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>

    </div>
</nav>