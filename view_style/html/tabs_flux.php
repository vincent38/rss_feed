<ul class="nav nav-tabs">
    <li <?= $tab_mode=="dealF" ? 'class="active"' : ""?>>
        <a href="add_flux.ctrl.php">
        Ajouter un flux</a>
    </li>
    <li <?= $tab_mode=="upF" ? 'class="active"' : ""?>>
        <a href="force_update.ctrl.php">
        Mettre à jour un flux</a>
    </li>
    <li <?= $tab_mode=="cleanF" ? 'class="active"' : ""?>>
        <a href="clean_flux.ctrl.php">
        Vidanger un flux</a>
    </li>
    <li <?= $tab_mode=="deleteF" ? 'class="active"' : ""?>>
        <a href="delete_flux.ctrl.php">
        Supprimer un flux</a>
    </li>
</ul>