<?php
namespace App\Logic;

use App\Support\LoginSupport;
use App\Support\LogSupport;
use App\Util\Traits\Validate;

class BaseLogic
{
    use Validate;
    protected $modelName;

    protected $model;

    protected $data;                                //参数

    protected $error = '';                               //错误信息

    protected $info = '';                                //返回信息

    protected $rule;                                //

    //
    public function __construct()
    {
        if(is_null($this->modelName)){
            $class = basename(str_replace("\\","/",get_class($this)) ) ;
            $this->modelName = str_replace('Logic','Model',$class);
        }
        $this->data = request()->all();
    }

    /**
     * @param string $modelName
     * @param mixed ...$args
     * @return \APP\Model\Base\BaseModel
     */
    public function getModel($modelName = '', ...$args){
        if(!empty($modelName) && ($modelName !== $this->modelName)){
            $this->modelName = $modelName;
            $this->model = null;
        }
        if(empty($this->model)){
            $modelName = "\App\Model\\".$this->modelName;
            $this->model = new $modelName(...$args);
        }
        return $this->model;
    }

    /** 获取成功信息 */
    public function getInfo($default = ''){
        if(empty($this->info)){
            $this->info = $default;
        }
        return $this->info;
    }

    /** 获取错误 */
    public function getError($default = ''){
        if(empty($this->error)){
            $this->error = $default;
        }
        return $this->error;
    }

    /** 设置参数 */
    public function setData($key, $value=''){
        if(is_array($key)){
            $this->data = $key;
        }else{
            $this->data[$key] = $value;
        }
    }

    /**
     * 获取数据
     * @param string $name
     * @param null $default
     * @return array|mixed
     */
    public function getData($name = NULL, $default = null)
    {
        return is_null($name) ? $this->data : (isset($this->data[$name]) ? $this->data[$name] : $default);
    }

    /** 获取列表 */
    public function lists($isTree = false){
        $model = $this->getModel();
        if (method_exists($model, 'filter')) {
            $model->filter($this->data);
        }
        if (method_exists($model, 'grid') && $isTree == false) {
            $data = $model->grid($this->data);
        } else {
            $data = $model->getAll();
        }
        if (method_exists($this, 'format')) {
            $data = $this->format($data);
        }
        if ($data !== false) {
            if (method_exists($this, '_after_lists')) {
                $after = $this->_after_lists($data);
                if(!is_null($after)){
                    return $after;
                }
            }
        }
        $selected = isset($this->data['selected']) ? $this->data['selected'] : '';
        $type = isset($this->data['type']) ? $this->data['type'] : '';
        if ($isTree) {
            tree($data, $selected, $type);
        }
        return $data;
    }

    /** 保存 */
    public function save()
    {
        $model = $this->getModel();
        if (method_exists($this, '_before_save')) {
            $before = $this->_before_save();
            if(!is_null($before)){
                return $before;
            }
        }
        $pk = $model->getKeyName();
        if (isset($this->data[$pk]) && $this->data[$pk]) {
            $this->data['update_by'] = LoginSupport::getUserId();
            $model->exists = true;
        } else {
            $this->data['create_by'] =  LoginSupport::getUserId();

        }
        if (method_exists($model, 'verification')) {
            //数据库自定义数据验证
            $result = $model->verification($this->data);
            if(!is_null($result)){
                $this->error = $result;
                return false;
            }
        }
        //保存
        $model->setValue($this->data);
        $result = $model->save();
        if (empty($this->data[$pk])) {
            $this->data[$pk] = $model->$pk;
        }

        if ($result !== false) {
            //调用保存后需要处理的方法
            if (method_exists($this, '_after_save')) {
                $after = $this->_after_save();
                if(!is_null($after)){
                    return $after;
                }
            }
            $this->info = "修改成功";
            LogSupport::adminLog(sprintf(trans('base.edit_data'), $this->data[$pk]) . trans('base.success'));          //保存日志
            return true;
        } else {
            $this->error = "fail";
            LogSupport::adminLog(sprintf(trans('base.edit_data'), $this->data[$pk]) . trans('base.error'));     //保存日志
            return false;

        }
    }

    public function delete()
    {
        if (method_exists($this, '_before_delete')) {
            $before = $this->_before_delete();
            if(!is_null($before)){
                return $before;
            }
        }
        $model = $this->getModel();
        $pk = $model->getKeyName();
        $query = $model->getQueryModel();
        if (!empty($this->data[$pk])) {
            $query->whereIn($pk,explode(',',$this->data[$pk]));
        }

        $result = $query->delete();
        if ($result) {
            if (method_exists($this, '_after_delete')) {
                $after = $this->_after_delete();
                if(!is_null($after)){
                    return $after;
                }
            }
            $this->info = '删除成功';
            LogSupport::adminLog(sprintf(trans('base.delete_data'), $this->data[$pk]) . trans('base.success'));     //保存日志

            return true;
        } else {
            $this->error = '删除失败';
            LogSupport::adminLog(sprintf(trans('base.delete_data'), $this->data[$pk]) . trans('base.error'));     //保存日志
            return false;
        }
    }

    public function lock()
    {
        if (empty($this->data)) {
            $this->error = trans('base.select_node');
            return false;
        }
        if (method_exists($this, '_before_lock')) {
            $before = $this->_before_lock();
            if(!is_null($before)){
                return $before;
            }
        }

        $model = $this->getModel();
        $pk = $model->getKeyName();
        $query = $model->getQueryModel();
        if (!empty($this->data[$pk])) {
            $query->whereIn($pk,explode(',',$this->data[$pk]));
            unset($this->data[$pk]);
        }
        $result = $query->update($this->data);
        if ($result) {
            if (method_exists($this, '_after_lock')) {
                $after = $this->_after_lock();
                if(!is_null($after)){
                    return $after;
                }
            }
            $this->info = '修改成功';
            LogSupport::adminLog(sprintf(trans('base.edit_data'), $this->data[$pk]) . trans('base.success'));     //保存日志
            return true;
        } else {
            $this->error =  '修改失败';
            LogSupport::adminLog(sprintf(trans('base.edit_data'), $this->data[$pk]) . trans('base.error'));     //保存日志
            return false;
        }
    }

    /**
     *  下拉列表
     */
    public function select(){
        if (method_exists($this, '_before_select')) {
            $before = $this->_before_select();
            if(!is_null($before)){
                return $before;
            }
        }
        $model = $this->getModel();
        if (method_exists($model, 'filter')) {
            $model->filter($this->data);
        }
        $field = [];
        if(isset($this->data['field'])){
            $field = $this->data['field'];
        }
        $data = $model->getAll([],$field);
        if (method_exists($this, '_after_select')) {
            $data = $this->_after_select($data);
        }
        return $data;
    }

    /** 获取详情 */
    public function info(){
        if (method_exists($this, '_before_info')) {
            $before = $this->_before_info();
            if(!is_null($before)){
                return $before;
            }
        }
        $model = $this->getModel();
        if (method_exists($model, 'filter')) {
            $model->filter($this->data);
        }
        $data =$model->getQueryModel()->first()->toArray();
        if (method_exists($this, '_after_info')) {
            $data = $this->_after_info($data);
        }
        return $data;
    }

}