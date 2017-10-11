<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Mettre à jour les flux</title>
    </head>
    <body>
        <h1>Choisissez les flux à purger</h1>
        <form action="clean_flux.ctrl.php" method="post">
            <fieldset>
            <input type="checkbox" onClick="checkAll(this)" /> Tout cocher<br/><br>
            <?php
            foreach ($data as $d) {
                ?>
                <input type="checkbox" name="<?php echo $d->id?>" value="<?php echo $d->url?>">
                <label for="<?php echo $d->id?>"><?php echo $d->titre?></label><br>
                <?php
            }
            ?>
            <br>
            <input type="submit" value="Purger">
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