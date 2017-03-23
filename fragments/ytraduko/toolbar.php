<?php /** @var rex_fragment $this */ ?>
<ul class="nav navbar-nav">
    <li>
        <a href="<?= $this->context->getUrl(['language' => null, 'package' => null]) ?>">
            <?= $this->i18n('ytraduko_overview') ?>
        </a>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <?= $this->i18n('ytraduko_package') ?>:
            <b><?= $this->escape($this->package->getName()) ?></b>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <?php foreach ($this->packages as $group => $groupPackages): ?>
                <li class="dropdown-header">
                    <?= $this->i18n('ytraduko_packages_'.$group) ?>
                </li>

                <?php foreach ($groupPackages as $package): /** @var rex_ytraduko_package $package */ ?>
                    <li<?php if ($this->package === $package): ?> class="active"<?php endif ?>>
                        <a href="<?= $this->context->getUrl(['package' => $package->getName()]) ?>">
                            <?= $this->escape($package->getName()) ?>
                        </a>
                    </li>
                <?php endforeach ?>
            <?php endforeach ?>
        </ul>
    </li>
    <li class="dropdown">
        <?php
            $items = array_map(function ($language) {
                return [
                    'title' => $this->escape($language),
                    'href' => $this->context->getUrl(['language' => $language]),
                    'active' => $this->language === $language,
                ];
            }, $this->languages);

            $this->subfragment('core/dropdowns/dropdown.php', [
                'toolbar' => true,
                'button_prefix' => $this->i18n('ytraduko_language').': ',
                'button_label' => $this->escape($this->language),
                'items' => $items,
            ]);
        ?>
    </li>
</ul>
