<?php include "html/header.php" ?>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "allF";
        include "html/sidebar.php";
    ?>    
    <?php
        // Inclusion des onglets de navigation
        $tab_mode = "picT";
        include "html/tabs_allflux.php";
    ?>
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <?php if (!isset($noResult)): ?>
            <div class="special-title-group">
                <h4 class="title">En images</h4>
                <p>Affiche toutes les nouvelles de vos flux en images</p>
            </div>
        <?php endif; ?>

        <!-- On affiche les boutons de filtrage par flux -->
        <?php if (isset($data['flux'])): ?>
            <form class="special-cat-bar" action="afficher_mozaic.ctrl.php" method="POST">
                <?php foreach($data['flux'] as $rss) { ?>
                    <button name="rssID" type="submit" value="<?= $rss['id'] ?>" 
                        class="btn <?= $rss['icon'] ?> btn-fill" <?= ($data['selectedID']==$rss['id']) ? "disabled" : ""?>>
                        <?= $rss['nom'] ?>
                    </button>
                <?php } ?>
            </form>
        <?php endif; ?>

        <?php if (isset($data['news'])): ?>
            <div class="row special-row">
                <?php foreach($data['news'] as $nouvelle) { ?>
                    <div class="thumbnail col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6">
                        <div class="caption special-caption">
                            <h5><?= $nouvelle->titre() ?></h5>
                            <p><a href="<?= $nouvelle->urlParsed() ?>" class="label label-info">Lire la suite</a></p>
                        </div>
                        <img src="<?= $nouvelle->realImg ?>" alt="illustration">
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php endif; ?>

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
    
    <!-- Code snippet JS pour afficher\cacher la description des nouvelles
          adapté à partir de :  https://bootsnipp.com/snippets/featured/thumbnail-caption-hover-effect -->
    <script type"text/javascript">
        $( document ).ready(function() {
            $("[rel='tooltip']").tooltip();    
        
            $('.thumbnail').hover(
                function(){
                    $(this).find('.caption').fadeIn(250)
                },
                function(){
                    $(this).find('.caption').fadeOut(205)
                }
            );  
        });
    </script>

    <?php include "html/alert.php"; ?>
</html>
