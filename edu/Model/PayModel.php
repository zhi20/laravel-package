<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model PayModel
 *
 * @property int $id
 * @property string $text
 * @property string $code
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 * @property string $attributes
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\PayModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class PayModel extends BaseModel
{
    protected $table = 'pay';

    const WECHATPAY =   'wechatPay';
    const ALIPAY    =      'aliPay';

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