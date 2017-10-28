<?php include "html/header.php" ?>
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
                                <input type="text" class="form-control" name = "searchstr" placeholder="Search" value = "<?= $data_opt['str'] ?? ""?>">
                                <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="pe-7s-search"></i>
                                </button>
                                </div>
                            </div>                    
                            <br>
                            <h5>Rechercher les résultats qui...</h5>              
                            <label for="anyT" class = "special-radio">
                                <input type="radio" name='typeS' value="anyT"
                                <?= isset($data_opt['strict']) ? ($data_opt['strict'] ? "" : "checked") : "checked" ?>>
                                Contiennent n'importe quel terme
                            </label>
                            <label for="allT" class = "special-radio">
                                <input type="radio" name='typeS' id = 'allT' value="allT"
                                <?= isset($data_opt['strict']) ? ($data_opt['strict'] ? "checked" : "") : "" ?>>
                                Contiennent tous les termes
                            </label>  
                            <br><br>

                            <h5>Rechercher les résultats dans...</h5>                   
                            <label for="all" class = "special-radio">
                                <input type="radio" name='modeS' value="all"
                                <?= isset($data_opt['onlyT']) ? ($data_opt['onlyT'] ? "" : "checked") : "checked" ?>>
                                Titre et corps des contenus
                            </label>                            
                            <label for="t_only" class = "special-radio">
                                <input type="radio" name='modeS'  value="t_only"
                                <?= isset($data_opt['onlyT']) ? ($data_opt['onlyT'] ? "checked" : "") : "" ?>>
                                Titre des contenus uniquement
                            </label>
                            <br><br>

                            <h5>Date des nouvelles</h5>                             
                            <label for="up0" class = "special-radio">
                                <input type="radio" name='time' value="up0"
                                <?= isset($data_opt['time']) ? ($data_opt['time']=="up0" ? "checked" : "") : "checked" ?>>
                                Peu importe
                            </label>                            
                            <label for="up24" class = "special-radio">
                                <input type="radio" name='time'  value="up24"
                                <?= isset($data_opt['time']) ? ($data_opt['time']=="up24" ? "checked" : "") : "" ?>>
                                Les dernières 24 heures
                            </label>                            
                            <label for="up7" class = "special-radio">
                                <input type="radio" name='time' value="up7"
                                <?= isset($data_opt['time']) ? ($data_opt['time']=="up7" ? "checked" : "") : "" ?>>
                                La dernière semaine
                            </label>                           
                            <label for="up30" class = "special-radio">
                                <input type="radio" name='time'  value="up30"
                                <?= isset($data_opt['time']) ? ($data_opt['time']=="up30" ? "checked" : "") : "" ?>>
                                Le dernier mois
                            </label> 
                            <br><br><br>
                            <div class="form-check">
                                <label class="form-check-label special-radio">
                                    <input class="form-check-input" type="checkbox" name="highlight" value="highlight"
                                    <?= isset($data_opt['highlight']) ? ($data_opt['highlight'] ? "checked" : "") : "" ?>>
                                    Surligner les occurences dans les résultats
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if($results): // S'il y a eu des résultats à la recherche ?>
                    <h4>Résultats de la recherche</h4>
                    <?php foreach($data as $nouvelle) { ?>
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><?= $nouvelle->titre() ?></h4>
                                <p class="category"><i class="fa fa-clock-o"></i>  <?= $nouvelle->date() ?></p>
                            </div>
                            <div class="content">
                                <?php if ($nouvelle->urlimage()): ?>
                                    <img src="<?=$nouvelle->urlimage() ?>" class="img-thumbnail" alt="image"><br><br>
                                <?php endif; ?>
                                <?=  $nouvelle->description() ?>    
                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-newspaper-o"></i>
                                        <?= $nouvelle->titreFlux ?>
                                        &nbsp;
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i> 
                                        <a href="<?= $nouvelle->urlParsed() ?>">Lire la nouvelle</a>
                                    </div>
                                </div>     
                            </div>
                        </div>
                    <?php } ?>
                <?php endif;?>
            </div>
        </div>
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

    <?php include "html/alert.php"; ?>
</html>