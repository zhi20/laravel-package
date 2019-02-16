<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseRoleModel
 *
 * @property int $id
 * @property string $text
 * @property int $pid
 * @property string $remark
 * @property int $locked
 * @property int $orderby
 * @property string $menu_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseRoleModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseRoleModel extends BaseModel
{
    protected $table = 'base_role';

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