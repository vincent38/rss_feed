<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Afficher Nouvelles</title>
    <style>
        img {
            width : 644px;
            height : 322px;
        }
    </style>
</head>
<body>
<h1>Flux en images :</h1>
<?php 
foreach($data as $nouvelle) {
    echo '<a href="'.$nouvelle[1].'">';
    echo '<img src="'.$nouvelle[0].'" alt="image">';
    echo '</a>';
}
?>
</body>
</html>