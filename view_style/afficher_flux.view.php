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
        <?php if (!isset($noResult)): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Afficher tous les flux</h4>
                            <p class="category">Liste de tous les flux enregistrés dans notre base de données. Cliquez sur un flux pour en consulter le contenu.</p>
                        </div>
                        <div class="content">
                            <ul class="list-group special-list-container">
                                <?php foreach ($data as $r) { ?>
                    <li class="list-group-item"><a href = "<?= $r->urlParsed() ?>"><?= $r->titre ?></a><span class="badge"><?= $r->date ?></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- On affiche les éventuels messages d'erreur -->
            <div class="special-no-result">                
                <h4 class="title"><?= $noResult['type'] ?></h4>
                <p class="category"><?= $noResult['message'] ?></p>
                <img src="../view_style/assets/img/gif/tumbleweed.gif">
            </div>
        <?php endif; ?>
    </div>

    <?php include "html/footer.php" ?>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="../view_style/assets/js/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="../view_style/assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="../view_style/assets/js/bootstrap-checkbox-radio-switch.js"></script>

    <!--  Notifications Plugin    -->
    <script src="../view_style/assets/js/bootstrap-notify.js"></script>
    
    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="../view_style/assets/js/light-bootstrap-dashboard.js"></script>

    <?php include "html/alert.php"; ?>
</html>
