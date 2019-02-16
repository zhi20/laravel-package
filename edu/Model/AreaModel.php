<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model AreaModel
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $level
 * @property string $letter
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\AreaModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class AreaModel extends BaseModel
{
    protected $table = 'area';

    const CREATED_AT = null;

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

    public function grid($params = [])
    {
        if(empty($params['type'])){
            $subQuery =\DB::table('area as s')->whereRaw('s.parent_id=area.id')->selectRaw('count(s.id)')->toSql();
//            $subQuery = $this->alias('s')->where('s.pid=b.id')->fetchSql(true)->count();
            $where = [];
            if (!empty($params['id'])) {
                $where['area.parent_id'] = (int)$params['id'];
            } else {
                $where['area.parent_id'] = 0;
            }
            $this->getQueryModel()->select([
                "*",
                \DB::raw("({$subQuery}) as have_children")

            ])
                ->where($where);
        }else {
            if (!empty($params['id'])) {
                $where['area.parent_id'] = (int)$params['id'];
            } else {
                $where['area.parent_id'] = 0;
            }

            $this->getQueryModel()->select([
                "*"
                ])
                ->where($where)
                ->orderBy('parent_id');
        }
        $data = $this->getAll();
        return $data;
    }
}