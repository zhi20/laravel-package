<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model WechatUserModel
 *
 * @property int $id
 * @property int $wechat_account_id
 * @property string $openid
 * @property string $unionid
 * @property string $nickname
 * @property int $sex
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property string $remark
 * @property int $subscribe
 * @property int $groupid
 * @property string $tagid_list
 * @property string $created_at
 * @property string $updated_at
 * @property int $subscribe_time
 * @property int $cancel_time
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\WechatUserModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class WechatUserModel extends BaseModel
{
    protected $table = 'wechat_user';


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