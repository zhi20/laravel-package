<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model UserModel
 *
 * @property int $id
 * @property string $email
 * @property string $headimg
 * @property string $username
 * @property string $nickname
 * @property int $phone
 * @property string $birthday
 * @property int $sex
 * @property string $desc
 * @property string $pay_password
 * @property string $salt
 * @property int $status
 * @property int $is_wechat
 * @property int $is_qq
 * @property int $is_weibo
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $area
 * @property int $last_login_ip
 * @property int $last_login_time
 * @property int $register_ip
 * @property string $created_at
 * @property string $updated_at
 * @property int $locked
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserModel extends BaseModel
{
    protected $table = 'user';


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

    public function filter($data){
        $query = $this->getQueryModel();
        if(isset($data['id'])){
            $query->where('id',$data['id']);
        }
    }
}