<div class="sidebar" data-color="orange" data-image="assets/img/sidebar-4.jpg">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="../index.php" class="simple-text">
                RSSFeed
            </a>
        </div>
        <ul class="nav">
            <li <?= $mode=="allF" ? 'class="active"' : ""?>>
                <a href="afficher_flux.ctrl.php">
                    <i class="pe-7s-global"></i>
                    <p>Afficher tous les flux</p>
                </a>
            </li>
            <li <?= $mode=="myAbo" ? 'class="active"' : ""?>>
                <a href="manage_subs.ctrl.php">
                    <i class="pe-7s-signal"></i>
                    <p>Mes abonnements</p>
                </a>
            </li>
            <li <?= $mode=="addF" ? 'class="active"' : ""?>>
                <a href="add_flux.ctrl.php">
                    <i class="pe-7s-plus"></i>
                    <p>Ajouter un flux</p>
                </a>
            </li>
            <li <?= $mode=="upF" ? 'class="active"' : ""?>>
                <a href="force_update.ctrl.php">
                    <i class="pe-7s-refresh-2"></i>
                    <p>Mettre à jour un flux</p>
                </a>
            </li>
            <li <?= $mode=="cleanF" ? 'class="active"' : ""?>>
                <a href="clean_flux.ctrl.php">
                    <i class="pe-7s-trash"></i>
                    <p>Vidanger un flux</p>
                </a>
            </li>
            <li <?= $mode=="deleteF" ? 'class="active"' : ""?>>
                <a href="delete_flux.ctrl.php">
                    <i class="pe-7s-close-circle"></i>
                    <p>Supprimer un flux</p>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="main-panel">
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Menu</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="search.ctrl.php">
                            <i class="fa fa-search"></i>
                            <p class="hidden-lg hidden-md">Search</p>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                        if (session_status() == PHP_SESSION_NONE) session_start();

                        if (!isset($_SESSION["user"]) or $_SESSION["user"] == null) {
                            $fct_txt = 'Se connecter';
                            $rdir_url = 'signin.ctrl.php';
                        } else {
                            $fct_txt = 'Se déconnecter';
                            $rdir_url = 'logout.ctrl.php';
                        }?>
                        <a href="<?= $rdir_url ?>">
                            <?php
                                if (isset($_GET['delogged'])) {
                                    // On affiche un message à la déconnexion de l'utilisateur
                                    $alert['message'] .= "Vous vous êtes bien déconnecté de votre compte";
                                    $alert['type'] = "success";
                                    $alert['icon'] = "pe-7s-check";
                                } elseif (isset($_GET['logged'])) {
                                    // On affiche un message à la connexion de l'utilisateur
                                    $alert['message'] .= "Bienvenue sur votre compte !";
                                    $alert['type'] = "success";
                                    $alert['icon'] = "pe-7s-check";
                                }
                            ?>
                            <p><?= $fct_txt ?></p>
                        </a>
                    </li>
                    <li class="separator hidden-lg hidden-md"></li>
                </ul>
            </div>
        </div>
    </nav>