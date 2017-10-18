<?php if (isset($alert)):?> <!-- Script PHP réalisant les alertes souhaitées pour nos différentes pages -->
    <script type="text/javascript">
        $(document).ready(function(){
            $.notify({
                icon: '<?= $alert['icon'] ?>',
                message: '<?= $alert['message'] ?>'
            },{
                type: '<?= $alert['type'] ?>',
                timer: 4000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        });
    </script>
<?php endif; ?>