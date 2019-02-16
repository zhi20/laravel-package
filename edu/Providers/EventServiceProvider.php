<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AdminLogEvent' => [                                  //后台操作日志
            'App\Listeners\AdminLogEventListener',
        ],
        'App\Events\ErrorLogEvent' => [                                 //异常日志
            'App\Listeners\ErrorLogEventListener',
        ],
        'App\Events\BillsIncomeEvent' => [                              //用户收入账单
            'App\Listeners\BillsIncomeEventListener',
        ],
        'App\Events\BillsExpensesEvent' => [                            //用户支出账单
            'App\Listeners\BillsExpensesEventListener',
        ],
        'App\Events\PayLogEvent' => [                                   //支付日志
            'App\Listeners\PayLogEventListener',
        ],
        'App\Events\SmsNotifyEvent' => [                                //短信通知事件
            'App\Listeners\SmsNotifyEventListener',
        ],
        'App\Events\WechatNotifyEvent' => [                                //微信通知事件
            'App\Listeners\WechatNotifyEventListener',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
