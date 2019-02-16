<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model SpreadModel
 *
 * @property int $id
 * @property string $text
 * @property string $code
 * @property int $locked
 * @property string $attributes
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SpreadModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class SpreadModel extends BaseModel
{
    protected $table = 'spread';


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

}