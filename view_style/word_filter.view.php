<?php include "html/header.php" ?>
<body>
<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "filterF";
        include "html/sidebar.php";
    ?>
    <?php
        // Inclusion des onglets de navigation
        $tab_mode = "keyT";
        include "html/tabs_filters.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Filtrer par mots clés</h4>
                        <p class="category">Filtre le contenu de vos flux et nouvelles par mots clés</p>
                    </div>
                    <div class="content">
                    <br>
                    <p class="text-muted">Les filtres choisis seront appliqués uniquement sur les pages visionnées depuis "Mes abonnements".</p>
                    <p class="text-muted">Séparez les mots-clés par un point-virgule.</p>
                    <br>
                        <form action="word_filter.ctrl.php" method="post">
                            <div class = "row col-lg-6">
                                <div class="alert alert-info alert-with-icon" data-notify="container">
                                    <span data-notify="icon" class = "pe-7s-info"></span>
                                    <span data-notify="message">Information : <b><?= $data['stats'] ?></b> articles de la base de données sont bloqués par vos filtres.</span>
                                </div>
                            </div>
                            <div class = "row">
                                <div class = "col-lg-12">
                                    <label>Bloquer toutes les nouvelles contenant :</label>
                                    <div class="form-group">
                                        <input type="text" name="filter_chain" value="<?= $data['chain'] ?>" data-role="tagsinput" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class = "btn btn-info btn-fill pull-left">
                                <span class="fa fa-floppy-o" style="margin-left: -6px;"></span>
                                Enregistrer
                            </button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
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
   
    <!-- Code bonus pour le plugin tags -->
    <link href="assets/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <script src="assets/js/bootstrap-tagsinput.min.js"></script>

    <?php include "html/alert.php"; ?>
</html>