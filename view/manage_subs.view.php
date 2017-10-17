<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Mes abonnements</title>
    </head>
    <body>
        Ajouter un abonnement
        <form action="manage_subs.ctrl.php" method="post">
            <fieldset>
                <label for="flux">Flux à suivre : 
                    <select name="flux" id="flux">
                        <?php
                            foreach($data as $d) {
                                echo "<option value='".$d->id."'>".$d->titre;
                            }
                        ?>
                    </select>
                </label><br>
                <label for="titre">Titre de l'abonnement : <input type="text" name="titre" id="titre"></label><br>
                <label for="cat">Catégorie : <input type="text" name="cat" id="cat"></label><br>
                <input type="submit" value="S'abonner">
            </fieldset>
        </form>
    </body>
</html>