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
        $tab_mode = "dateT";
        include "html/tabs_allflux.php";
    ?>

    <div class="content">
    <!-- Le contenu va ici ! -->

        <div class="row">
            <div class="col-md-12">
                <div class="special-title-group">
                    <h4 class="title">Par dates</h4>
                    <p>Affiche les dernières nouvelles triées par date</p>
                </div>

                <!-- On affiche les boutons de filtrage par date -->
                <form class="special-cat-bar" action="afficher_date.ctrl.php" method="POST">
                    <button name="time" type="submit" value="ajd" class="btn btn-success btn-fill" <?= ($data['selectedDate']=="ajd") ? "disabled" : ""?>>
                        Aujourd'hui
                    </button>
                    <button name="time" type="submit" value="week" class="btn btn-default btn-fill" <?= ($data['selectedDate']=="week") ? "disabled" : ""?>>
                        La semaine passée
                    </button>
                    <button name="time" type="submit" value="all" class="btn btn-warning btn-fill" <?= ($data['selectedDate']=="all") ? "disabled" : ""?>>
                        Cette année
                    </button>
                </form>

                <?php if (isset($data['news'])): ?>
                    <!-- On affiche toutes les nouvelles retournées par ces filtres -->
                    <?php foreach($data['news'] as $nouvelle) { ?>
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?= $nouvelle->titre() ?></h4>
                                <p class="category"><i class="fa fa-clock-o"></i>  <?= $nouvelle->date() ?></p>
                            </div>
                            <div class="content">
                                <?php if ($nouvelle->urlimage()): ?>
                                    <img src="<?=$nouvelle->urlimage() ?>" class="img-thumbnail" alt="image"><br><br>
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
                <?php endif; ?>
            </div>
        </div>

        <!-- On affiche les éventuels messages d'erreur -->
        <?php if (isset($noResult)): ?>
            <div class="special-no-result">                
                <h4 class="title"><?= $noResult['type'] ?></h4>
                <p class="category"><?= $noResult['message'] ?></p>
                <img src="assets/img/gif/tumbleweed.gif">
            </div>
        <?php endif; ?>
    </div>

    <?php include "html/footer.php" ?>

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