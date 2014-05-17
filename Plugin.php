<?php namespace Flynsarmy\Menus;

use System\Classes\PluginBase;

/**
 * Menus Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Menus',
            'description' => 'Create flexible menus straight from October CMS admin',
            'author'      => 'Flyn San',
            'icon'        => 'icon-bars'
        ];
    }

}
