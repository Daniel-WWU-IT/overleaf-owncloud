<?php
print_unescaped($this->inc('template', ['scope' => 'launcher', 'file' => 'launcher']));
?>

<script id="content-tpl" type="text/x-handlebars-template">
    <div class="content-page">
        <iframe id="overleaf-iframe" src="<?php p($_['overleaf_url'])?>" title="Overleaf" width="100%" height="100%"></iframe>
    </div>
</script>
