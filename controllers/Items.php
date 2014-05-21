<?php namespace Flynsarmy\Menu\Controllers;

use BackendMenu;
use Validator;
use Request;
use Exception;
use Backend\Classes\Controller;
use Backend\Widgets\Form;
use Flynsarmy\Menu\Models\Menu;
use Flynsarmy\Menu\Models\MenuItem;
use Flynsarmy\Menu\Classes\MenuManager;

/**
 * Channels Back-end Controller
 */
class Items extends Controller
{
	public $implement = [
		'Backend.Behaviors.FormController',
	];

	public $formConfig = 'config_form.yaml';

	protected $itemTypes;

	public function __construct()
	{
		parent::__construct();

		BackendMenu::setContext('Flynsarmy.Menu', 'menu', 'items');

		$this->itemTypes = MenuManager::instance()->listItemTypes();

		/*
		 * Define layout and view paths
		 */
		$this->layout = 'blank';
		$this->layoutPath = ['plugins/flynsarmy/menu/backend/layouts'];
	}

	public function index($sessionId)
	{
		$this->vars['sessionId'] = $sessionId;
		$this->vars['item_types'] = $this->itemTypes;
	}

	public function create($type, $sessionId)
	{
		$type = MenuManager::instance()->resolveItemType($type);
		$this->vars['sessionId'] = $sessionId;

		if ( !$type )
			$this->handleError(new Exception('Invalid item type: ' . $type));
		else
		{
			$this->vars['type'] = $type;
			$this->getClassExtension('Backend.Behaviors.FormController')->create();
		}
	}

	/**
	 * Add item type-specific fields to the create/edit forms
	 *
	 * @param  Form   $form
	 *
	 * @return void
	 */
	function formExtendFields(Form $form)
	{
		$itemType = new $this->vars['type'];

		$itemType->formExtendFields($form);
	}
}