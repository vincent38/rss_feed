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
            <a href = "afficher_nouvelles.ctrl.php?rssID=<?= $data->RSS_id(); ?>"><?=$data->RSStitre?></a>
            < <a href = "#"><?= $data->new_titre ?></a>
        </h5>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><?= $data->titre() ?></h4>
                        <p class="category"><i class="fa fa-clock-o"></i>  <?= $data->date() ?></p>
                    </div>
                    <div class="content">
                        <?php if ($data->urlimage()): ?>
                            <img src="<?=$data->urlimage() ?>" alt="image"><br><br>
                        <?php endif; ?>
                        <?=  $data->description() ?>    
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-arrow-right"></i> 
                                <a href="<?= $data->url() ?>">Voir sur le site source</a>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>
        </div>
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