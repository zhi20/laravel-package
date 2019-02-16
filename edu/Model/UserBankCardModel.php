<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserBankCardModel
 *
 * @property int $id
 * @property string $text
 * @property int $user_id
 * @property string $card_number
 * @property int $type
 * @property int $default
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserBankCardModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserBankCardModel extends BaseModel
{
    protected $table = 'user_bank_card';


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