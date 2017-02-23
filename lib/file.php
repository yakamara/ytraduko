<?php

class rex_ytraduko_file extends ArrayObject
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;

        if (file_exists($path)) {
            $this->load();
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    private function load()
    {
        if (
            ($content = rex_file::get($this->path)) &&
            preg_match_all('/^([^\s]*)\h*=\h*(\V*\S?)\h*$/m', $content, $matches, PREG_SET_ORDER)
        ) {
            foreach ($matches as $match) {
                if ($match[2]) {
                    $this[$match[1]] = $match[2];
                }
            }
        }
    }
}
