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
        <!-- On affiche les éventuels messages d'erreur -->
        <?php if (isset($noResult)): ?>
            <div class="special-no-result">                
                <h4 class="title"><?= $noResult['type'] ?></h4>
                <p class="category"><?= $noResult['message'] ?></p>
                <img src="../view_style/assets/img/gif/tumbleweed.gif">
            </div>
        <?php else: ?>
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
                                <h5>Supprimer les nouvelles vieilles de plus de :</h5>                            
                                <label class = "special-radio">
                                    <input type="radio" name='time' value="up1">
                                    24h
                                </label>                            
                                <label class = "special-radio">
                                    <input type="radio" name='time'  value="up2">
                                    deux jours
                                </label>                            
                                <label class = "special-radio">
                                    <input type="radio" name='time' value="up14">
                                    deux semaines
                                </label>                           
                                <label class = "special-radio">
                                    <input type="radio" name='time'  value="upAll" checked>
                                    tout supprimer
                                </label> 
                                <br><br><br>
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

    <script language="JavaScript">
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = ele.checked;
                }
            }
        }
    </script>

    <?php include "html/alert.php"; ?>
</html>