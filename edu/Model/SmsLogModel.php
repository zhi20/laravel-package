<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model SmsLogModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $admin_id
 * @property int $phone
 * @property string $content
 * @property int $type
 * @property int $send_result
 * @property string $error_msg
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\SmsLogModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class SmsLogModel extends BaseModel
{
    protected $table = 'sms_log';


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