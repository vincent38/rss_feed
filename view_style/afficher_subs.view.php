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
        $tab_mode = "seeT";
        include "html/tabs_subs.php";
    ?>

    <div class="content">
        <!-- Le contenu va ici ! -->
        <?php if ($data): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Mes abonnements</h4>
                            <p class="category">Cliquez sur une catégorie pour en voir les nouveautés</p>
                        </div>
                        <div class="list-group special-list-2">
                            <?php foreach ($data as $cat => $listeRSS) { ?>
                                <button type="button" class="list-group-item active">
                                    <?= $cat ?>
                                </button>
                                <?php foreach ($data[$cat] as $r) { ?>
                                    <button type="button" class="list-group-item">
                                        <form class = "special-form" name = "aboForm<?= $r->id ?>" action="afficher_subs.ctrl.php" method="POST">
                                            <input type="hidden" name="unsub" value="<?= $r->id ?>">
                                            <span onclick="location.href='<?= $r->urlParsed() ?>';"> <?= $r->titre() ?></span>
                                        </form>
                                        <span name="unsub" class="badge badge-error" onclick ="aboForm<?= $r->id ?>.submit()">Se désabonner</span>
                                    </button>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

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

    <!--  Fichier de gestion des alertes    -->
    <?php include "html/alert.php"; ?>
</html>
