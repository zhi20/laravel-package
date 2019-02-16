<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseAdminModel
 *
 * @property int $user_id
 * @property string $user_name
 * @property string $real_name
 * @property string $password
 * @property int $sex
 * @property string $session_key
 * @property int $locked
 * @property int $group_id
 * @property int $role_id
 * @property string $menu_id
 * @property int $is_open
 * @property int $create_time
 * @property int $update_time
 * @property int $last_login_time
 * @property int $now_login_time
 * @property string $last_login_ip
 * @property string $now_login_ip
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseAdminModel extends BaseModel
{

    protected $primaryKey = 'user_id';

    protected $table = 'base_admin';


    function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    public function role(){
        return $this->hasOne('App\Model\BaseRoleModel','id','role_id');
    }

    public function group(){
        return $this->hasOne('App\Model\BaseGroupModel','id','group_id');
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $field
     */
    public function joinRole($query, $field = [] )
    {
        $query->join('base_role','id','role_id')->addSelect($field);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array $field
     */
    public function joinGroup($query, $field = [])
    {
        $query->join('base_group','id','group_id')->addSelect($field);
    }

}