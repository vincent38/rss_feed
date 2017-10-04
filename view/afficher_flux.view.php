<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Affichage des flux</title>
</head>
<body>
    <?php foreach ($data as $r) { ?>
        <a href = "<?= $r->url ?>">
            <p><?= $r->titre ?> </p>            
            <p><?= $r->date ?> </p>
        </a>
    <?php } ?>
</body>
</html>