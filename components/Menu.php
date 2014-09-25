<?php namespace Flynsarmy\Menu\Components;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use Validator;
use Cms\Classes\ComponentBase;
use October\Rain\Support\ValidationException;
use Flynsarmy\Menu\Models\Menu as MenuModel;
use Flynsarmy\Menu\Models\Menuitem;
use System\Classes\ApplicationException;
use Cms\Classes\Controller;


class Menu extends ComponentBase
{

    public $menuTree;

	public function componentDetails()
	{
		return [
			'name'        => 'Menu List',
			'description' => 'Displays a given menu.'
		];
	}

	public function defineProperties()
	{
		return [
			// Menu selection
			'menu_id' => [
				'title' => 'Menu',
				'type' => 'dropdown',
			],
		];
	}

	public function getMenu_idOptions()
	{
		return MenuModel::select('id', 'name')->orderBy('name')->get()->lists('name', 'id');
	}

	/**
	 * Add default render settings to component
	 *
	 * @return void
	 */
	public function onRender()
	{
		//$menu = MenuModel::find($this->property('menu_id', 0));
		$menu = MenuModel::with('items')->where('id', '=', $this->property('menu_id', 0))->get();

        foreach($menu as $singlemenu) // there is only one of these... but eager loading seems to make me do this
            $this->menuTree= $this->buildTree($singlemenu, $this->controller);
    }

    /**
     * Using eager loading and creating my menuTree here uses way less database queries.
     * The same thing could easily be done in the twig template using methods like getEagerChildren(), but this queries
     *      the database more.
     *
     * @param $items
     * @param int $parentId
     * @param $controller
     * @return array
     */
    function buildTree($items, $controller, $parentId = 0) {
        $branch = array();

        // check if this is the first run through of this function
        if(isset($items->items)){
            $items = $items->items;
        }

        foreach ($items as $item) {
            if ($item->parent_id == $parentId) {
                $children = $this->buildTree($items, $controller, $item->id);
                if ($children) {
                    $item->children = $children;
                }
                // Support custom itemType-specific output
                if ( class_exists($item->master_object_class) )
                {
                    $itemTypeObj = new $item->master_object_class;
                    if ( $render = $itemTypeObj->onRender($item, $controller) )
                        $item->render = $render;
                }
                $branch[] = $item;
            }
        }

        return $branch;
    }}