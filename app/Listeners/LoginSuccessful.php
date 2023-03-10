<?php

namespace App\Listeners;

use App\Actions\StoreAuditLog;
use Illuminate\Auth\Events\Login;

class LoginSuccessful
{
    /**
     * Create the event listener.
     */
    public function __construct(private StoreAuditLog $storeAuditLog)
    {

    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $data = [
            'event_name' => 'Login',
            'description' => 'Login successful',
        ];
        $this->storeAuditLog->handle($data);
    }
}
