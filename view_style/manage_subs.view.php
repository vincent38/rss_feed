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
        $tab_mode = "subT";
        include "html/tabs_subs.php";
    ?>

    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">S'abonner</h4>
                        <p class="category">Vous pouvez vous abonner à des flux RSS, les étiqueter à une catégorie (existante ou non) et les renommer.</p>
                    </div>
                    <div class="content">
                        <form action="manage_subs.ctrl.php" method="post">
                            <label for="flux">Flux à suivre :
                            <select name="flux" id="flux">
                                <?php
                                    foreach($data as $d) {
                                        echo "<option value='".$d->id."'>".$d->titre;
                                    }
                                ?>
                            </select>
                            </label><br>
                            <div class = "col-md-6">
                                <div class="form-group">
                                    <label>Titre de l'abonnement : </label>
                                    <input type="text" name="titre" class="form-control">
                                </div>
                            </div>
                            <div class = "col-md-6">
                                <div class="form-group">
                                    <label>Catégorie : </label>
                                    <input type="text" name="cat" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class = "btn btn-info btn-fill pull-left">
                                <span class="fa fa-magnet" style="margin-left: -6px;"></span>
                                S'abonner
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

    <script language="JavaScript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>

    <?php include "html/alert.php"; ?>
</html>