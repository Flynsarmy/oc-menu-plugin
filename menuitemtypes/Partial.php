<?php namespace Flynsarmy\Menu\MenuItemTypes;

use Cms\Classes\Controller;
use Cms\Classes\Theme;
use Flynsarmy\Menu\Models\MenuItem;
use Backend\Widgets\Form;
use Cms\Classes\Partial as Prtl;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;
use Flynsarmy\Menu\Classes\DropDownHelper;

class Partial extends ItemTypeBase
{
	// use \Backend\Traits\ViewMaker {
 //        ViewMaker::makeFileContents as localMakeFileContents;
 //    }

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
				'label' => 'Partial',
				'comment' => 'Select the partial you wish to render.',
				'type' => 'dropdown',
				'options' => DropDownHelper::instance()->partials(),
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
		$item->rules['master_object_id'] = 'required';
		$item->customMessages['master_object_id.required'] = 'The Partial field is required.';
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
		return '';
	}

	/**
	 * Outputs custom markup in place of the default URL. If not specified,
	 * URL is output.
	 *
	 * @param  MenuItem $item
	 *
	 * @return string
	 */
	public function onRender(MenuItem $item, Controller $controller, array $settings, $depth=0, $url, $child_count=0)
	{
		$theme = Theme::getEditTheme();

		return $controller->renderPartial($item->master_object_id, [
			'item' => $item,
			'settings' => $settings,
			'depth' => $depth,
			'url' => $url,
			'child_count' => $child_count,
			'before_item' => sprintf($settings['before_item'], $item->id, $item->id_attrib, $item->getClassAttrib($settings, $depth), $item->title_attrib),
			'after_item' => sprintf($settings['after_item'], $item->id, $item->id_attrib, $item->getClassAttrib($settings, $depth), $item->title_attrib),
		]);
	}
}