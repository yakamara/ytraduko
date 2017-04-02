<?php

/** @var rex_addon $this */

rex_complex_perm::register('ytraduko', 'rex_ytraduko_perm');

if (rex::isBackend() && 'ytraduko' === rex_be_controller::getCurrentPage()) {
    rex_view::addCssFile($this->getAssetsUrl('style.css'));
}

$page = new rex_be_page_main('addons', 'ytraduko', 'YTraduko');
$page->setIcon('rex-icon fa-language');
$page->setPath($this->getPath('pages/index.php'));

$this->setProperty('page', $page);

if (rex_plugin::get('structure', 'content')->isAvailable()) {
    return;
}

$page->setHref(rex_url::frontend());

rex_extension::register('PAGE_CHECKED', function (rex_extension_point $ep) {
    if (
        'login' === $ep->getSubject() && rex_get('rex_logout', 'bool') ||
        'ytraduko' === $ep->getSubject() && rex::isBackend()
    ) {
        rex_response::sendRedirect(rex_url::frontend());
    }
});

if (!rex::isBackend()) {
    rex_extension::register('FE_OUTPUT', function () {
        $this->includeFile($this->getPath('pages/frontend.php'));
    });
}
