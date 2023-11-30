<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DateInterval;
use DatePeriod;

class CalendarService
{
    public function getWeekInfo(string $date = null): array
    {
        // Build out the week info
        [$currentWeekLabel, $urls, $period] = $this->getWeekPeriod($date);

        // Prepare our for list of dates
        $dates = collect();

        foreach ($period as $p) {
            // Get current date
            $currentDate = CarbonImmutable::now()->toDateString();

            // Format the current date
            $date = $p->format('Y-m-d');

            // Get the name of the day
            $day = strtolower($p->format('l'));

            // Get the events for the date
            $events = auth()->user()
                ->calendarEvents()
                ->where('starts_at', 'like', $date . '%')
                ->with(['eventable'])
                ->get();

            $dates->push([
                'date' => $date,
                'day_short' => $p->format('D'),
                'day_extra_short' => substr($p->format('D'), 0, 1),
                'day_full' => $day,
                'day_full_formatted' => ucfirst($day),
                'day_number' => $p->format('d'),
                'is_current' => $date === $currentDate,
                'events' => $events
            ]);
        }

        return [
            'current_week_label' => $currentWeekLabel,
            'urls' => $urls,
            'dates' => $dates
        ];
    }

    private function getWeekPeriod(string $date = null): array
    {
        // Get the date as fall back without a specific date
        $fallbackDate = now();

        // Get the requested date or fall back to today
        $date = CarbonImmutable::createFromFormat('Y-m-d', $date ?: $fallbackDate->format('Y-m-d'));

        // Get the start and end dates for this week
        $startDate = $date->startOfWeek();
        $endDate = $date->endOfWeek(CarbonInterface::SUNDAY);

        // Get the previous and next weeks for navigation
        $previousWeek = $date->subWeek()->startOfWeek();
        $nextWeek = $date->addWeeks()->startOfWeek();

        // Decide we should interval between dates
        $dateInterval = DateInterval::createFromDateString('1 day');

        // Build the default URLs
        $urls = [
            'previous_week_url' => route('calendar.index', ['date' => $previousWeek->format('Y-m-d')]),
            'this_week_url' => route('calendar.index', ['date' => now()->format('Y-m-d')]),
            'next_week_url' => route('calendar.index', ['date' => $nextWeek->format('Y-m-d')])
        ];

        // Remove the previous week URL if it is in the past
        if ($previousWeek->isBefore(now()->startOfWeek())) {
            unset($urls['previous_week_url']);
        }

        return [
            $this->getCurrentWeekLabel($startDate, $endDate), // Current week label
            $urls, // The pagination URLs
            new DatePeriod($startDate, $dateInterval, $endDate) // The date range
        ];
    }

    private function getCurrentWeekLabel(CarbonImmutable $startDate, CarbonImmutable $endDate): string
    {
        // Get the start date
        $startDateLabel = $startDate->format('d');

        // Check if the start date is in a different month
        if ($startDate->month !== $endDate->month) {
            $startDateLabel .= ' ' . $startDate->shortEnglishMonth;
        }

        // Combine the two dates
        return $startDateLabel . ' - ' . $endDate->format('d') . ' ' . $endDate->shortEnglishMonth;
    }
}
