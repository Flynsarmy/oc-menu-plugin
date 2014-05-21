<?php namespace Flynsarmy\Menu\Models;

use Model;

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
    protected $fillable = ['enabled', 'label', 'title_attrib', 'id_attrib', 'class_attrib', 'url', 'parent_id'];

    public $belongsTo = [
        'menu' => ['Flynsarmy\Menu\Models\Menu'],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'label' => 'required'
    ];
}