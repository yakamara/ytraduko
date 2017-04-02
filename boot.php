<?php

/** @var rex_addon $this */

rex_complex_perm::register('ytraduko', 'rex_ytraduko_perm');

if (rex::isBackend() && 'ytraduko' === rex_be_controller::getCurrentPage()) {
    rex_view::addCssFile($this->getAssetsUrl('style.css'));
}
