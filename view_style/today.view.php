<?php include "html/header.php" ?>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "todayF";
        include "html/sidebar.php";
    ?>    

    <div class="content">
    <!-- Le contenu va ici ! -->
        <?php if ($data) { $i = 0; ?>
            <div class="card col-lg-12">
                <div class="header special-wordlist-title">
                    <h4 class="title">Aujourd'hui</h4>
                    <p class="category">Les mots de l'actualité</p>
                </div>

                <div class = "special-wordlist">
                    <?php foreach ($data as $mot) {
                        if (!($i%3)) {
                            $lineH = $mot['taille']+5;
                        }
                    ?>
                        <div class="col-lg-4">
                            <p style="font-size:<?= $mot['taille'] ?>px; 
                            color:#<?= $mot['coul'] ?>;
                            line-height:<?= $lineH ?>px">
                                <?= $mot['txt'] ?>
                            </p>
                        </div>
                    <?php $i++; } ?>
                </div>
            </div>
        <?php } ?>

        <!-- On affiche les éventuels messages d'erreur -->
        <?php if (isset($noResult)): ?>
            <div class="special-no-result">                
                <h4 class="title"><?= $noResult['type'] ?></h4>
                <p class="category"><?= $noResult['message'] ?></p>
                <img src="../view_style/assets/img/gif/tumbleweed.gif">
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

    <!-- Script écrit pour dessiner les mots reçus depuis la vue -->
    <?php if ($data): ?>
    <script type="text/javascript">


    </script>
    <?php endif; ?>

    <?php include "html/alert.php"; ?>
</html>