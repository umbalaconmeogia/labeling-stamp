<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Stamp;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StampController extends Controller
{
    /**
     * @var array
     */
    protected $actionOptions = [
        'add-stamp-image' => [
            'file',
            'price',
        ],
    ];
    
    /**
     * @var string
     */
    public $file;
    
    /**
     * @var integer
     */
    public $price;
    
    /**
     * {@inheritDoc}
     * @see \yii\console\Controller::options()
     */
    public function options($actionID)
    {
        $result = [];
        if (isset($this->actionOptions[$actionID])) {
            $result = $this->actionOptions[$actionID];
        }
        return $result;
    }
    
    /**
     * Add an image into the DB.
     */
    public function actionAddStampImage()
    {
        Stamp::addStamp($this->file, $this->price, FALSE);
    }
}
