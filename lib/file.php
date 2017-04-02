<?php

class rex_ytraduko_file extends ArrayObject
{
    private $path;

    /**
     * @param string    $path
     * @param null|self $baseFile
     */
    public function __construct($path, self $baseFile = null)
    {
        $this->path = $path;

        if (file_exists($path)) {
            $this->load($baseFile);
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    private function load(self $baseFile = null)
    {
        if (
            ($content = rex_file::get($this->path)) &&
            preg_match_all('/^([^\s]*)\h*=\h*(\V*\S?)\h*$/m', $content, $matches, PREG_SET_ORDER)
        ) {
            foreach ($matches as $match) {
                if (!$match[2]) {
                    continue;
                }
                if ($baseFile && !isset($baseFile[$match[1]])) {
                    continue;
                }

                $this[$match[1]] = $match[2];
            }
        }
    }
}
