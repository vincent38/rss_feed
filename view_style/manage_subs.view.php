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
        $mode = "myAbo";
        include "html/sidebar.php";
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
                            <button type="submit" class = "btn btn-info btn-fill pull-left">S'abonner</button>
                            <div class="clearfix"></div>
                        </form>
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