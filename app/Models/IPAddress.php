<?php

namespace App\Models;

use App\Traits\IPAddressTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPAddress extends Model
{
    use HasFactory;
    use IPAddressTrait;

    protected $table = "ip_addresses";
    protected $fillable = ['label', 'ip_address', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function ipAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->convertToReadable($value),
            set: fn ($value) => $this->convertToBinary($value),
        );
    }
}
