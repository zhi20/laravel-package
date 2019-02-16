<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model WithdrawModel
 *
 * @property int $id
 * @property string $text
 * @property string $code
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 * @property string $attributes
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class WithdrawModel extends BaseModel
{
    protected $table = 'withdraw';


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