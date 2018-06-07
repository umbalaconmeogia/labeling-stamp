<?php

namespace app\models;

use Yii;
use batsg\models\BaseModel;
use batsg\helpers\HFile;
use batsg\helpers\HDateTime;
use batsg\models\BaseBatsgModel;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "stamp".
 *
 * @property int $id
 * @property string $file
 * @property int $price
 * @property int $price_setting
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Stamp extends BaseBatsgModel
{
    const IMAGE_SUB_DIR = 'data/stamp';
    
    const PRICE_NOT_SET = 0;
    const PRICE_SET = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stamp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'string'],
            [['price', 'price_setting', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file' => 'File Path',
            'price' => 'Price',
            'price_setting' => 'Price Setting',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    
    /**
     * Add a stamp image into DB.
     * @param string $filePath The resource image.
     * @param integer $price The price (optional).
     * @param boolean $removeFile Remove file after adding stamp or not.
     */
    public static function addStamp($filePath, $price = NULL, $removeFile = TRUE)
    {
        $stamp = new Stamp([
            'price' => $price,
        ]);
        // Copy file into data folder.
        if ($stamp->copyImage($filePath)) {
            // Save DB.
            $stamp->save();
            // Delete file.
            if ($removeFile) {
                unlink($filePath);
            }
        } else {
            $stamp = NULL;
        }
        echo $stamp;
        return $stamp;
    }
    
    /**
     * Copy an image to this stamp object.
     * This will generate a random file name.
     * @param string $sourceFile
     */
    protected function copyImage($sourceFile)
    {
        $this->file = self::generateUniqueRandomString('file', date('Ymd_His_'), 2)
            . '.' . HFile::fileExtension($sourceFile);
            echo $sourceFile;
            return copy($sourceFile, self::imageFilePath($this->file));
    }
    
    /**
     * Retuen the absolute path of the image file.
     * @param string $fileName
     * @return string
     */
    private static function imageFilePath($fileName)
    {
        $dir = HFile::connectPath(\Yii::getAlias('@app/web'), self::IMAGE_SUB_DIR);
        FileHelper::createDirectory($dir);
        $file = HFile::connectPath($dir, $fileName);
        return $file;
    }
    
    /**
     * Return the relative url to the image file.
     * @param string $fileName
     * @return string
     */
    private static function imageFileUrl($fileName)
    {
        return self::IMAGE_SUB_DIR . '/' . $fileName;
    }
}
