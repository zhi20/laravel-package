<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseAdminLogModel
 *
 * @property int $id
 * @property int $user_id
 * @property string $module_name
 * @property string $controller_name
 * @property string $action_name
 * @property string $note
 * @property string $params
 * @property string $created_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseAdminLogModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseAdminLogModel extends BaseModel
{
    protected $table = 'base_admin_log';

    const UPDATED_AT = null;
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
//$where[] =[
//[
//['user_name', 'like', "%{$params['keyword']}%",'or'],
//                        ['note', 'like', "%{$params['keyword']}%"],
//                    ]
//                ];

    public function filter($params)
    {
        $where = [];
        if (!empty($params['keyword'])) {
                $where[] =[
                    'note', 'like', "%{$params['keyword']}%"
                ];
        }
        if(!empty($params['user_id'])){
            $where['user_id'] = $params['user_id'];
        }
        if (!empty($params['module'])) {
            $where['module_name'] = $params['module'];
        }
        if (!empty($params['controller'])) {
            $where['controller_name'] = $params['controller'];
        }
        if (!empty($params['method']) && $params['method'] != '*') {
            $where['action_name'] = $params['method'];
        }
        $this->getQueryModel()->where($where);
        return $this;
    }
}