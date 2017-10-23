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
        $tab_mode = "upF";
        include "html/tabs_flux.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->        
        <?php if (isset($noResult)): ?>
            <div class="special-no-result">                
                <h4 class="title"><?= $noResult['type'] ?></h4>
                <p class="category"><?= $noResult['message'] ?></p>
                <img src="assets/img/gif/tumbleweed.gif">
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Mettre à jour un flux</h4>
                            <p class="category">Choisissez les flux à mettre à jour</p>
                        </div>
                        <div class="content">
                            <br>
                            <form action="force_update.ctrl.php" method="post">
                                <?php
                                foreach ($data as $d) {
                                ?>
                                <div class="form-check">
                                    <label class="form-check-label special-radio">
                                        <input class="form-check-input" type="checkbox" name='toUpdate[]' value="<?= $d->id ?>|<?= $d->titre ?>">
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
                                <button type="submit" class = "btn btn-warning btn-fill pull-left" onclick="showLoading(this)">
                                    <span class="fa fa-refresh" style="margin-left: -6px;"></span>
                                    Mettre à jour
                                </button>
                                <img src="assets/img/gif/loading.svg" class="special-loading" alt="chargement" id="loading_ico" hidden>
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
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

    <!-- Cochage automatique des checkbox et icône de chargement -->
    <script language="JavaScript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = ele.checked;
                }
            }
        }

        function showLoading(element) {
            element.style.display = 'none';
            document.getElementById('loading_ico').style.display = 'block';
        }
    </script>

    <?php include "html/alert.php"; ?>
</html>