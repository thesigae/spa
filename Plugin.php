<?php namespace Branmuffin\Spa;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'BranMuffin\Spa\Components\GetPages' => 'getPages'
            ];
    }

    public function registerSettings()
    {
    }
}
