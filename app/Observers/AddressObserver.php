<?php

namespace App\Observers;

use App\Models\Address;
use Illuminate\Support\Str;

class AddressObserver
{
    /**
     * Handle the Address "creating" event.
     *
     * @param  \App\Models\Address  $address
     * @return void
     */
    public function creating(Address $address)
    {
        $address->uuid = (string) Str::uuid();
    }
}
