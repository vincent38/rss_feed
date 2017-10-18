<ul class="nav nav-tabs">
    <li <?= $tab_mode=="subT" ? 'class="active"' : ""?>>
        <a href="manage_subs.ctrl.php">S'abonner</a>
    </li>
    <li <?= $tab_mode=="seeT" ? 'class="active"' : ""?>>
        <a href="#">Voir mes flux</a>
    </li>
    <li <?= $tab_mode=="picT" ? 'class="active"' : ""?>>
        <a href="#">En image</a>
    </li>
</ul>