<?php namespace Flynsarmy\Menu\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * Rich Editor
 * Renders a rich content editor field.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class ItemList extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    public $defaultAlias = 'itemlist';

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('itemlist');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $toolbarConfig = $this->makeConfig();
        $toolbarConfig->buttons = '@/plugins/flynsarmy/menu/controllers/menus/_items_toolbar.htm';

        $this->vars['toolbar'] = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);

        $this->vars['stretch'] = $this->formField->stretch;
        $this->vars['size'] = $this->formField->size;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->model->{$this->columnName};
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('vendor/redactor/redactor.css');
        $this->addCss('css/itemlist.css');
        $this->addJs('vendor/redactor/redactor.js');
        $this->addJs('js/itemlist.js');
    }

}