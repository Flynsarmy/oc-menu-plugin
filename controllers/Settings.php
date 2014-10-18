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
	private $formWidget;

	public $pageTitle = 'Settings';

	public $requiredPermissions = ['flynsarmy.menu.access_menu_settings'];

	public function __construct()
	{
		parent::__construct();

		$this->addCss('/modules/system/assets/css/settings.css', 'core');

		BackendMenu::setContext('Flynsarmy.Menu', 'menu', 'settings');
	}

	public function index($code = null)
	{
		try {
			$model = $this->createModel();
			$this->initWidgets($model);
		}
		catch (Exception $ex) {
			$this->handleError($ex);
		}
	}

	/**
	 * Ajax handler for updating the form.
	 * @param int $recordId The model primary key to update.
	 * @return mixed
	 */
	public function index_onSave($recordId = null)
	{
		$model = $this->createModel();
		$this->initWidgets($model);

		$saveData = $this->formWidget->getSaveData();
		foreach ($saveData as $attribute => $value) {
			$model->{$attribute} = $value;
		}
		$model->save(null, $this->formWidget->getSessionKey());

		Flash::success(Lang::get('system::lang.settings.update_success', ['name' => Lang::get('Menu Settings')]));

		if ($redirect = URL::current())
			return Redirect::to($redirect);
	}

	/**
	 * Render the form.
	 */
	public function formRender($options = [])
	{
		if (!$this->formWidget)
			throw new ApplicationException(Lang::get('backend::lang.form.behavior_not_ready'));

		return $this->formWidget->render($options);
	}

	/**
	 * Prepare the widgets used by this action
	 * Model $model
	 */
	protected function initWidgets($model)
	{
		$config = $model->getFieldConfig();
		$config->model = $model;
		$config->arrayName = class_basename($model);
		$config->context = 'update';

		$widget = $this->makeWidget('Backend\Widgets\Form', $config);
		$widget->bindToController();
		$this->formWidget = $widget;

		$plugins = MenuManager::instance()->listItemTypes();
		foreach ( $plugins as $class => $details )
		{
			$class = new $class;
			$class->extendSettingsForm($this->formWidget);
			$class->extendSettingsModel($model);
		}
	}

	/**
	 * Internal method, prepare the list model object
	 */
	protected function createModel()
	{
		return SettingsModel::instance();
	}
}