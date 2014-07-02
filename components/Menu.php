<?php namespace Flynsarmy\Menu\Components;

use Validator;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use Flynsarmy\Menu\Models\Menu as MenuModel;
use System\Classes\ApplicationException;

class Menu extends ComponentBase
{

	public function componentDetails()
	{
		return [
			'name'        => 'Menu List',
			'description' => 'Displays a given menu.'
		];
	}

	public function defineProperties()
	{
		return [
			// Menu selection
			'menu_id' => [
				'title' => 'Menu',
				'type' => 'dropdown',
			],
		];
	}

	public function getMenu_idOptions()
	{
		return MenuModel::select('id', 'name')->orderBy('name')->get()->lists('name', 'id');
	}

	/**
	 * Add default render settings to component
	 *
	 * @return void
	 */
	public function onRender()
	{
		$menu = MenuModel::find($this->property('menu_id', 0));
		// Grab a list of menu settings
		$settings = $menu->getDefaultSettings();

		// Update $settings with any inline paramters they specified on their {% component %}
		foreach ( $settings as $key => $setting )
			$settings[$key] = $this->property($key, $setting);
		$settings['menu'] = $menu;
		$settings['selected_item'] = $this->property('selected_item', '');

		// foreach ( $settings as $key => $setting )
		// 	$this->page[$key] = $setting;

		// // This is an ugly and memory intensive hack required to get around
		// // Controller not having a getVars() method.
		// $this->page['settings'] = $settings;

		return $menu->render($this->controller, $settings);
	}
}