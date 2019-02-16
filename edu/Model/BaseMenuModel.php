<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseMenuModel
 *
 * @property int $id
 * @property string $text
 * @property int $pid
 * @property string $module
 * @property string $controller
 * @property string $method
 * @property string $other_method
 * @property int $display
 * @property string $icon
 * @property int $orderby
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseMenuModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseMenuModel extends BaseModel
{
    protected $table = 'base_menu';


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