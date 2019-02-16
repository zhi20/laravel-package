<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model UserAuthPasswordModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $password
 * @property string $salt
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthPasswordModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserAuthPasswordModel extends BaseModel
{
    protected $table = 'user_auth_password';


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