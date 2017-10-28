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
                            <h4 class="title">Stockage des données</h4>
                            <p class="category">Permet de visionner l'espace disque occupé par chaque flux</p>
                        </div>
                        <div class="content">
                        <canvas id="stats_flux" class="chartjs special-chart" width="435" height="217" style="display: block; width: 435px; height: 217px;"></canvas>
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

    <!-- Inclusion de chart JS -->
	<script src="assets/js/chart.min.js" type="text/javascript"></script>

    <!-- Script de dessin du graphique -->
    <?php if($data): ?>
        <script type="text/javascript">
            new Chart(document.getElementById("stats_flux"),
                {type:"doughnut",
                data: {
                    labels: [<?= $data['labels'] ?>],
                    datasets: [
                    {
                        label: "",
                        data: [<?= $data['stats'] ?>],
                        backgroundColor: [<?= $data['colors'] ?>]
                    }]},
                options: {
                    title: {
                        display: true,
                        fontSize: 20,
                        fontFamily: "'Roboto', 'Helvetica Neue', 'Arial'",
                        text: 'Taille occupée par les flux RSS en Mo',
                        position: 'top',
                        padding: 15
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    responsive: true
                }
                });
        </script>
    <?php endif; ?>

    <?php include "html/alert.php"; ?>
</html>