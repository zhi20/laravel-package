<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Model;


/**
 * Model UserCapitalModel
 *
 * @property int $id
 * @property int $user_id
 * @property float $balance
 * @property int $integral
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserCapitalModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserCapitalModel extends BaseModel
{
    protected $table = 'user_capital';


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