<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_type_id',
        'assigned_user_id',
        'created_by_user_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];
}
