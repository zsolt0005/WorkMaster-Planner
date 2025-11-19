<?php declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

final class DateEntry
{
    public function __construct(
        private readonly DateTimeImmutable $dateTime,
        private ?DateTimeImmutable $todayDateTime = null,
    ) {
        $this->todayDateTime ??= new DateTimeImmutable('today');
    }

    public function getDate(): string
    {
        return $this->dateTime->format('Y-m-d');
    }

    public function getLabel(): string
    {
        return $this->dateTime->format('l');
    }

    public function getMonth(): string
    {
        return $this->dateTime->format('M');
    }

    public function getDay(): string
    {
        return $this->dateTime->format('j');
    }

    public function isWeekend(): bool
    {
        return $this->dateTime->format('N') >= 6;
    }

    public function isToday(): bool
    {
        return $this->dateTime->format('Y-m-d') === $this->todayDateTime->format('Y-m-d');
    }
}
