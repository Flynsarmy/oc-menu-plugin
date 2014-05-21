<?php namespace Flynsarmy\Menu\Models;

use Model;

/**
 * Menu Model
 */
class Menu extends Model
{
	use \Backend\Traits\ViewMaker;

	protected $default_settings = [
		'selected_item_matches' => 'id', //'id' or 'class'
		'selected_item_class' => 'menu-item-selected',

		'depth_prefix' => 'menu-item-level',
		'depth' => 0,

		'before_menu' => '', //array($id, $name, $short_desc)
		'after_menu' => '',
		'before_item' => '<li id="%1$s" class="%2$s">', //array($id, $class)
		'after_item' => '</li>',

		'before_url_item_label' => '<a href="%1$s" title="%2$s" class="title">', //array($url, $label)
		'after_url_item_label' => "</a>",
		'before_nourl_item_label' => '<span class="title">', //array($label)
		'after_nourl_item_label' => "</span>",

		'always_show_before_after_children' => false,
		'before_children' => '<ul>',
		'after_children' => '</ul>',
	];

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
		'title' => 'required'
	];

	/**
	 * @var array Relations
	 */
	public $hasMany = [
		'items' => ['Flynsarmy\Menu\Models\Menuitem']
	];

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
		$settings = array_merge($this->default_settings, $overrides);


		$form_model = $this;
		return $this->makePartial('menu', [
			'menu' => $this,
			'settings' => $settings,
		]);
	}
}