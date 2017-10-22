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
        $tab_mode = "dealF";
        include "html/tabs_flux.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Ajouter un flux</h4>
                        <p class="category">Ajoute un flux RSS à la base de données via son URL</p>
                    </div>
                    <div class="content">
                        <form action="add_flux.ctrl.php" method="post">
                            <div class = "row">
                                <div class = "col-md-2">
                                    <div class="form-group">
                                        <label>Titre du flux</label>
                                        <input type="text" name="titre" id="titre" class="form-control">
                                    </div>
                                </div>
                                <div class = "col-md-6">
                                    <div class="form-group">
                                        <label>URL du flux</label>
                                        <input type="text" name="url" id="url" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class = "btn btn-success btn-fill pull-left">
                                <span class="fa fa-plus" style="margin-left: -6px;"></span>
                                Ajouter
                            </button>
                            <div class="clearfix"></div>
                        </form>
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