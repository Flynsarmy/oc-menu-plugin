<?php namespace Flynsarmy\Menu\MenuItemTypes;

use Backend\Widgets\Form;
use Cms\Classes\Controller;
use Flynsarmy\Menu\Models\MenuItem;
use Flynsarmy\Menu\Models\Settings;


abstract class ItemTypeBase
{
	/**
	 * Add fields to the MenuItem form
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	public function extendItemForm(Form $form) {}

	/**
	 * Adds any validation rules to $item->rules array that are required
	 * by the ItemType's extended fields. If necessary, add custom messages
	 * to $item->customMessages.
	 *
	 * For example:
	 * $item->rules['master_object_id'] = 'required';
	 * $item->customMessages['master_object_id.required'] = 'The Blog Post field is required.';
	 *
	 *
	 * @param MenuItem $item
	 *
	 * @return void
	 */
	public function extendItemModel(MenuItem $item) {}

	/**
	 * Add fields to the Settings form
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	public function extendSettingsForm(Form $form) {}

	/**
	 * Adds any validation rules to $settings->rules array that are required
	 * by the settings form's extended fields. If necessary, add custom messages
	 * to $settings->customMessages.
	 *
	 * For example:
	 * $settings->rules['master_object_id'] = 'required';
	 * $settings->customMessages['master_object_id.required'] = 'The Blog Post field is required.';
	 *
	 *
	 * @param Flynsarmy\Menu\Models\Settings $settings
	 *
	 * @return void
	 */
	public function extendSettingsModel(Settings $settings) {}

	/**
	 * Returns the URL for the master object of given ID
	 *
	 * @param  MenuItem  $item Master object iD
	 *
	 * @return string
	 */
	abstract public function getUrl(MenuItem $item);

	/**
	 * Outputs custom markup in place of the default URL. If not specified,
	 * URL is output.
	 *
	 * @param  MenuItem   $item
	 * @param  Controller $controller
	 * @param  array      $settings
	 * @param  integer    $depth
	 * @param  [type]     $url
	 * @param  integer    $child_count
	 *
	 * @return string
	 */
	public function onRender(MenuItem $item, Controller $controller, array $settings, $depth=0, $url, $child_count=0) {}
}