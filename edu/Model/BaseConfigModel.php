<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model BaseConfigModel
 *
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $title
 * @property int $group
 * @property string $extra
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 * @property string $value
 * @property int $orderby
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\BaseConfigModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class BaseConfigModel extends BaseModel
{
    protected $table = 'base_config';


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

    public function filter($params = [])
    {
        $where = [];
        if (isset($params['search_type']) && $params['search_type'] > -1) {
            $where['type'] = $params['search_type'];
        }
        if (isset($params['search_group']) && $params['search_group'] > -1) {
            $where['group'] = $params['search_group'];
        }
        if(!empty($params['keyword'])){
            $where[] =[[
                ['title', 'like', "%{$params['keyword']}%"],
                ['name', 'like', "%{$params['keyword']}%",'or']
            ]
            ];
        }
        $this->getQueryModel()->where($where);
        return $this;
    }
}