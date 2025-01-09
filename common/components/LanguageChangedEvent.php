<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 11/7/18
 * Time: 8:23 PM
 */

namespace common\components;


use yii\base\Event;
/**
 * This event represents a change of persisted user language via URL.
 */
class LanguageChangedEvent extends Event
{
    /**
     * @var string the new language
     */
    public $language;
    /**
     * @var string|null the old language
     */
    public $oldLanguage;
}
