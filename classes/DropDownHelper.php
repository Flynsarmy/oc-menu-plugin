<?php namespace Flynsarmy\Menu\Classes;

use Cms\Classes\Page as Pg;
use Cms\Classes\Partial as Prtl;
use Cms\Classes\Theme;

class DropDownHelper
{
	use \October\Rain\Support\Traits\Singleton;

	protected $pages = [];
	protected $partials = [];

	public function pages()
	{
		if ( !$this->pages )
		{
			$theme = Theme::getEditTheme();
			$pages = Pg::listInTheme($theme, true);

			$options = [];
			foreach ( $pages as $page )
				$options[$page->baseFileName] = $page->title . ' ('.$page->url.')';

			asort($options);

			$this->pages = $options;
		}

		return $this->pages;
	}

	public function partials()
	{
		if ( !$this->partials )
		{
			$theme = Theme::getEditTheme();
			$partials = Prtl::listInTheme($theme, true);

			$options = [];
			foreach ( $partials as $partial )
				$options[$partial->baseFileName] = $partial->baseFileName;

			asort($options);

			$this->partials = $options;
		}

		return $this->partials;
	}
}