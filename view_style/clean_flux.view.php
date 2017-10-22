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
        $tab_mode = "cleanF";
        include "html/tabs_flux.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Vidanger un flux</h4>
                        <p class="category">Purger un flux vide les images associées au flux et ses nouvelles.</p>
                    </div>
                    <div class="content">
                        <br>
                        <form action="clean_flux.ctrl.php" method="post">
                            <?php
                            foreach ($data as $d) {
                            ?>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toClean[]' value="<?= $d->id ?>|<?= $d->titre ?>">
                                    <?= $d->titre ?>
                                </label>
                            </div>
                            <?php
                            }
                            ?>
                            <br>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" onClick="checkAll(this)">
                                    Tout cocher
                                </label>
                            </div>
                            </br>
                            <button type="submit" class = "btn btn-warning btn-fill pull-left">
                                <span class="fa fa-trash" style="margin-left: -6px;"></span>
                                Purger
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