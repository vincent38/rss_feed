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
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <?php
        // Inclusion de la sidebar pour éviter la répétition du code
        $mode = "search";
        include "html/sidebar.php";
    ?>    

    <div class="content">
    <!-- Le contenu va ici ! -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title">Rechercher parmi les flux</h4>
                        <p class="category">Effectue une recherche parmi les flux enregistrés dans la base de données.</p>
                    </div>
                    <div class="content">
                        <form action="search.ctrl.php" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" name = "searchstr" placeholder="Search">
                                <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="pe-7s-search"></i>
                                </button>
                                </div>
                            </div>                    
                            <br><br>
                            <div>Rechercher les résultats qui...</div>              
                            <label for="anyT">
                                <input type="radio" name='typeS' value="anyT" checked>
                                Contiennent n'importe quel terme
                            </label>
                            <label for="allT">
                                <input type="radio" name='typeS' id = 'allT' value="allT">
                                Contiennent tous les termes
                            </label>  
                            <br><br>

                            <div>Rechercher les résultats dans...</div>                             
                            <label for="all">
                                <input type="radio" name='modeS' value="all" checked>
                                Titre et corps des contenus
                            </label>                            
                            <label for="t_only">
                                Titre des contenus uniquement
                                <input type="radio" name='modeS'  value="t_only">
                            </label>
                            <br><br>

                            <div>Date des nouvelles</div>                             
                            <label for="up0">
                                <input type="radio" name='time' value="up0" checked>
                                Peu importe
                            </label>                            
                            <label for="up24">
                                <input type="radio" name='time'  value="up24">
                                Les dernières 24 heures
                            </label>                            
                            <label for="up7">
                                <input type="radio" name='time' value="up7">
                                La dernière semaine
                            </label>                           
                            <label for="up30">
                                <input type="radio" name='time'  value="up30">
                                Le dernier mois
                            </label>
                        </form>
                    </div>
                </div>
                <?php if($results): // S'il y a eu des résultats à la recherche ?>
                    <h1>Résultats de la recherche :</h1>
                    <?php foreach($data as $nouvelle) { ?>
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?= $nouvelle->titre() ?></h4>
                                <p class="category"><i class="fa fa-clock-o"></i>  <?= $nouvelle->date() ?></p>
                            </div>
                            <div class="content">
                                <?php if ($nouvelle->urlimage()): ?>
                                    <img src="<?=$nouvelle->urlimage() ?>" alt="image"><br><br>
                                <?php endif; ?>
                                <?=  $nouvelle->description() ?>    
                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-arrow-right"></i> 
                                        <a href="<?= $nouvelle->urlParsed ?>">Lire la nouvelle</a>
                                    </div>
                                </div>     
                            </div>
                        </div>
                    <?php } ?>
                <?php endif;?>
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

    <?php if (isset($alert)):?> 
        <script type="text/javascript">
            $(document).ready(function(){
                $.notify({
                    icon: '<?= $alert['icon'] ?>',
                    message: '<?= $alert['message'] ?>'
                },{
                    type: '<?= $alert['type'] ?>',
                    timer: 4000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });
            });
        </script>
    <?php endif; ?>
</html>