<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Afficher Nouvelles</title>
</head>
<body>
<?php 
foreach($data as $nouvelle) {
    echo ' <a href="'.$nouvelle->urlParsed.'">'.$nouvelle->titre().'</a> '.$nouvelle->date()."<br>\n";
    echo '<img src="'.$nouvelle->urlimage().'" alt="image"><br><br>'."\n";
    echo '  '.$nouvelle->description()."<br><br>\n";
}
?>
</body>
</html>