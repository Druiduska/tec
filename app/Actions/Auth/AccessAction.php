<?php

namespace App\Actions\Auth;

use App\Models\Auth\Access;
use Illuminate\Support\Carbon;

class AccessAction
{
    /**
     * @var Access model Access
     */
    protected Access $access;

    /**
     * @param int $id
     */
    public function __construct(protected int $id)
    {
        $this->access=new Access();
    }

    /**
     * @return void
     */
    public function onLogin()
    {
        $this->access->user_id=$this->id;
        $this->access->login_at=Carbon::now();
        $this->access->save();
    }

    /**
     * @return void
     */
    public function onAccess()
    {
        $access = $this->access->where('user_id', $this->id)->latest('login_at')->first();
        $access->update(['access_at' => Carbon::now()]);
    }
}