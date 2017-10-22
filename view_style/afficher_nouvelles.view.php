<?php include "html/header.php" ?>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "allF";
        include "html/sidebar.php";
    ?>   
    <?php
        // Inclusion des onglets de navigation
        $tab_mode = "allfT";
        include "html/tabs_allflux.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <h5 class="title special-h5">
            <a href = "afficher_flux.ctrl.php">Tous les flux</a> <
            <a href = "afficher_nouvelles.ctrl.php?rssID=<?= $data ? $data[0]->RSS_id() : "" ?>"><?= $data ? $data[0]->RSStitre : ""?></a>
        </h5>
        <div class="row">
            <div class="col-md-12">
                <?php foreach($data as $nouvelle) { ?>
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
                            <br><br>
                            <div class="footer">
                                <hr>
                                <div class="stats">
                                    <i class="fa fa-arrow-right"></i> 
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
