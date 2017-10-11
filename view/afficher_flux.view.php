<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Affichage des flux</title>
</head>
<body>
    <h1>Mes flux</h1>
    <?php foreach ($data as $r) { ?>
        <a href = "<?= $r->urlParsed ?>">
            <p><?= $r->titre ?> - Ajouté le : <?= $r->date ?> </p>
        </a>
    <?php } ?>
</body>
</html>