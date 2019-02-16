<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserAuthOauthModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $nickname
 * @property string $headimg
 * @property int $oauth_type
 * @property string $id1
 * @property string $id2
 * @property string $id3
 * @property string $id4
 * @property string $access_token
 * @property string $refresh_token
 * @property int $expires_time
 * @property string $info
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAuthOauthModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserAuthOauthModel extends BaseModel
{
    protected $table = 'user_auth_oauth';


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