<?php namespace Flynsarmy\Menu\Models;

use Model;
use Cms\Classes\Controller;

/**
 * Menu Model
 */
class Menu extends Model
{
	use \October\Rain\Database\Traits\Validation;

	private $firstItem;

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'flynsarmy_menu_menus';

	/**
	 * @var array Guarded fields
	 */
	protected $guarded = ['*'];

	/**
	 * @var array Fillable fields
	 */
	protected $fillable = ['name', 'short_desc', 'id_attrib', 'class_attrib'];

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'name' => 'required'
	];

	/**
	 * @var array Translatable fields
	 */
	public $translatable = ['name'];

	/**
	 * @var array Relations
	 */
	public $hasMany = [
		'items' => ['Flynsarmy\Menu\Models\Menuitem']
	];

	/**
	 * Add translation support to this model, if available.
	 * @return void
	 */
	// public static function boot()
	// {
	// 	// Call default functionality (required)
	// 	parent::boot();

	// 	// Check the translate plugin is installed
	// 	if ( !class_exists('RainLab\Translate\Behaviors\TranslatableModel') )
	// 		return;

	// 	// Extend the constructor of the model
	// 	self::extend(function($model) {
	// 		// Implement the translatable behavior
	// 		$model->implement[] = 'RainLab.Translate.Behaviors.TranslatableModel';
	// 	});
	// }

	/**
	 * Remove menu items on delete
	 */
	public function beforeDelete()
	{
		foreach ($this->items as $item)
			$item->delete();
	}

	public function getDefaultSettings()
	{
		return [
			'selected_item_class' => 'menu-item-selected',

			'has_children_class' => 'menu-item-has-children',

			'depth_prefix' => 'menu-item-level-',
			'depth' => 0,

			'before_menu' => '<ul id="%3$s" class="menu menu-%1$s %4$s">', //array($id, $name, $id_attrib, $class_attrib, $short_desc)
			'after_menu' => '</ul>', //array($id, $name, $id_attrib, $class_attrib, $short_desc)
			'before_item' => '<li id="%2$s" class="menu-item menu-item-%1$s %3$s">', //array($id, $id_attrib, $class_attrib, $depth, $title)
			'after_item' => '</li>', //array($id, $id_attrib, $class_attrib, $depth, $title)

			'before_url_item_label' => '<a href="%1$s" title="%6$s" class="menu-title" target="%7$s">', //array($url, $id, $id_attrib, $class_attrib, $depth, $title, $target)
			'after_url_item_label' => "</a>", //array($url, $id, $id_attrib, $class_attrib, $depth, $title)
			'before_nourl_item_label' => '<span class="menu-title">', //array($id, $id_attrib, $class_attrib, $depth, $title)
			'after_nourl_item_label' => "</span>", //array($id, $id_attrib, $class_attrib, $depth, $title)

			'always_show_before_after_children' => false,
			'before_children' => '<ul class="menu-children">',
			'after_children' => '</ul>',
		];
	}

	/**
	 * Returns the last updated topic in this channel.
	 * @return Model
	 */
	public function firstItem()
	{
		if ($this->firstItem !== null)
			return $this->firstItem;

		return $this->firstItem = $this->items()->first();
	}

	public function render(Controller $controller, $overrides = [])
	{
		//Provide some default options
		$settings = array_merge($this->getDefaultSettings(), $overrides);

		return require __DIR__.'/../partials/_menu.php';
	}
}