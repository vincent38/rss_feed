<?php include "html/header.php" ?>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "dealF";
        include "html/sidebar.php";
    ?>
    <?php
        // Inclusion des onglets de navigation
        $tab_mode = "diskF";
        include "html/tabs_flux.php";
    ?>    
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <?php if ($data): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Gérer l'espace disque</h4>
                            <p class="category">Permet de consulter la quantité d'espace occupée par chaque flux</p>
                        </div>
                        <div class="content">

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <canvas id="chartjs-4" class="chartjs" width="435" height="217" style="display: block; width: 435px; height: 217px;"></canvas>

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

    <!-- Inclusion de chart JS -->
	<script src="assets/js/chart.min.js" type="text/javascript"></script>

    <!-- Script de dessin du graphique -->
    <script type="text/javascript">
        new Chart(document.getElementById("chartjs-4"),
            {"type":"doughnut",
            "data":{
                "labels":["Red","Blue","Yellow"],
                "datasets":[
            {"label":"My First Dataset","data":[300,50,100],
            "backgroundColor":["rgb(255, 99, 132)", "rgb(54, 162, 235)", "rgb(255, 205, 86)"]}]}});
    </script> 

    <?php include "html/alert.php"; ?>
</html>