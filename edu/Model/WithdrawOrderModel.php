<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model WithdrawOrderModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $withdraw_code
 * @property string $order_sn
 * @property string $out_order_sn
 * @property string $card_number
 * @property float $amount
 * @property string $remark
 * @property int $locked
 * @property int $complete_time
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $check
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WithdrawOrderModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class WithdrawOrderModel extends BaseModel
{
    protected $table = 'withdraw_order';


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