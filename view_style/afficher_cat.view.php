<?php include "html/header.php" ?>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "myAbo";
        include "html/sidebar.php";
    ?>
    <?php
        // Inclusion des onglets de navigation
        $tab_mode = "catT";
        include "html/tabs_subs.php";
    ?>

    <div class="content">
    <!-- Le contenu va ici ! -->

        <div class="row">
            <div class="col-md-12">
                <div class="special-title-group">
                    <h4 class="title">Par catégories</h4>
                    <p>Affiche les dernières nouvelles triées par catégories</p>
                </div>

                <!-- On affiche les boutons de filtrage par catégories -->
                <form class="special-cat-bar" action="afficher_cat.ctrl.php" method="POST">
                    <?php foreach($data['cat'] as $cat) { ?>
                        <button name="categorie" type="submit" value="<?= $cat['nom'] ?>" 
                            class="btn <?= $cat['icon'] ?> btn-fill" <?= ($data['selectedCat']==$cat['nom']) ? "disabled" : ""?>>
                            <?= $cat['nom'] ?>
                        </button>
                    <?php } ?>
                </form>

                <!-- On affiche toutes les nouvelles de la catégorie sélectionnée -->
                <?php foreach($data['news'] as $nouvelle) { ?>
                    <div class="card">
                        <div class="header">
                            <h4 class="title"><?= $nouvelle->titre() ?></h4>
                            <p class="category"><i class="fa fa-clock-o"></i>  <?= $nouvelle->date() ?></p>
                        </div>
                        <div class="content">
                            <?php if ($nouvelle->urlimage()): ?>
                                <img src="<?=$nouvelle->urlimage() ?>" alt="image"><br><br>
                            <?php endif; ?>
                            <?=  $nouvelle->description() ?>    
                            <div class="footer">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-newspaper-o"></i>
                                    <?= $nouvelle->titreFlux ?>
                                    &nbsp;
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i> 
                                    <a href="<?= $nouvelle->urlParsed() ?>">Lire la nouvelle</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <nav class="pull-left">
            </nav>
            <p class="copyright pull-right">
                Projet de gestionnaire de flux RSS - <a href="http://iut2.univ-grenoble-alpes.fr">IUT2 Grenoble</a>
            </p>
        </div>
    </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>
    
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
    <script src="assets/js/light-bootstrap-dashboard.js"></script>

    <?php include "html/alert.php"; ?>
</html>