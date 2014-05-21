<?php namespace Flynsarmy\Menu;

use Backend;
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
			'name'        => 'Menu',
			'description' => 'Create flexible menus straight from October CMS admin',
			'author'      => 'Flyn San',
			'icon'        => 'icon-bars'
		];
	}

	public function registerNavigation()
	{
		return [
			'menu' => [
				'label'       => 'Menus',
				'url'         => Backend::url('flynsarmy/menu/menus'),
				'icon'        => 'icon-bars',
				'permissions' => ['flynsarmy.menu:*'],
				'order'       => 500,

				'sideMenu' => [
					'menus' => [
						'label'       => 'All Menus',
						'icon'        => 'icon-bars',
						'url'         => Backend::url('flynsarmy/menu/menus'),
						'permissions' => ['flynsarmy.menu:access_menus'],
					],
				]

			]
		];
	}

	public function register_flynsarmy_menu_item_types()
	{
		return [
			'Flynsarmy\\Menu\\MenuItemTypes\\Page' => [
                'label' => 'Page',
                'alias' => 'page',
                'description' => 'A link to a CMS Page'
            ],
            'Flynsarmy\\Menu\\MenuItemTypes\\Partial' => [
                'label' => 'Partial',
                'alias' => 'partial',
                'description' => 'A link to a CMS Partial'
            ],
            'Flynsarmy\\Menu\\MenuItemTypes\\Link' => [
                'label' => 'Link',
                'alias' => 'link',
                'description' => 'A given URL'
            ],
		];
	}
}
