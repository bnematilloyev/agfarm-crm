<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 10/27/18
 * Time: 1:37 PM
 */

namespace common\widgets;

use yii\grid\GridView;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

class SortableGridView extends GridView
{
    /**
     * https://github.com/sjaakp/yii2-sortable-behavior
     * @var array|string
     * The url which is called after an order operation.
     * The format is that of yii\helpers\Url::toRoute.
     * The url will be called with the POST method and the following data:
     * - key    the primary key of the ordered ActiveRecord,
     * - pos    the new, zero-indexed position.
     *
     * Example: ['movie/order-actor', 'id' => 5]
     */
    public $orderUrl;
    /**
     * @var array
     * The options for the jQuery sortable object.
     * See http://api.jqueryui.com/sortable/ .
     * Notice that the options 'helper' and 'update' will be overwritten.
     * Default: empty array.
     */
    public $sortOptions = [];
    /**
     * @var boolean|string
     * The 'axis'-option of the jQuery sortable. If false, it is not set.
     */
    public $sortAxis = 'y';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $classes = isset($this->options['class']) ? $this->options['class'] : '';
        $classes .= ' sortable';
        $this->options['class'] = trim($classes);
        $view = $this->getView();
        //JuiAsset::register($view);
        $url = Url::toRoute($this->orderUrl);
        $sortOpts = array_merge($this->sortOptions, [
            'helper' => new JsExpression('function(e, ui) {
                ui.children().each(function() {
                   $(this).width($(this).width());
                });
                return ui;
            }'),
            'update' => new JsExpression("function(e, ui) {
                jQuery('#{$this->id}').addClass('sorting');
                jQuery.ajax({
                    type: 'POST',
                    url: '$url',
                    data: {
                        key: ui.item.data('key'),
                        pos: ui.item.index()
                    },
                    complete: function() {
                        jQuery('#{$this->id}').removeClass('sorting');
                    }
                });
            }")
        ]);
        if ($this->sortAxis) $sortOpts['axis'] = $this->sortAxis;
        $sortJson = Json::encode($sortOpts);
        $id = $this->getId();
        $view->registerJs("jQuery('#{$id} tbody').sortable($sortJson);");
    }
}
