<?php
namespace app\components;

use yii\base\Model;
use batsg\helpers\CsvWithHeader;

class ConstantValue extends Model
{
    const CACHE_KEY = "CACHE_CONSTANT_VALUE_ALL_DB";
    
    public $category;
    public $code;
    public $name;
    public $value;
    public $remarks;
    
    public function rules()
    {
        return [
            [['category', 'code', 'name', 'value'], 'required'],
        ];
    }

    const IDX_CATEGORY = 0;
    const IDX_CODE = 1;
    const IDX_NAME = 2;
    const IDX_VALUE = 3;
    const IDX_REMARKS = 4;
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category' => 'Category',
            'code' => 'Code',
            'name' => 'Name',
            'value' => 'Value',
            'remarks' => 'Remarks',
        ];
    }
    
    /**
     * Load all records from csv file.
     * @return ConstantValue[]
     */
    private static function loadCsv()
    {
        $constantValues = [];
        CsvWithHeader::read(\Yii::getAlias('@app/config/constantValue.csv'), function($csv)
                use (&$constantValues) {
            /** @var CsvWithHeader $csv */
            while ($csv->loadRow() !== FALSE) {
                // Get attributes as an array.
                $attr = $csv->getRowAsAttributes();
                // Create a model from attributes array.
                $constantValues[] = new ConstantValue($attr);
            }
        });
        return $constantValues;
    }
    
    /**
     * Get all data from DB. This uses cache to reduce DB query.
     * @param string $category If null, then all records are get.
     * @param string $keyField If specified, then return array has key speciffied by this field's value.
     *                         This is set only when $category is not NULL.
     * @return ConstantValue[]
     */
    public static function getAllRecords($category = NULL, $keyField = NULL)
    {
        if ($category === NULL && $keyField) {
            throw new \Exception('Parameter $keyField is specified with NULL $cateogry.');
        }
        /** @var ConstantValue[] $data */
        $data = \Yii::$app->cache->getOrSet(self::CACHE_KEY, function() {
            return self::loadCsv();
        });
        if ($category) {
            // Get data belong to specified category.
            $assoc = [];
            foreach ($data as $constantValue) {
                if ($category == $constantValue->category) {
                    if ($keyField) {
                        $assoc[$constantValue->$keyField] = $constantValue;
                    } else {
                        $assoc[] = $constantValue;
                    }
                }
            }
            $data = $assoc;
        }
        return $data;
    }
    
    /**
     * Get all option of a category.
     * This gets an array that is used to create an drop down list, or check box list.
     *
     * @param string $category Category to get options.
     * @param string $keyField Attribute of ConstantValue that its value is used as key of return array.
     * @param string $valueField Attribute of ConstantValue that its value is used as value of return array.
     * @param array $initialValue Initial values.
     * @return array
     */
    public static function getListOptions($category, $keyField = 'value', $valueField = 'name', $initialValue = [])
    {
        $result = $initialValue;
        foreach (self::getAllRecords($category, $keyField) as $key => $constantValue) {
            $result[$key] = $constantValue->$valueField;
        }
        return $result;
    }
    
    /**
     * Get a value defined by category and code.
     * @param string $category
     * @param string $code
     * @param string $field
     * @param mixed $defaultValue
     * @param boolean $throwError Throw error or not if value is not found.
     * @throws \Exception
     * @return mixed
     */
//     public static function getFieldValue($category, $code, $field, $defaultValue = NULL, $throwError = TRUE)
//     {
//         $result = $defaultValue;
//         $records = self::getAllRecords($category, 'code');
//         if (!isset($records[$code])) {
//             if ($throwError) {
//                 throw new \Exception("ConstantValue($cateogry, $code) does not exist.");
//             }
//         } else {
//             $result = $records[$code]->$field;
//         }
//         return $result;
//     }
    
//     public static function getValue($category, $code)
//     {
//         $constantValues = self::getAllOptions($category, 'value', 'name');
//         return $constantValues[$value];
//     }
    
    public static function getName($category, $value)
    {
        $constantValues = self::getListOptions($category, 'value', 'name');
        return $constantValues[$value];
    }
}