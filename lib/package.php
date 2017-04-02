<?php

class rex_ytraduko_package
{
    protected $name;
    protected $version;
    protected $path;

    /** @var rex_ytraduko_file */
    protected $source;

    protected $countKeys;

    /** @var rex_ytraduko_file[] */
    protected $files;

    protected function __construct($name, $version, $path)
    {
        $this->name = $name;
        $this->version = $version;
        $this->path = $path;

        $this->source = new rex_ytraduko_file($path.'/de_de.lang');
        $this->countKeys = count($this->source);
    }

    public static function getAll()
    {
        $all = [];
        $all['core']['core'] = new self('core', rex::getVersion(), rex_path::core('lang'));

        $config = rex_addon::get('ytraduko')->getProperty('config');

        $add = function ($group, rex_addon $addon) use (&$all, $config) {
            static $added = [];

            if (isset($added[$addon->getName()])) {
                return;
            }

            if (in_array($addon->getName(), $config['packages_ignore'])) {
                return;
            }

            $addon = rex_ytraduko_addon::create($addon);
            if ($addon) {
                $all[$group][$addon->getName()] = $addon;
                $added[$addon->getName()] = true;
            }
        };

        foreach ($config['packages_order'] as $group => $addons) {
            foreach ($addons as $addon) {
                if (rex_addon::exists($addon)) {
                    $add($group, rex_addon::get($addon));
                }
            }
        }

        foreach (rex_addon::getRegisteredAddons() as $addon) {
            $add('other_addons', $addon);
        }

        return $all;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function countKeys()
    {
        return $this->countKeys;
    }

    public function countLanguageKeys($language)
    {
        return count($this->getFile($language));
    }

    /**
     * @param string $language
     *
     * @return rex_ytraduko_file
     */
    public function getFile($language)
    {
        if (!isset($this->files[$language])) {
            $this->files[$language] = new rex_ytraduko_file($this->path.'/'.$language.'.lang', $this->getSource());
        }

        return $this->files[$language];
    }

    public function save($language)
    {
        $content = rex_file::get($this->source->getPath());
        $file = $this->getFile($language);

        foreach ($file as $key => $value) {
            $content = preg_replace(
                '/^('.preg_quote($key, '/').'\h*=\h*)(\V*\S)?\h*$/m',
                rtrim('${1}'.$value),
                $content
            );
        }

        rex_file::put($file->getPath(), $content);
    }
}
