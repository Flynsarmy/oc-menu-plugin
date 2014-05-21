<?php namespace Flynsarmy\Menu\MenuItemTypes;

use Backend\Widgets\Form;
use Cms\Classes\Page as Pg;
use Cms\Classes\Theme;
use Flynsarmy\Menu\MenuItemTypes\ItemTypeBase;

/**
 * Rich Editor
 * Renders a rich content editor field.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class Page extends ItemTypeBase
{
	public $pageList;

	public function __construct()
	{
		$theme = Theme::getEditTheme();
		$this->pageList = Pg::listInTheme($theme, true);
	}

	public function formExtendFields(Form $form)
	{
		$context = $form->getContext();

		$options = [];
		foreach ( $this->pageList as $page )
			$options[$page->id] = $page->title . ' ('.$page->url.')';

		asort($options);

		$form->addFields([
			'page_id' => [
				'label' => 'Page',
				'comment' => 'Select the page you wish to link to.',
				'type' => 'dropdown',
				'options' => $options,
			],
		]);
	}
}