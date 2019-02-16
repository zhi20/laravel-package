<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Base\BaseModel;


/**
 * Model UserSearchGoodsLinkedModel
 *
 * @property int $id
 * @property int $user_id
 * @property int $goods_id
 * @property int $category_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\UserSearchGoodsLinkedModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class UserSearchGoodsLinkedModel extends BaseModel
{
    protected $table = 'user_search_goods_linked';


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

    public function filter($params){
        $query = $this->getQueryModel();
        if(isset($params['user_id'])){
            $query->where('user_id',$params['user_id']);
        }
        if(isset($params['category_id'])){
            $query->where('category_id',$params['category_id']);
        }
        if(isset($params['keyword'])){
            $query->where('keyword',$params['keyword']);
        }
    }
}