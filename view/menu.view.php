<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Backoffice</title>
    </head>
    <body>
        <h1>Bienvenue sur le backoffice, <?php echo $_SESSION["user"]; ?></h1>
        <p>Dernière MàJ : 16/10/2017 - V0.3</p>
        <br>
        <a href="afficher_flux.ctrl.php">Voir tous les flux</a><br>
        <a href="add_flux.ctrl.php">Ajouter un flux</a><br>
        <a href="force_update.ctrl.php">Mettre à jour un flux</a><br>
        <a href="clean_flux.ctrl.php">Vidanger un flux</a><br>
        <a href="delete_flux.ctrl.php">Supprimer un flux</a><br>
    </body>
</html>