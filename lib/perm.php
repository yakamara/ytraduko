<?php

class rex_ytraduko_perm extends rex_complex_perm
{
    public function hasAny()
    {
        return $this->hasAll() || count($this->perms);
    }

    public function has($language)
    {
        return $this->hasAll() || in_array($language, $this->perms);
    }

    public function getLanguages()
    {
        return $this->hasAll() ? self::getAllLanguages() : $this->perms;
    }

    public static function getFieldParams()
    {
        $languages = self::getAllLanguages();
        $options = array_combine($languages, $languages);

        return [
            'label' => rex_i18n::msg('ytraduko_perm'),
            'all_label' => rex_i18n::msg('ytraduko_perm_all'),
            'options' => $options,
        ];
    }

    private static function getAllLanguages()
    {
        return rex_addon::get('ytraduko')->getProperty('config')['languages'];
    }
}
