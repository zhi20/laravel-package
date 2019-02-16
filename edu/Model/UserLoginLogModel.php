<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserLoginLogModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $login_ip
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserLoginLogModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserLoginLogModel extends BaseModel
{
    protected $table = 'user_login_log';


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