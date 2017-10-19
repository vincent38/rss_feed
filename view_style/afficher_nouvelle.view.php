<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>RSSFeed</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/light-bootstrap-dashboard.css" rel="stylesheet"/>
    <link href="assets/css/bonus.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "allF";
        include "html/sidebar.php";
    ?>    
    
    <div class="content">
    <!-- Le contenu va ici ! -->
        <h5 class="title special-h5">
            <a href = "afficher_flux.ctrl.php">Tous les flux</a> <  
            <a href = "afficher_nouvelles.ctrl.php?rssID=<?= $data->RSS_id(); ?>"><?=$data->RSStitre?></a>
            < <a href = "#"><?= $data->new_titre ?></a>
        </h5>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><?= $data->titre() ?></h4>
                        <p class="category"><i class="fa fa-clock-o"></i>  <?= $data->date() ?></p>
                    </div>
                    <div class="content">
                        <?php if ($data->urlimage()): ?>
                            <img src="<?=$data->urlimage() ?>" alt="image"><br><br>
                        <?php endif; ?>
                        <?=  $data->description() ?>    
                        <div class="footer">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-arrow-right"></i> 
                                <a href="<?= $data->url() ?>">Voir sur le site source</a>
                            </div>
                        </div>     
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

    <?php include "html/alert.php"; ?>
</html>