<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nouvelle</title>
</head>
<body>
    <?php
    if ($data !== null) {
        echo ' <a href="'.$data->url().'">'.$data->titre().'</a> '.$data->date()."<br>\n";
        echo '<img src="'.$data->urlimage().'" alt="image"><br><br>'."\n";
        echo '  '.$data->description()."<br><br>\n";
    }
    ?>
</body>
</html>