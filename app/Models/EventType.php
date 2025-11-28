<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $identifier
 * @property ?string $description
 * @property string $background_color
 * @property string $text_color
 */
class EventType extends Model
{
    public const string IDENTIFIER = 'identifier';

    protected $primaryKey = 'identifier';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'event_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'identifier',
        'description',
        'background_color',
        'text_color',
    ];
}
