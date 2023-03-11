<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPAddress extends Model
{
    use HasFactory;
    protected $table = "ip_addresses";
    protected $fillable = ['label', 'ip_address', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
