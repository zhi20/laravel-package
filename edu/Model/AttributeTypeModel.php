<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model AttributeTypeModel
 *
 * @property int $id
 * @property string $text
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AttributeTypeModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class AttributeTypeModel extends BaseModel
{
    protected $table = 'attribute_type';
//    protected $dateFormat = 'U';

    /**
     * 获取对应数据库链接对象
     * @eg 用于分库分表时获取数据所在的数据库对象
     * @param $id
     * @return object
     */
    /*public static function getShardingConnection($id)
    {
        $mod = $id % 4;
        $model = '\App\Model\Mysql2\User_'.$mod.'Model';

        return new $model;
    }*/

     public function filter($data)
    {
        //

    }


}