<!-- Script PHP réalisant les alertes souhaitées pour nos différentes pages -->
<?php if (isset($alert)):?>
    <script type="text/javascript">
        $(document).ready(function(){
            $.notify({
                icon: '<?= $alert['icon'] ?>',
                message: '<?= $alert['message'] ?>'
            },{
                type: '<?= $alert['type'] ?>',
                timer: <?= (isset($alert['time'])) ? $alert['time'] : 4000 ?>,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        });
    </script>
<?php endif; ?>