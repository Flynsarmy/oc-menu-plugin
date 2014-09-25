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
            $this->menuTree= $this->buildTree($singlemenu);
    }

    /**
     * Using eager loading and creating my menuTree here uses way less database queries.
     * The same thing could easily be done in the twig template using methods like getEagerChildren(), but this queries
     *      the database more.
     *
     * @param $elements
     * @param int $parentId
     * @return array
     */
    function buildTree($elements, $parentId = 0) {
        $branch = array();

        if(isset($elements->items)){
            $items = $elements->items;
        }
        else {
            $items = $elements;
        }
        foreach ($items as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($items, $element->id);
                if ($children) {
                    $element->children = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }}