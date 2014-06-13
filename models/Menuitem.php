<?php namespace Flynsarmy\Menu\Models;

use Model;
use Flynsarmy\Menu\Models\Menu;

//http://laravel.io/bin/XLN52#
//http://octobercms.com/docs/database/model#deferred-binding
//http://octobercms.com/docs/backend/widgets#form-widgets

/**
 * Menuitem Model
 */
class Menuitem extends Model
{
	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'flynsarmy_menu_menuitems';

	public $implement = ['October.Rain.Database.Behaviors.NestedSetModel'];

	/**
	 * @var array Guarded fields
	 */
	protected $guarded = ['*'];

	/**
	 * @var array Fillable fields
	 */
	protected $fillable = ['enabled', 'label', 'title_attrib', 'id_attrib', 'class_attrib', 'url', 'master_object_class', 'master_object_id', 'parent_id'];

	public $belongsTo = [
		'menu' => ['Flynsarmy\Menu\Models\Menu'],
	];

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'label' => 'required'
	];

	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Generates a class attribute based on the menu settings and item position
	 *
	 * @param  array  $settings
	 * @param  int    $depth
	 *
	 * @return string
	 */
	public function getClassAttrib( array $settings, $depth )
	{
		$classes = [];
		if ( $this->class_attrib )
			$classes = explode(' ', $this->class_attrib);

		if ( is_int($depth) )
			$classes[] = $settings['depth_prefix'].$depth;

		if ( $this->getChildren()->count() )
			$classes[] = $settings['has_children_class'];

		if ( !empty($settings['selected_item']) )
			if ( $settings['selected_item_matches'] == 'id' && $settings['selected_item'] == $$this->id_attrib ||
				 $settings['selected_item_matches'] == 'class' && in_array($settings['selected_item'], $classes) )
				$classes[] = $options['selected_item_class'];

		return implode(' ', $classes);
	}

	public function render( array $settings, $depth=0, $url, $child_count=0 )
	{
		return require __DIR__.'/../partials/_menuitem.php';
	}
}