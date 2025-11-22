<?php declare(strict_types=1);

namespace App\Models;

use DateMalformedStringException;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $event_type_id
 * @property int $assigned_user_id
 * @property int $created_by_user_id
 * @property string $title
 * @property string $description
 * @property string $start_date_time
 * @property string $end_date_time
 * @property EventType $eventType
 * @property User $assignedUser
 * @property User $createdByUser
 */
class Event extends Model
{
    public const string START_DATE_TIME = 'start_date_time';

    public const string END_DATE_TIME = 'end_date_time';

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
        'start_date_time',
        'end_date_time',
    ];

    /**
     * @return Collection<int, Event>
     */
    public static function getBetweenDates(DateTimeImmutable $startDate, DateTimeImmutable $endDate): Collection
    {

        $startDateFilter = $startDate->setTime(0, 0, 0);
        $endDateFilter = $endDate->setTime(23, 59, 59);

        return self::query()
            ->whereBetween(self::START_DATE_TIME, [$startDateFilter, $endDateFilter])
            ->orWhereBetween(self::END_DATE_TIME, [$startDateFilter, $endDateFilter])
            ->get();
    }

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getStartDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->start_date_time);
    }

    /**
     * @throws DateMalformedStringException
     */
    public function getEndDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->end_date_time);
    }
}
