<?php

/** @var rex_addon $this */

echo rex_view::title(include $this->getPath('pages/_title.php'));

$languages = rex::getUser()->getComplexPerm('ytraduko')->getLanguages();
$packages = rex_ytraduko_package::getAll();

$language = rex_get('language', 'string');
$package = rex_get('package', 'string');

$context = rex_context::fromGet();

if (!in_array($language, $languages) || !isset($packages[$package])) {
    $total = ['de_de' => 0];
    foreach ($packages as $package) {
        $k = $package->countKeys();
        $total['de_de'] += $package->countKeys();
    }
    foreach ($languages as $language) {
        $total[$language] = 0;
        foreach ($packages as $package) {
            $total[$language] += $package->countLanguageKeys($language);
        }
    }

    $fragment = new rex_fragment([
        'languages' => $languages,
        'packages' => $packages,
        'total' => $total,
        'context' => $context,
    ]);

    echo rex_view::content($fragment->parse('ytraduko/overview.php'));

    return;
}

$package = $packages[$package];

$fragment = new rex_fragment([
    'languages' => $languages,
    'packages' => $packages,
    'language' => $language,
    'package' => $package,
    'context' => $context,
]);

echo rex_view::toolbar($fragment->parse('ytraduko/toolbar.php'), null, null, true);

$data = rex_post('ytraduko', 'array');
if ($data) {
    foreach ($data as &$packageData) {
        $keys = array_map(function ($key) {
            return rawurldecode($key);
        }, array_keys($packageData));
        $packageData = array_combine($keys, $packageData);
    }

    $package->getFile($language)->exchangeArray(isset($data[$package->getName()]) ? $data[$package->getName()] : []);
    $package->save($language);

    if ($package instanceof rex_ytraduko_addon) {
        foreach ($package->getPlugins() as $plugin) {
            $plugin->getFile($language)->exchangeArray(isset($data[$plugin->getName()]) ? $data[$plugin->getName()] : []);
            $plugin->save($language);
        }
    }

    $package->save($language);

    echo rex_view::success(rex_i18n::msg('form_saved'));
}

$fragment = new rex_fragment([
    'language' => $language,
    'package' => $package,
    'context' => $context,
]);

echo $fragment->parse('ytraduko/form.php');
