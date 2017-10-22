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
        $tab_mode = "tagT";
        include "html/tabs_filters.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Filtre HTML</h4>
                        <p class="category">Choisissez les balises HTML à autoriser dans le corps des nouvelles</p>
                    </div>
                    <div class="content">
                    <br>
                        <form action="html_filter.ctrl.php" method="post">
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name="toBlock" value="noBlock" onClick="disableAll(this)" id="unblock" <?= $data[0] ? "" : "checked" ?>>
                                    Ne pas bloquer les balises HTML (par défaut)
                                </label>
                            </div>
                            <br>
                            <p class = "text-success"> Recommandé : </p>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toBlock[]' value="typo" <?= (in_array("strong", $data)) ? "checked" : "" ?>
                                     <?= $data[0] ? "" : "disabled" ?>
                                    <b>balises de mise en forme</b> :
                                    <span class = "special-checkbox-text">&nbsp; &#60;b&#62; , &nbsp; &#60;strong&#62;  , &nbsp; &#60;p&#62;  , &nbsp; etc.</span>
                                </label>
                            </div>
                            <br>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toBlock[]' value="img" <?= (in_array("img", $data)) ? "checked" : "" ?>
                                     <?= $data[0] ? "" : "disabled" ?>
                                    <b>img</b> : insertion d'une image
                                </label>
                            </div>
                            <br>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toBlock[]' value="a" <?= (in_array("a", $data)) ? "checked" : "" ?>
                                     <?= $data[0] ? "" : "disabled" ?>
                                    <b>a</b> : insertion d'un lien hypertexte
                                </label>
                            </div>
                            <br>
                            <p class = "text-warning"> Déconseillé : </p>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toBlock[]' value="iframe" <?= (in_array("iframe", $data)) ? "checked" : "" ?>
                                     <?= $data[0] ? "" : "disabled" ?>
                                    <b>iframe</b> : intégration de pages Web
                                </label>
                            </div>
                            <br>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name='toBlock[]' value="script" <?= (in_array("script", $data)) ? "checked" : "" ?>
                                     <?= $data[0] ? "" : "disabled" ?>
                                    <b>script</b> : insertion d'un script
                                </label>
                            </div>
                            </br>
                            <button type="submit" class = "btn btn-info btn-fill pull-left">
                                <span class="fa fa-check-circle-o" style="margin-left: -6px;"></span>
                                Appliquer
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
   
    <!-- Code bonus pour le plugin tags -->
    <link href="assets/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <script src="assets/js/bootstrap-tagsinput.min.js"></script>

    <script language="JavaScript">
        function disableAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i] !== ele) {
                        checkboxes[i].disabled = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox' && checkboxes[i] !== ele) {
                        checkboxes[i].disabled = false;
                    }
                }
            }
        }
    </script>

    <?php include "html/alert.php"; ?>
</html>