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

    /**
     * @return self[]
     */
    public static function getAll()
    {
        $all = [];
        $all['core'] = new self('core', rex::getVersion(), rex_path::core('lang'));

        $ignore = rex_addon::get('ytraduko')->getProperty('config')['packages_ignore'];

        foreach (rex_addon::getRegisteredAddons() as $addon) {
            if (in_array($addon->getName(), $ignore)) {
                continue;
            }

            $addon = rex_ytraduko_addon::create($addon);
            if ($addon) {
                $all[$addon->getName()] = $addon;
            }
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
            $this->files[$language] = new rex_ytraduko_file($this->path.'/'.$language.'.lang');
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
