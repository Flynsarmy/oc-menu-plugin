<?php namespace Flynsarmy\Menu;

use Backend;
use System\Classes\PluginBase;
use System\Classes\PluginManager;

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
			'icon'        => 'icon-bars',
            'homepage'    => 'https://github.com/Flynsarmy/oc-menu-plugin'
		];
	}

	public function registerNavigation()
	{
		return [
			'menu' => [
				'label'       => 'Menus',
				'url'         => Backend::url('flynsarmy/menu/menus'),
				'icon'        => 'icon-bars',
				'permissions' => ['flynsarmy.menu.*'],
				'order'       => 500,

				'sideMenu' => [
					'menus' => [
						'label'       => 'All Menus',
						'icon'        => 'icon-bars',
						'url'         => Backend::url('flynsarmy/menu/menus'),
						'permissions' => ['flynsarmy.menu.access_menus'],
					],
					'settings' => [
						'label'       => 'Settings',
						'icon'        => 'icon-cog',
						'url'         => Backend::url('flynsarmy/menu/settings'),
						'permissions' => ['flynsarmy.menu.access_menu_settings'],
					],
				]

			]
		];
	}

	public function registerPermissions()
	{
		return [
			'flynsarmy.menu.access_menus'          => ['label' => 'Menus - Access Menus', 'tab' => 'Flynsarmy'],
			'flynsarmy.menu.access_menu_settings'  => ['label' => 'Menus - Access Settings', 'tab' => 'Flynsarmy'],
		];
	}

	public function registerComponents()
	{
		return [
			'\Flynsarmy\Menu\Components\Menu' => 'menu'
		];
	}

	public function register_flynsarmy_menu_item_types()
	{
		$types = [
			'Flynsarmy\\Menu\\MenuItemTypes\\Page' => [
				'label' => 'Page',
				'alias' => 'page',
				'description' => 'A link to a CMS Page'
			],
			'Flynsarmy\\Menu\\MenuItemTypes\\Partial' => [
				'label' => 'Partial',
				'alias' => 'partial',
				'description' => 'Render a CMS Partial'
			],
			'Flynsarmy\\Menu\\MenuItemTypes\\Link' => [
				'label' => 'Link',
				'alias' => 'link',
				'description' => 'A given URL'
			],
		];

		if ( PluginManager::instance()->hasPlugin('RainLab.Blog') )
		{
			$types['Flynsarmy\\Menu\\MenuItemTypes\\BlogPost'] = [
				'label' => 'Blog Post',
				'alias' => 'blog_post',
				'description' => 'A link to a Blog Post',
			];

			$types['Flynsarmy\\Menu\\MenuItemTypes\\BlogCategory'] = [
				'label' => 'Blog Category',
				'alias' => 'blog_category',
				'description' => 'A link to a Blog Category'
			];
		}

		return $types;
	}
}
