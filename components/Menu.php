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

			// // Selected items
			// 'selected_item_matches' => [
			// 	'title' => 'Selected Item Matches',
			// 	'type' => 'dropdown',
			// 	'options' => ['id'=>'id', 'class'=>'class'],
			// 	'default' => 'id',
			// 	'description' => '',
			// ],
			// 'selected_item_class' => [
			// 	'title' => 'Selected Item Class',
			// 	'type' => 'string',
			// 	'default' => 'menu-item-selected',
			// 	'description' => '',
			// ],

			// // Depth
			// 'depth_prefix' => [
			// 	'title' => 'Depth Prefix',
			// 	'type' => 'string',
			// 	'default' => 'menu-item-level-',
			// 	'description' => '',
			// ],
			// // 'depth' => [
			// // 	'title' => 'Starting Depth',
			// // 	'type' => 'integer',
			// // 	'default' => 0,
			// // 	'description' => '',
			// // ],

			// // Before/after menus/items
			// 'before_menu' => [
			// 	'title' => 'Before Menu',
			// 	'type' => 'string',
			// 	'default' => '',
			// 	'description' => 'HTML added before the menu. Available variables: ID, name, short desc',
			// ],
			// 'after_menu' => [
			// 	'title' => 'After Menu',
			// 	'type' => 'string',
			// 	'default' => '',
			// 	'description' => 'HTML added after the menu. Available variables: ID, name, short desc',
			// ],
			// 'before_item' => [
			// 	'title' => 'Before Item',
			// 	'type' => 'string',
			// 	'default' => '<li id="%1$s" class="%2$s">',
			// 	'description' => 'HTML added before the menu. Available variables: Item ID, class',
			// ],
			// 'after_item' => [
			// 	'title' => 'After Item',
			// 	'type' => 'string',
			// 	'default' => '</li>',
			// 	'description' => 'HTML added after the menu. Available variables: Item ID, class',
			// ],

			// // Before/after item labels
			// 'before_url_item_label' => [
			// 	'title' => 'Before URL Items',
			// 	'type' => 'string',
			// 	'default' => '<a href="%1$s" title="%2$s" class="title">',
			// 	'description' => 'HTML added before menu items that have URLs. Available variables: URL, Item ID, class, label',
			// ],
			// 'after_url_item_label' => [
			// 	'title' => 'After URL Items',
			// 	'type' => 'string',
			// 	'default' => '</a>',
			// 	'description' => 'HTML added after menu items that have URLs. Available variables: URL, Item ID, class, label',
			// ],
			// 'before_nourl_item_label' => [
			// 	'title' => 'Before NonURL Items',
			// 	'type' => 'string',
			// 	'default' => '<span class="title">',
			// 	'description' => 'HTML added before menu items that have URLs. Available variables: Item ID, class, label',
			// ],
			// 'after_nourl_item_label' => [
			// 	'title' => 'After NonURL Items',
			// 	'type' => 'string',
			// 	'default' => '</span>',
			// 	'description' => 'HTML added after menu items that have URLs. Available variables: Item ID, class, label',
			// ],

			// // Children
			// 'always_show_before_after_children' => [
			// 	'title' => 'Always Show Before/After Children',
			// 	'type' => 'checkbox',
			// 	'default' => false,
			// 	'description' => 'Show the Before Children/After Children HTML below, even if there are no children for this menu item.',
			// ],
			// 'before_children' => [
			// 	'title' => 'Before Children',
			// 	'type' => 'string',
			// 	'default' => '<ul class="menu-item-children">',
			// 	'description' => 'HTML added before menu items children.',
			// ],
			// 'after_children' => [
			// 	'title' => 'After Children',
			// 	'type' => 'string',
			// 	'default' => '</ul>',
			// 	'description' => 'HTML added after menu items children.',
			// ],
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

		// foreach ( $settings as $key => $setting )
		// 	$this->page[$key] = $setting;

		// // This is an ugly and memory intensive hack required to get around
		// // Controller not having a getVars() method.
		// $this->page['settings'] = $settings;

		return $menu->render($settings);
	}
}