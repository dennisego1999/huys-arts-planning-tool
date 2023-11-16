<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Carbon\CarbonImmutable;
use Inertia\Inertia;

class CalendarController extends Controller
{

    private CalendarService $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        // Set calendar service
        $this->calendarService = $calendarService;
    }

    public function index($date = null)
    {
        // Use today by default
        $fallbackDate = now();

        // Get the current date
        $currentDate = CarbonImmutable::parse($date ?: $fallbackDate->format('Y-m-d'));

        // Prevent navigating to previous dates
        if ($currentDate->isBefore(now()->startOfWeek())) {
            return to_route('whereabouts.index');
        }

        return Inertia::render('Dashboard/Calendar/Index', [
            'weekInfo' => $this->calendarService->getWeekInfo($date),
        ]);
    }
}
