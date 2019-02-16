<?php
namespace App\Logic\Admin;


use App\Logic\BaseLogic;
use App\Model\BaseConfigModel;
use App\Support\ConfigSupport;
use App\Support\LogSupport;

class ConfigLogic extends BaseLogic
{
    protected $modelName = 'BaseConfigModel';


    public function _after_save()
    {
        ConfigSupport::cacheConfig();
    }

    public function _after_delete()
    {
        ConfigSupport::cacheConfig();
    }

    public function format($data)
    {
        $config_group_list = ConfigSupport::getConfigGroup();
        $config_type_list = ConfigSupport::getConfigType();
        if (!empty($data['rows'])) {
            foreach ($data['rows'] as &$row) {
                $row['group_name'] = empty($config_group_list[$row['group']]) ? trans('base.system') : $config_group_list[$row['group']];
                $row['type_name'] = $config_type_list[$row['type']];
            }
        }
        return $data;
    }


    public function getList()
    {
        $config = [];
        $list = BaseConfigModel::get()->toArray();
        if (!empty($list)) {
            foreach ($list as $row) {
                if (empty($row['group']) && !in_array($row['name'], array('CONFIG_GROUP_LIST', 'CONFIG_TYPE_LIST'))) {
                    if(strrpos($row['name'],'.')){
                        $name = explode(".",$row['name']);
                        $row['group'] = $name[0];
                    }else{
                        $config[$row['name']] = unserialize($row['value']);
                    }
                }
                $config[$row['group']][] = $row;
            }
        }
        return $config;
    }

    public function setting($params = [])
    {
        if (empty($params) || !is_array($params)) {
            $this->error = trans('base.save') . trans('base.error');
            return false;
        }
        foreach ($params as $name => $value) {
            BaseConfigModel::where(['name' => $name])->update(['value' => $value]);
        }
        ConfigSupport::cacheConfig();
        $this->msg = trans('base.save') . trans('base.success');
        LogSupport::adminLog(trans('base.system_config') . trans('base.edit') . trans('base.success'));
        return true;
    }


}