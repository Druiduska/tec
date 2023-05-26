<?php

namespace App\Models\Staff;


use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use App\Factories\Staff\StaffFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'id',
        'family',
        'name',
        'patronymic',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'family' => 'string',
        'name' => 'string',
        'patronymic' => 'string',

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new factory instance for the model
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return StaffFactory::new();
    }
}
