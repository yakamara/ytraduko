<?php

/** @var rex_addon $this */

ob_start();

rex_be_controller::setPages(['ytraduko' => $this->getProperty('page')]);
rex_be_controller::setCurrentPage('ytraduko');

rex_view::addJsFile(rex_url::coreAssets('jquery.min.js'));
rex_view::addJsFile(rex_url::coreAssets('jquery-ui.custom.min.js'));
rex_view::addJsFile(rex_url::coreAssets('jquery-pjax.min.js'));
rex_view::addJsFile(rex_url::coreAssets('standard.js'));

rex_view::setJsProperty('backend', true);
rex_view::setJsProperty('accesskeys', rex::getProperty('use_accesskeys'));
rex_view::setJsProperty('page', 'ytraduko');

$beStyle = rex_addon::get('be_style');
$beStyleRedaxo = $beStyle->getPlugin('redaxo');

rex::setProperty('redaxo', true);
$beStyle->includeFile('boot.php');
$beStyleRedaxo->includeFile('boot.php');
rex::setProperty('redaxo', false);

rex_view::addCssFile($this->getAssetsUrl('style.css'));

$user = rex_backend_login::createUser();

if ($user) {
    $lang = $user->getLanguage();
    if ($lang && 'default' !== $lang && rex::getProperty('lang') !== $lang) {
        rex_i18n::setLocale($lang);
    }
} else {
    rex_extension::register('META_NAVI', function () {
        return [
            sprintf('<li><a href="%s" class="rex-login"><i class="rex-icon rex-icon-sign-in"></i> %s</a></li>', rex_url::backend(), rex_i18n::msg('login')),
        ];
    });
}

// use backend csrf tokens in header
rex::setProperty('redaxo', true);
require rex_path::core('layout/top.php');
rex::setProperty('redaxo', false);

$this->includeFile('pages/index.php');

require rex_path::core('layout/bottom.php');

$content = ob_get_clean();

// replace title
$content = preg_replace('/(?<=<title>)[^<]*(?=REDAXO CMS)/', 'YTraduko · ', $content);

// replace logo link
$content = preg_replace('/(?<=<a class="navbar-brand" href=")[^"]*(?=">)/', rex_url::frontend(), $content);

// replace asset paths
$content = preg_replace('@(?<=index\.php\?asset=)\.?(?=/assets/)@', '..', $content);

// fake login page to avoid htaccess check with wrong paths
$content = str_replace('</body>', '<div id="rex-page-login" class="hidden"></div></body>', $content);

rex_response::sendPage($content);
