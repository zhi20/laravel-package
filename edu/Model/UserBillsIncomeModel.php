<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserBillsIncomeModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $aims_id
 * @property string $table
 * @property int $table_id
 * @property float $amount
 * @property string $remark
 * @property int $type
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBillsIncomeModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserBillsIncomeModel extends BaseModel
{
    protected $table = 'user_bills_income';


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