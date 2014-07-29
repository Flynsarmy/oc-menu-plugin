<?php namespace Flynsarmy\Menu\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flynsarmy\Menu\Models\Menu;

/**
 * Channels Back-end Controller
 */
class Menus extends Controller
{
	public $implement = [
		'Backend.Behaviors.FormController',
		'Backend.Behaviors.ListController'
	];

	public $formConfig = 'config_form.yaml';
	public $listConfig = 'config_list.yaml';

	public $requiredPermissions = ['flynsarmy.menu.access_menus'];

	public function __construct()
	{
		parent::__construct();

		BackendMenu::setContext('Flynsarmy.Menu', 'menu', 'menus');
		$this->addCss('/plugins/flynsarmy/menu/assets/css/admin.css');
	}
}