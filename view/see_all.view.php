<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Mes flux</title>
    </head>
    <body>
        <h1>Flux présents en BDD</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de dernière MàJ</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data as $d) {
                echo "<tr>\n";
                echo "<td>".$d->titre."</td>\n";
                echo "<td>".$d->date."</td>\n";
                echo "</tr>\n";
            }
            ?>
            </tbody>
        </table>
    </body>
</html>