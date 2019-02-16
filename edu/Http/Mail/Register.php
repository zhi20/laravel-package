<?php
/**
 * ====================================
 *
 * ====================================
 * Author: ASUS
 * Date: 2018/8/15 16:21
 * ====================================
 * Project: SDJY
 * File: Register.php
 * ====================================
 */

namespace App\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = date('Y年m月d日');
        $project_name = config('app.project_name');
        $code  = $this->data['code'];
        return $this->from('server@zhi20.com')
            ->view('emails.userRegister')
            ->subject(config('app.project_name') . '--邮箱认证')
            ->with([
                'project_name' => $project_name,
                'code' => $code,
                'date' => $date
            ]);
    }
}
