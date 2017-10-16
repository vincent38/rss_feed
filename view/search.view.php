<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Rechercher parmi les flux</title>
    </head>
    <body>
        <h1>Recherche</h1>
        <?php if (isset($alert)) { 
            echo $alert['message'];
        } ?>
        <form action="search.ctrl.php" method="post">
            <fieldset>
                <label for="searchstr">Mots clés : <input type="text" name="searchstr" id="searchstr"></label>
                <br><br>

                <div>Rechercher les résultats qui...</div>              
                <label for="anyT">
                    Contiennent n'importe quel terme
                    <input type="radio" name='typeS' value="anyT" checked>
                </label>
                <label for="allT">
                    Contiennent tous les termes
                    <input type="radio" name='typeS' id = 'allT' value="allT">
                </label>  
                <br><br>

                <div>Rechercher les résultats dans...</div>                             
                <label for="all">
                    Titre et corps des contenus
                    <input type="radio" name='modeS' value="all" checked>
                </label>                            
                <label for="t_only">
                    Titre des contenus uniquement
                    <input type="radio" name='modeS'  value="t_only">
                </label>
                <br><br>

                <div>Date des nouvelles</div>                             
                <label for="up0">
                    Peu importe
                    <input type="radio" name='time' value="up0" checked>
                </label>                            
                <label for="up24">
                    Les dernières 24 heures
                    <input type="radio" name='time'  value="up24">
                </label>                            
                <label for="up7">
                    La dernière semaine
                    <input type="radio" name='time' value="up7">
                </label>                           
                <label for="up30">
                    Le dernier mois
                    <input type="radio" name='time'  value="up30">
                </label>
                <br><br>
                <input type="submit" value="Rechercher">
            </fieldset>
            <?php if($results): // S'il y a eu des résultats à la recherche ?>
                <h1>Résultats de la recherche :</h1>
                <?php 
                foreach($data as $nouvelle) {
                    echo ' <a href="'.$nouvelle->urlParsed.'">'.$nouvelle->titre().'</a> '.$nouvelle->date()."<br>\n";
                    echo '<img src="'.$nouvelle->urlimage().'" alt="image"><br><br>'."\n";
                    echo '  '.$nouvelle->description()."<br><br>\n";
                }
                ?>
            <?php endif;?>
        </form>
    </body>
</html>