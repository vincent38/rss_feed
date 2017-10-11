<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ajouter un nouveau flux</title>
    </head>
    <body>
        <h1>Ajouter un flux</h1>
        <?php if (isset($alert)) { 
            echo $alert['message'];
        } ?>
        <form action="add_flux.ctrl.php" method="post">
            <fieldset>
                <label for="url">URL du flux : <input type="text" name="url" id="url"></label><br>
                <label for="titre">Titre du flux : <input type="text" name="titre" id="titre"></label><br>
                <input type="submit" value="Ajouter">
            </fieldset>
        </form>
    </body>
</html>