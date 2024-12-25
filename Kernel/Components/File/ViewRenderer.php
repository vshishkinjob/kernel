<?php

namespace Kernel\Components\File;

use Kernel\Components\Exception\File\FileNotFoundException;
use Kernel\Components\Exception\File\RenderViewException;

class ViewRenderer implements ViewRendererInterface
{
	/**
	 * @throws FileNotFoundException
	 * @throws RenderViewException
	 */
    public function renderView(string $filePath, array $args = []): string
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("File: $filePath was not found");
        }

        ob_start();
        include $filePath;
        $view = ob_get_contents();
        ob_end_clean();
        if ($view === false) {
            throw new RenderViewException();
        }
        $view = str_replace(PHP_EOL, '', $view);
        $view = preg_replace('/\s\s+/', ' ', $view);
        if (!is_string($view) || empty($view)) {
            throw new RenderViewException();
        }
        return $view;
    }
}
