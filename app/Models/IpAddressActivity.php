<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpAddressActivity extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function ip_addres(): BelongsTo
    {
        return $this->belongsTo(IpAddress::class, "todo_id");
    }
}
