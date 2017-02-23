<?php /** @var rex_fragment $this */ ?>
<ul class="nav navbar-nav">
    <li>
        <a href="<?= $this->context->getUrl(['language' => null, 'package' => null]) ?>">
            <?= $this->i18n('ytraduko_overview') ?>
        </a>
    </li>
    <li class="dropdown">
        <?php
            $items = array_map(function (rex_ytraduko_package $package) {
                return [
                    'title' => $this->escape($package->getName()),
                    'href' => $this->context->getUrl(['package' => $package->getName()]),
                    'active' => $this->package === $package,
                ];
            }, $this->packages);

            $this->subfragment('core/dropdowns/dropdown.php', [
                'toolbar' => true,
                'button_prefix' => $this->i18n('ytraduko_package').': ',
                'button_label' => $this->escape($this->package->getName()),
                'items' => $items,
            ]);
        ?>
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
