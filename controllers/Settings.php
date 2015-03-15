<?php namespace Flynsarmy\Menu\Controllers;

use Lang;
use Flash;
use URL;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\ApplicationException;
use Flynsarmy\Menu\Classes\MenuManager;
use Flynsarmy\Menu\Models\Settings as SettingsModel;

/**
 * Channels Back-end Controller
 */
class Settings extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
    ];

    public $formConfig = 'config_form.yaml';

    public $pageTitle = 'Settings';

	public $requiredPermissions = ['flynsarmy.menu.access_menu_settings'];

	public function __construct()
	{
		parent::__construct();

		$this->addCss('/modules/system/assets/css/settings.css', 'core');

        BackendMenu::setContext('Flynsarmy.Menu', 'menu', 'settings');
	}

	public function index()
	{
		$this->asExtension('FormController')->update();
	}

	/**
	 * Ajax handler for updating the form.
	 * @param int $recordId The model primary key to update.
	 * @return mixed
	 */
    public function index_onSave()
    {
        return $this->asExtension('FormController')->update_onSave();
    }

    public function formExtendFields($form, $fields)
    {
        $plugins = MenuManager::instance()->listItemTypes();

        foreach ( $plugins as $class => $details )
        {
            $class = new $class;
            $class->extendSettingsForm($form);
            $class->extendSettingsModel($this->formFindModelObject());
        }
    }

    public function formFindModelObject()
    {
        return SettingsModel::instance();
    }
}