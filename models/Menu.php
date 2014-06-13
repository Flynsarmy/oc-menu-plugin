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
			'selected_item_matches' => 'id', //'id' or 'class'
			'selected_item_class' => 'menu-item-selected',

			'has_children_class' => 'menu-item-has-children',

			'depth_prefix' => 'menu-item-level-',
			'depth' => 0,

			'before_menu' => '<ul class="menu menu-%1$s">', //array($id, $name, $short_desc)
			'after_menu' => '</ul>', //array($id, $name, $short_desc)
			'before_item' => '<li id="%1$s" class="menu-item %2$s">', //array($id, $class)
			'after_item' => '</li>', //array($id, $class)

			'before_url_item_label' => '<a href="%1$s" title="%4$s" class="menu-title">', //array($url, $id, $class, $title)
			'after_url_item_label' => "</a>", //array($url, $id, $class, $title)
			'before_nourl_item_label' => '<span class="menu-title">', //array($id, $class, $title)
			'after_nourl_item_label' => "</span>", //array($id, $class, $title)

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