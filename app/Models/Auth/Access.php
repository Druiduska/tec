<?php

namespace App\Models\Auth;

use App\Models\Staff\Staff;
use Illuminate\Database\Eloquent\Model;
use App\Factories\Auth\AccessFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Access extends Model
{
    use HasFactory;

    protected $table = 'access';

    protected $fillable = [
        'login_at',
        'access_at',
        'user_id',
    ];
    protected $casts = [
        'login_at' => 'datetime',
        'access_at' => 'datetime',
        'user_id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'user_id','user_id');
    }
    /**
     * Create a new factory instance for the model
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AccessFactory::new();
    }
}
