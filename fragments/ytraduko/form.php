<?php /** @var rex_fragment $this */ ?>
<form action="<?= $this->context->getUrl() ?>" method="post">
    <section class="rex-page-section">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <colgroup>
                        <col class="col-key" />
                        <col class="col-de" />
                        <?php if ('en_gb' !== $this->language): ?>
                            <col class="col-en" />
                        <?php endif ?>
                        <col width="*" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th><?= $this->i18n('ytraduko_key') ?></th>
                            <th>de_de</th>
                            <?php if ('en_gb' !== $this->language): ?>
                                <th>en_gb</th>
                            <?php endif ?>
                            <th><?= $this->escape($this->language) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $english = 'en_gb' === $this->language ? null : $this->package->getFile('en_gb') ?>
                        <?php $file = $this->package->getFile($this->language) ?>
                        <?php foreach ($this->package->getSource() as $key => $value): ?>
                            <tr>
                                <td><code><?= $this->escape($key) ?></code></td>
                                <td><?= $this->escape($value) ?></td>
                                <?php if ($english): ?>
                                    <td><?= isset($english[$key]) ? $this->escape($english[$key]) : '' ?></td>
                                <?php endif ?>
                                <td<?= isset($file[$key]) ? '' : ' class="has-error"' ?>>
                                    <input type="text" class="form-control"
                                        name="ytraduko[<?= $this->escape($this->package->getName()) ?>][<?= $this->escape(rawurlencode($key)) ?>]"
                                        value="<?= isset($file[$key]) ? $this->escape($file[$key]) : '' ?>"
                                    />
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <?php if ($this->package instanceof rex_ytraduko_addon): ?>
                            <?php foreach ($this->package->getPlugins() as $plugin): ?>
                                <tr>
                                    <th colspan="<?= 'en_gb' === $this->language ? 3 : 4 ?>"><?= $this->escape($plugin->getName()) ?></th>
                                </tr>
                                <?php $english = 'en_gb' === $this->language ? null : $plugin->getFile('en_gb') ?>
                                <?php $file = $plugin->getFile($this->language) ?>
                                <?php foreach ($plugin->getSource() as $key => $value): ?>
                                    <tr>
                                        <td><div><code><?= $this->escape($key) ?></code></div></td>
                                        <td><?= $this->escape($value) ?></td>
                                        <?php if ($english): ?>
                                            <td><?= isset($english[$key]) ? $this->escape($english[$key]) : '' ?></td>
                                        <?php endif ?>
                                        <td<?= isset($file[$key]) ? '' : ' class="has-error"' ?>>
                                            <input type="text" class="form-control"
                                                name="ytraduko[<?= $this->escape($plugin->getName()) ?>][<?= $this->escape(rawurlencode($key)) ?>]"
                                                value="<?= isset($file[$key]) ? $this->escape($file[$key]) : '' ?>"
                                            />
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="rex-form-panel-footer">
                    <div class="btn-toolbar">
                        <button class="btn btn-save rex-form-aligned pull-right" type="submit"<?= rex::getAccesskey($this->i18n('form_save'), 'save') ?>>
                            <?= $this->i18n('form_save') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>

<style>
    tbody {
        font-size: 12px;
        font-family: -apple-system, BlinkMacSystemFont, 'Lucida Grande', 'Helvetica Neue', Arial, sans-serif;
    }
    tbody td {
        word-break: break-all;
    }
    tbody td code {
        padding: 0;
        background-color: transparent;
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .col-key {
            width: 15%;
        }
        .col-de {
            width: 20%;
        }
        .col-en {
            width: 20%;
        }
    }
    @media (min-width: 1200px) {
        .col-key {
            width: 10%;
        }
        .col-de {
            width: 20%;
        }
        .col-en {
            width: 20%;
        }
    }
</style>
