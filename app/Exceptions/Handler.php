<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        // Default Laravel handling
        $response = parent::render($request, $e);

        // Return the default Laravel handling in testing environments
        if (app()->environment(['local', 'staging'])) {
            return $response;
        }

        // Abort outside Inertia requests or without a route
        if (! $request->inertia() || !$request->route()) {
            return $response;
        }

        // Get the status code of the HTTP Request
        $status = $response->status();

        // Let redirects happen
        if ($status === 302) {
            return $response;
        }

        // Get the correct message based on the HTTP Status
        $message = $this->getErrorMessage($status);

        return redirect()
            ->back()
            ->with('error', $message)
            ->withErrors(['error' => $message]);
    }

    private function getErrorMessage(int $statusCode): string
    {
        return match ($statusCode) {
            503 => trans('validation.errors.maintenance'),
            419 => trans('validation.errors.expired'),
            404 => trans('validation.errors.missing'),
            403 => trans('validation.errors.forbidden'),
            // Provide the generic error message by default
            default => trans('validation.errors.error'),
        };
    }
}
