<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserAddressModel
 *
 * @property int $address_id
 * @property int $user_id
 * @property string $consignee
 * @property int $province
 * @property int $city
 * @property int $district
 * @property int $town
 * @property string $address
 * @property string $zipcode
 * @property string $tel
 * @property string $mobile
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property int $default
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserAddressModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserAddressModel extends BaseModel
{
    protected $table = 'user_address';


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