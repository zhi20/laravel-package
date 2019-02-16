<?php
namespace App\Model;

use App\Model\Base\BaseModel;
use Illuminate\Database\Eloquent\Model;


/**
 * Model GoodsModel
 *
 * @property int $id
 * @property string $text
 * @property string $goods_sn
 * @property int $category_id
 * @property int $goods_type_id
 * @property string $thumb
 * @property string $description
 * @property float $price
 * @property float $market_price
 * @property string $content
 * @property string $attributes
 * @property string $process_module
 * @property int $locked
 * @property string $created_at
 * @property string $updated_at
 * @property int $orderby
 * @property int $recommend_id
 *
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel leftJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel rightJoin($table, $first, $operator = null, $second = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel get($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel find($id, $columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel first($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel select($columns = ['*'])
 * @method static \Illuminate\Database\Query\Builder | \App\Model\GoodsModel orderBy($column, $direction = 'asc')
 * @package App\Model
 */
class GoodsModel extends BaseModel
{
    protected $table = 'goods';


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
        if(isset($data['id'])){                             //商品id
            $query->where('id',$data['id']);
        }
        if(isset($data['goods_sn'])){                       //商品编号
            $query->where('goods_sn',$data['goods_sn']);
        }
        if(isset($data['category_id'])){                    //分类id
            $query->where('category_id',$data['category_id']);
        }
        if(isset($data['goods_type_id'])){                  //商品分类id
            $query->where('goods_type_id',$data['goods_type_id']);
        }
        if(isset($data['recommend_id'])){                   //推荐id
            $query->where('recommend_id',$data['recommend_id']);
        }
        if(isset($data['locked'])){                   //是否可用
            $query->where('locked',$data['locked']);
        }
        if(isset($data['text'])){                           //商品名称
            $query->where('text',$data['text']);
        }
        if(isset($data['keyword'])){                           //商品名称查询
            $query->where( 'text', 'like', "%{$data['keyword']}%");
        }

    }
}