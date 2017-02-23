<?php /** @var rex_fragment $this */ ?>
<form action="<?= $this->context->getUrl() ?>" method="post">
    <section class="rex-page-section">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px"><?= $this->i18n('ytraduko_key') ?></th>
                            <th style="width: 400px">de_de</th>
                            <th><?= $this->escape($this->language) ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $file = $this->package->getFile($this->language) ?>
                        <?php foreach ($this->package->getSource() as $key => $value): ?>
                            <tr>
                                <td><code><?= $this->escape($key) ?></code></td>
                                <td><?= $this->escape($value) ?></td>
                                <td<?= isset($file[$key]) ? '' : ' class="has-error"' ?>>
                                    <input type="text" class="form-control"
                                        name="ytraduko[<?= $this->escape($this->package->getName()) ?>][<?= $this->escape($key) ?>]"
                                        value="<?= isset($file[$key]) ? $this->escape($file[$key]) : '' ?>"
                                    />
                                </td>
                            </tr>
                        <?php endforeach ?>
                        <?php if ($this->package instanceof rex_ytraduko_addon): ?>
                            <?php foreach ($this->package->getPlugins() as $plugin): ?>
                                <tr>
                                    <th colspan="3"><?= $this->escape($plugin->getName()) ?></th>
                                </tr>
                                <?php $file = $plugin->getFile($this->language) ?>
                                <?php foreach ($plugin->getSource() as $key => $value): ?>
                                    <tr>
                                        <td><code><?= $this->escape($key) ?></code></td>
                                        <td><?= $this->escape($value) ?></td>
                                        <td<?= isset($file[$key]) ? '' : ' class="has-error"' ?>>
                                            <input type="text" class="form-control"
                                                name="ytraduko[<?= $this->escape($plugin->getName()) ?>][<?= $this->escape($key) ?>]"
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
