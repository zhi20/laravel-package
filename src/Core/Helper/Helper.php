<?php


/**
 * 加载辅助函数
 * @param string $class_name
 * @return bool
 */
if (!function_exists('load_helper')) {
    function load_helper($helper_name)
    {
        return app()->make('jiaoleo_helper')->load_helper($helper_name);
    }
}

/**
 * 返回错误
 * @param string $error_msg
 * @param string $error_id
 * @param int $status_code
 * @return object
 */
if (!function_exists('response_error')) {
    function response_error($error_msg, $error_id = 'ERROR', $status_code = 400)
    {
        throw new \App\Exceptions\ApiException($error_msg, $error_id, $status_code);
    }
}

/**
 * 设置保存的数据
 * @param Object $model
 * @param array $data
 * @return object
 */
if (!function_exists('set_save_data')) {
    function set_save_data($model, $data)
    {
        foreach ($data as $key => $v) {
            $model->$key = $v;
        }

        return $model;
    }
}

/**
 * 分页行数
 * @param int $limit
 * @param array $option
 * @return int $per_page
 */
if (!function_exists('get_per_page')) {
    function get_per_page($limit = 15, $option = [15, 50, 100, 200])
    {
        $per_page = request()->query->get('per_page', $limit);

        if (!preg_match('/^\+?[1-9]\d*$/', $per_page)) {
            return $limit;
        }

        if (!in_array($per_page, $option)) {
            return $limit;
        }

        return (int)$per_page;
    }
}

/**
 * 获取运行时间
 * @param float $start_time
 * @param float $end_time
 * @return float 时间(ms)
 */
if (!function_exists('get_run_time')) {
    function get_run_time($start_time = 0, $end_time = 0)
    {
        //开始时间为0,则默认为程序启动时间
        if ($start_time == 0) {
            $start_time = request()->server('REQUEST_TIME_FLOAT');
        }

        //结束时间为0,则默认为当前时间
        if ($end_time == 0) {
            $end_time = microtime(true);
        }

        return number_format(($end_time - $start_time) * 1000, 2);
    }
}

/**
 * 获取运行时间
 * @param float $start_time
 * @param float $end_time
 * @return float 时间(ms)
 */
if (!function_exists('report_to_sentry')) {
    function report_to_sentry($exception)
    {
        //如果存在sentry类且有配置sentry,则发送
        if (class_exists('\Sentry\SentryLaravel\SentryLaravel')
            && !empty(config('sentry.dsn'))
        ) {
            app('sentry')->captureException($exception);
        }

        return true;
    }
}