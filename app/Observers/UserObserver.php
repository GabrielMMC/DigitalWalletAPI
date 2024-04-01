<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Request;

class UserObserver
{
    public function created(User $user)
    {
        $this->logUserAction($user, 'created');
    }

    public function updated(User $user)
    {
        $this->logUserAction($user, 'updated');
    }

    public function deleted(User $user)
    {
        $this->logUserAction($user, 'deleted');
    }

    protected function logUserAction(User $user, $action)
    {
        $ip = Request::ip();
        UserLog::create([
            ...$user->toArray(),
            'user_id' => $user->id,
            'action' => $action,
            'ip_address' => $ip,
            'platform' => 'WEB'
        ]);
    }
}
