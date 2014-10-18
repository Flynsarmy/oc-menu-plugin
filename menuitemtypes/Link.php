<?php namespace Flynsarmy\Menu\MenuItemTypes;

use Flynsarmy\Menu\Models\MenuItem;
use Backend\Widgets\Form;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;

class Link extends ItemTypeBase
{
	/**
	 * Add fields to the MenuItem form
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	public function extendItemForm(Form $form)
	{
		$form->addFields([
			'url' => [
				'label' => 'URL',
				'comment' => 'Enter the URL above. Leave blank for #',
				'type' => 'text',
				'tab' => 'Item',
			],
		], 'primary');
	}

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
	public function extendItemModel(MenuItem $item)
	{
		$item->rules['url'] = 'url';
		$item->customMessages['url.url'] = 'The Link field must be a valid URL.';
	}

	/**
	 * Returns the URL for the master object of given ID
	 *
	 * @param  MenuItem  $item Master object iD
	 *
	 * @return string
	 */
	public function getUrl(MenuItem $item)
	{
		return $item->url ?: '#';
	}
}