<?php namespace Flynsarmy\Menu\Models;

use Model;
use Cms\Classes\Controller;
use Flynsarmy\Menu\Models\Menu;

//http://laravel.io/bin/XLN52#
//http://octobercms.com/docs/database/model#deferred-binding
//http://octobercms.com/docs/backend/widgets#form-widgets

/**
 * Menuitem Model
 */
class Menuitem extends Model
{
	use \October\Rain\Database\Traits\Validation;
	use \October\Rain\Database\Traits\NestedTree;

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'flynsarmy_menu_menuitems';

	// public $implement = ['October.Rain.Database.Behaviors.NestedSetModel'];

	/**
	 * @var array Guarded fields
	 */
	protected $guarded = ['*'];

	/**
	 * @var array Fillable fields
	 */
	protected $fillable = ['enabled', 'label', 'title_attrib', 'id_attrib', 'class_attrib', 'target_attrib', 'selected_item_id', 'url', 'data', 'master_object_class', 'master_object_id', 'parent_id'];

	public $belongsTo = [
		'menu' => ['Flynsarmy\Menu\Models\Menu'],
	];

	/**
	 * @var array Validation rules
	 */
	public $rules = [
		'label' => 'required'
	];

	protected $jsonable = ['data'];

	/**
	 * @var array Translatable fields
	 */
	public $translatable = ['label', 'title_attrib'];

	public $customMessages = [];

	protected $cache = [];

	public function getUrl()
	{
		return $this->url;
	}

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
	 * Generates a class attribute based on the menu settings and item position
	 *
	 * @param  array  $settings
	 * @param  int    $depth
	 *
	 * @return string
	 */
	public function getClassAttrib( array $settings, $depth )
	{
		if ( !empty($this->cache['classAttrib']) )
			return $this->cache['classAttrib'];

		$classes = [];
		if ( $this->class_attrib )
			$classes = explode(' ', $this->class_attrib);

		if ( is_int($depth) )
			$classes[] = $settings['depth_prefix'].$depth;

		if ( $this->getChildren()->count() )
			$classes[] = $settings['has_children_class'];

		if ( !empty($settings['selected_item']) && $settings['selected_item'] == $this->selected_item_id )
			$classes[] = $settings['selected_item_class'];

		return $this->cache['classAttrib'] = implode(' ', $classes);
	}

	public function render( Controller $controller, array $settings, $depth=0, $url, $child_count=0 )
	{
		if ( !$this->enabled )
			return '';

		// Support custom itemType-specific output
		if ( class_exists($this->master_object_class) )
		{
			$itemTypeObj = new $this->master_object_class;
			if ( $output = $itemTypeObj->onRender($this, $controller, $settings, $depth, $url, $child_count) )
				return $output;
		}

		return require __DIR__.'/../partials/_menuitem.php';
	}

	public function beforeCreate() 
	{ 
		$this->setDefaultLeftAndRight(); 
	}
}
