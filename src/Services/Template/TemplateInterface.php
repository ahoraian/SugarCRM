<?php declare(strict_types=1);

namespace App\Services\Template;

interface TemplateInterface
{
    /**
     * @param string $filename
     * @return string
     */
    public function render(string $filename): string;
}