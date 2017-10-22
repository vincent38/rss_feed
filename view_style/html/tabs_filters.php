<ul class="nav nav-tabs">
    <li <?= $tab_mode=="keyT" ? 'class="active"' : ""?>>
        <a href="word_filter.ctrl.php">
        <i class = "fa fa-key"></i>
        Par mots clés</a>
    </li>
    <li <?= $tab_mode=="tagT" ? 'class="active"' : ""?>>
        <a href="html_filter.ctrl.php">
        <i class = "fa fa-code"></i>
        Filtre HTML</a>
    </li>
</ul>