<?php namespace Flynsarmy\Menu\Models;

use Model;
use Cms\Classes\Page;
use Cms\Classes\Theme;

class Settings extends Model
{
	public $implement = ['System.Behaviors.SettingsModel'];

	// A unique code
	public $settingsCode = 'flynsarmy_menu_settings';

	// Reference to field configuration
	public $settingsFields = 'fields.yaml';

	// Page list for drop down fields
	protected $pages = [];

	public function getPagesDropDown()
	{
		if ( !$this->pages )
		{
			$theme = Theme::getEditTheme();
			$pages = Page::listInTheme($theme, true);
			$this->pages = [];
			foreach ( $pages as $page )
				$this->pages[$page->baseFileName] = $page->title . ' ('.$page->url.')';
		}

		return $this->pages;
	}
}