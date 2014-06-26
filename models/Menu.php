<?php namespace Flynsarmy\Menu\Models;

use Model;

/**
 * Menu Model
 */
class Menu extends Model
{
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
	protected $fillable = ['name', 'short_desc'];

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'name' => 'required'
	];

	/**
	 * @var array Relations
	 */
	public $hasMany = [
		'items' => ['Flynsarmy\Menu\Models\Menuitem']
	];

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

			'before_url_item_label' => '<a href="%1$s" title="%4$s" class="menu-title">', //array($url, $id, $id_attrib, $class_attrib, $depth, $title)
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

	public function render($overrides = [])
	{
		//Provide some default options
		$settings = array_merge($this->getDefaultSettings(), $overrides);

		return require __DIR__.'/../partials/_menu.php';
	}
}