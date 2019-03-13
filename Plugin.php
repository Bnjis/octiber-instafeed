<?php namespace BenjaminLienart\Instagram;

/**
 * The plugin.php file (called the plugin initialization script) defines the plugin information class.
 */

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function pluginDetails()
    {
        return [
            'name'        => 'Instagram feed',
            'description' => 'Integration Kit to display instagram feed.',
            'author'      => 'Benjamin Lienart',
            'icon'        => 'icon-instagram'
        ];
    }

    public function registerComponents()
    {
        return [
            'BenjaminLienart\Instagram\Components\UserFeed' => 'userFeed',
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Instagram',
                'icon'        => 'icon-instagram',
                'description' => 'Configure Instagram authentication.',
                'class'       => 'BenjaminLienart\Instagram\Models\Settings',
                'order'       => 211
            ]
        ];
    }
}