<?php

class rex_ytraduko_addon extends rex_ytraduko_package
{
    /** @var rex_ytraduko_package[] */
    private $plugins;

    /**
     * @param rex_addon $addon
     *
     * @return null|self
     */
    public static function create(rex_addon $addon)
    {
        $countKeys = 0;
        $plugins = [];

        foreach ($addon->getRegisteredPlugins() as $plugin) {
            if (file_exists($plugin->getPath('lang/de_de.lang'))) {
                $package = new rex_ytraduko_package($plugin->getName(), $plugin->getVersion(), $plugin->getPath('lang'));
                if ($package->countKeys()) {
                    $plugins[] = $package;
                    $countKeys += $package->countKeys();
                }
            }
        }

        if ($plugins || file_exists($addon->getPath('lang/de_de.lang'))) {
            $addon = new self($addon->getName(), $addon->getVersion(), $addon->getPath('lang'));
            $addon->plugins = $plugins;
            $addon->countKeys += $countKeys;
            if ($addon->countKeys()) {
                return $addon;
            }
        }

        return null;
    }

    /**
     * @return rex_ytraduko_package[]
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    public function countLanguageKeys($language)
    {
        $count = parent::countLanguageKeys($language);

        foreach ($this->plugins as $plugin) {
            $count += $plugin->countLanguageKeys($language);
        }

        return $count;
    }
}
