<?php /** @var rex_fragment $this */ ?>
<table class="table table-hover rex-ytraduko-overview" data-pjax-scroll-to="0">
    <thead>
        <tr>
            <th class="rex-table-icon">&nbsp;</th>
            <th style="width: 200px"><?= rex_i18n::msg('package_hname') ?></th>
            <th style="width: 100px"><?= rex_i18n::msg('package_hversion') ?></th>
            <th style="width: 100px" class="text-center">de_de</th>
            <?php foreach ($this->languages as $language): ?>
                <th class="text-center"><?= $this->escape($language) ?></th>
            <?php endforeach ?>
        </tr>
        <tr>
            <td class="rex-table-icon"></td>
            <td><b><?= mb_strtoupper($this->i18n('ytraduko_total')) ?></b></td>
            <td></td>
            <td class="text-center" data-title="de_de"><b><?= $this->total['de_de'] ?></b></td>
            <?php foreach ($this->languages as $language): ?>
                <?php $percentage = (int) (100 * $this->total[$language] / $this->total['de_de']); ?>
                <td class="text-center" data-title="<?= $this->escape($language) ?>">
                    <div class="progress" style="margin-bottom: 0" title="<?= $this->total[$language], ' / ', $this->total['de_de'] ?>">
                        <div class="progress-bar progress-bar-success" style="width: <?= $percentage ?>%">
                            <?= $percentage ?> %
                        </div>
                        <div class="progress-bar progress-bar-danger" style="width: <?= 100 - $percentage ?>%"></div>
                    </div>
                </td>
            <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->packages as $group => $groupPackages): ?>
            <tr>
                <td></td>
                <td colspan="<?= 3 + count($this->languages) ?>">
                    <b><?= $this->i18n('ytraduko_packages_'.$group) ?></b>
                </td>
            </tr>
            <?php foreach ($groupPackages as $package): /** @var rex_ytraduko_package $package */ ?>
                <tr>
                    <td class="rex-table-icon"><i class="rex-icon rex-icon-package-addon"></i></td>
                    <td data-title="<?= rex_i18n::msg('package_hname') ?>"><?= $this->escape($package->getName()) ?></td>
                    <td data-title="<?= rex_i18n::msg('package_hversion') ?>"><?= $this->escape($package->getVersion()) ?></td>
                    <td class="text-center" data-title="de_de"><?= $package->countKeys() ?></td>
                    <?php foreach ($this->languages as $language): ?>
                        <?php $percentage = (int) (100 * $package->countLanguageKeys($language) / $package->countKeys()); ?>
                        <td class="text-center" data-title="<?= $this->escape($language) ?>">
                            <a href="<?= $this->context->getUrl(['language' => $language, 'package' => $package->getName()]) ?>">
                                <div class="progress" style="margin-bottom: 0" title="<?= $package->countLanguageKeys($language), ' / ', $package->countKeys() ?>">
                                    <div class="progress-bar progress-bar-success" style="width: <?= $percentage ?>%">
                                        <?= $percentage ?> %
                                    </div>
                                    <div class="progress-bar progress-bar-danger" style="width: <?= 100 - $percentage ?>%"></div>
                                </div>
                            </a>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        <?php endforeach ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>
