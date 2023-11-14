<?php

namespace App\Actions;

use Spatie\TranslationLoader\LanguageLine;

class TranslationUpdateAction
{
    public function handle(array $data, LanguageLine $languageLine): void
    {
        LanguageLine::updateOrCreate(['id' => $languageLine->id], [
            'text' => $data['text'],
        ]);
    }
}
