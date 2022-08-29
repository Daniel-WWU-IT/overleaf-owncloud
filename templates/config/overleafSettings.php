<?php
print_unescaped($this->inc('template', ['scope' => 'config', 'file' => 'overleafSettings']));
?>

<script id="content-tpl" type="text/x-handlebars-template">
    <div class="content-page">
        <div class="content-header">
            <h2>Overleaf settings</h2>
        </div>

        <form id="settings-form">
            <div id="main-settings-section" style="grid-row: 1;">
                <div class="section-header">
                    <h3>Main</h3>
                </div>
                <div>Configure the main Overleaf settings.</div>
                <div>&nbsp;</div>

                <div class="settings-table settings-table-main">
                    <label for="overleaf-url" style="grid-row: 1;">Overleaf URL:</label>
                    <input id="overleaf-url" type="text" style="width: 400px;" placeholder="https://www.myoverleaf.com" style="grid-row: 1;" value="<?php p($_['config']['overleaf_url'])?>"/>
                    <div><em>Enter the URL of your Overleaf instance.</em></div>

                    <label for="api-key" style="grid-row: 2;">API Key:</label>
                    <input id="api-key" type="text" style="width: 400px;" placeholder="secret-key-1234" style="grid-row: 2;" value="<?php p($_['config']['api_key'])?>"/>
                    <div><em>Enter the key used to authenticate against the Overleaf API.</em></div>
                </div>
            </div>

            <div id="userid-settings-section" style="grid-row: 2;">
                <div class="section-header">
                    <h3>User IDs</h3>
                </div>
                <div>Configure how the Overleaf user IDs, which must be in a valid email address format, are generated.</div>
                <div>&nbsp;</div>

                <div class="settings-table settings-table-userid">
                    <label for="userid-suffix" style="grid-row: 1;">Suffix:</label>
                    <input id="userid-suffix" type="text" style="width: 400px;" placeholder="myoverleaf.com" style="grid-row: 1;" value="<?php p($_['config']['userid_suffix'])?>"/>
                    <div><em>Overleaf user IDs will be generated in the form of <i>owncloud-id@suffix</i>. It should thus be in the form of <i>host.tld</i>, like <i>myoverleaf.com</i>.</em></div>

                    <span style="grid-row: 2; grid-column: 2;">
                        <input id="userid-suffix-enforce" type="checkbox" <?php p($_['config']['userid_suffix_enforce'] ? 'checked' : ''); ?>/>
                        <label for="userid-suffix-enforce">Enforce suffix</label>
                    </span>
                    <div style="grid-column: 3;"><em>If enabled, ownCloud user IDs which already are an email address will nonetheless use the specified suffix.</em></div>
                </div>
            </div>

            <div style="grid-row: 3;">&nbsp;</div>
            <div style="grid-row: 4;">
                <button id="settings-save">Save settings</button>
            </div>
        </form>
    </div>
</script>
