<ul class="nav nav-tabs">
    <li <?= $tab_mode=="allfT" ? 'class="active"' : ""?>>
        <a href="afficher_flux.ctrl.php">
        <i class = "fa fa-rss"></i>
        Tous les flux</a>
    </li>
    <li <?= $tab_mode=="picT" ? 'class="active"' : ""?>>
        <a href="afficher_mozaic.ctrl.php">
        <i class = "fa fa-picture-o"></i>
        En images</a>
    </li>
    <li <?= $tab_mode=="dateT" ? 'class="active"' : ""?>>
        <a href="afficher_date.ctrl.php">
        <i class = "fa fa-clock-o"></i>
        Par date</a>
    </li>
</ul>