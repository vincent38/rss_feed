<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Inscription</title>
    </head>
    <body>
        <?php if (isset($error)) { 
            echo $error;
        }?>
            <form action="signin.ctrl.php" method="post">
            <fieldset>
                <label for="username">Nom d'utilisateur &emsp;<input type="text" id="username" name="username"></label><br>
                <label for="password">Mot de passe &emsp;&emsp;&emsp;<input type="password" id="password" name="password"></label><br>
                <input type="submit" value="Connexion">
            </fieldset>
        </form>
    </body>
</html>