<ul class="nav nav-tabs">
    <li <?= $tab_mode=="subT" ? 'class="active"' : ""?>>
        <a href="manage_subs.ctrl.php">
        <i class = "fa fa-magnet"></i>
        S'abonner</a>
    </li>
    <li <?= $tab_mode=="seeT" ? 'class="active"' : ""?>>
        <a href="afficher_subs.ctrl.php">
        <i class = "fa fa-rss"></i>
        Mes abonnements</a>
    </li>
    <li <?= $tab_mode=="picT" ? 'class="active"' : ""?>>
        <a href="#">
        <i class = "fa fa-picture-o"></i>
        En image</a>
    </li>
</ul>