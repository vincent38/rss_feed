<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Mettre à jour les flux</title>
    </head>
    <body>
        <h1>Choisissez les flux à mettre à jour</h1>
        <?php
        if (isset($alert)) {
            echo "<p>".$alert['message']."</p>";
        }
        ?>
        <form action="force_update.ctrl.php" method="post">
            <fieldset>
            <input id="all" type="checkbox" onClick="checkAll(this)" />
            <label for="all">Tout cocher</label><br/><br>
            <?php
            foreach ($data as $d) {
                ?>
                <input type="checkbox" name='toUpdate[]' value="<?php echo $d->url?>" id="<?php echo $d->id?>">
                <label for="<?php echo $d->id?>"><?php echo $d->titre?></label><br>
                <?php
            }
            ?>
            <br>
            <input type="submit" value="Mettre à jour">
            </fieldset>
        </form>
        <script language="JavaScript">
        /*
            Script check all / uncheck all fourni par stackoverflow
            https://stackoverflow.com/questions/19282219/check-uncheck-all-the-checkboxes-in-a-table
        */
        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    console.log(i)
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
        </script>
    </body>
</html>