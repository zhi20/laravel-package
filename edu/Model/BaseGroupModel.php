<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseGroupModel
 *
 * @property int $id
 * @property string $text
 * @property int $pid
 * @property string $remark
 * @property int $locked
 * @property int $orderby
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseGroupModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseGroupModel extends BaseModel
{
    protected $table = 'base_group';


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