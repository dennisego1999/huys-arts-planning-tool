<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

class Notification extends DatabaseNotification
{
    use MassPrunable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    public $appends = [
        'translation_key',
        'label',
        'message',
        'url'
    ];

    public $hidden = [
        'notifiable_type',
        'notifiable_id',
        'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMonth());
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function related(): MorphTo
    {
        return $this->morphTo('related');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function translationKey(): Attribute
    {
        return new Attribute(fn() => (string) Str::of($this->type)
            ->after('App\Notifications\\')
            ->before('Notification')
            ->snake());
    }

    public function label(): Attribute
    {
        return new Attribute(fn() => trans("spa.notifications.types.$this->translation_key"));
    }

    public function message(): Attribute
    {
        return new Attribute(fn() => trans("spa.notifications.messages.$this->translation_key", [
            'group' => $this->related->name
        ]));
    }

    public function url(): Attribute
    {
        return new Attribute(fn() => route('dance-groups.show', $this->related));
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
