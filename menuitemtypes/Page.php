<?php namespace Flynsarmy\Menu\MenuItemTypes;

use URL;
use Flynsarmy\Menu\Models\MenuItem;
use Backend\Widgets\Form;
use Cms\Classes\Page as Pg;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;
use Flynsarmy\Menu\Classes\DropDownHelper;

class Page extends ItemTypeBase
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
			'master_object_id' => [
				'label' => 'Page',
				'comment' => 'Select the page you wish to link to.',
				'type' => 'dropdown',
				'options' => DropDownHelper::instance()->pages(),
				'tab' => 'Item',
			],
			'data[params]' => [
				'label' => 'Slug Parameters / String parameters',
				'comment' => 'If a slug uses a parameter such as :slug, enter a value for it here. Enter valid JSON - for example {"slug":"my-page-slug"}. If not valid JSON will be provided - the parameters string will be added as suffix to the url',
				'type' => 'text',
				'options' => DropDownHelper::instance()->pages(),
				'tab' => 'Item',
			],
            'is_absolute' => [
              'label'=> 'Absolute/Relative?',
              'span'=> 'left',
              'type'=> 'dropdown',
              'comment'=> 'How to build the link, to make it relative or absolute',
              'options'=> [
                    0 => 'Relative',
                    1 => 'Absolute'
                ],
              'tab'=> 'Attributes'
            ]
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
		$item->rules['master_object_id'] = 'required';
		$item->customMessages['master_object_id.required'] = 'The Page field is required.';
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
		$params = [];
		$absolute = ($item->attributes['is_absolute']*1 == 1)?true:false;
		if ( !empty($item->data['params']) )
			$params = (array)json_decode($item->data['params']);

		return Pg::url(Pg::find($item->master_object_id)->fileName, $params, $absolute);
	}
}
