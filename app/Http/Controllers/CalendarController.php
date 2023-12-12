<?php

namespace App\Http\Controllers;

use App\Actions\CalendarEventCreateAction;
use App\Actions\CalendarEventDestroyAction;
use App\Http\Requests\StoreCalendarEventRequest;
use App\Models\CalendarEvent;
use App\Models\User;
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
            return to_route('calendar.index');
        }

        return Inertia::render('Dashboard/Calendar/Index', [
            'weekInfo' => $this->calendarService->getWeekInfo($date),
            'users' => User::all(),
        ]);
    }

    public function store(StoreCalendarEventRequest $request, CalendarEventCreateAction $calendarEventCreateAction)
    {
        $formData = $request->validated();
        $calendarEventCreateAction->handle($formData);

        return redirect()->back()->with('success', trans('spa.pages.calendar.event_added'));
    }

    public function destroy(CalendarEventDestroyAction $calendarEventDestroyAction, CalendarEvent $calendarEvent)
    {
        // Authorize
        $this->authorize('delete', CalendarEvent::class);

        // Delete the event
        $calendarEventDestroyAction->handle($calendarEvent);

        // Redirect back
        return redirect()->back()->with('success', trans('spa.pages.calendar.deleted_event'));
    }
}
