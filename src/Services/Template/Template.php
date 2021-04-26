<?php

namespace App\Services\Template;

use App\Services\Exceptions\TemplateNotFoundException;

class Template implements TemplateInterface
{
    /**
     * Template constructor.
     *
     * @param string|null $folder
     * @param array $properties
     */
    function __construct(public ?string $folder = null,
                         public array $properties = [])
    {
        if ($folder) {
            $this->setFolder($folder);
        }
    }

    /**
     * Simple method for updating the base folder where templates are located.
     *
     * @param $folder
     */
    function setFolder($folder)
    {
        // normalize the internal folder value by removing any final slashes
        $this->folder = rtrim($folder, '/');
    }

    /**
     * Find and attempt to render a template with variables
     *
     * @param string $filename
     * @return string
     */
    function render(string $filename): string
    {
        $path = "{$this->folder}/{$filename}";

        ob_start();

        if(file_exists($path)){
            include($path);
        } else {
            throw new TemplateNotFoundException("template {$path} not found", 404);
        }

        return ob_get_clean();
    }

    /**
     * @param $k
     * @param $v
     */
    public function __set($k, $v)
    {
        $this->properties[$k] = $v;
    }

    /**
     * @param $k
     * @return mixed
     */
    public function __get($k)
    {
        return $this->properties[$k];
    }
}