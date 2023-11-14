<?php

namespace App\Http\Controllers;

use App\Actions\TranslationUpdateAction;
use App\Http\Requests\ImportTranslationsRequest;
use App\Http\Requests\UpdateTranslationRequest;
use ArtcoreSociety\TranslationImport\Commands\ImportTranslationsCommand;
use ArtcoreSociety\TranslationImport\Excel\LanguageLineExport;
use ArtcoreSociety\TranslationImport\Excel\LanguageLineImport;
use ArtcoreSociety\TranslationImport\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Spatie\TranslationLoader\LanguageLine;
use Maatwebsite\Excel\Facades\Excel;

class TranslationController extends Controller
{
    private TranslationService $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    public function index(Request $request, string $group = 'all')
    {
        // Get the search term when available
        $term = $request->query('search');

        return Inertia::render('Dashboard/Translations/Index', [
            'languageLines' => $this->translationService->getLanguageLines($group, $term),
        ]);
    }

    public function update(UpdateTranslationRequest $request, TranslationUpdateAction $translationUpdateAction, LanguageLine $languageLine)
    {
        $formData = $request->validated();
        $translationUpdateAction->handle($formData, $languageLine);

        return redirect()->back()->with('success', trans('spa.toasts.description.translation_updated'));
    }

    public function destroy(LanguageLine $languageLine)
    {
        // Delete the language line
        $languageLine->delete();

        return redirect()->back();
    }

    public function scan() {
        // Call trans:import command
        Artisan::call(ImportTranslationsCommand::class);

        return redirect()->back()->with('success', trans('spa.toasts.description.scan_completed'));
    }

    public function import(ImportTranslationsRequest $request) {
        // Validate
        $formData = $request->validated();

        // Import the file
        Excel::import(new LanguageLineImport, $formData['file']);

        // Send back to the previous page after running the importer
        return redirect()->back()->with('success', trans('spa.toasts.description.import_completed'));
    }

    public function export() {
        // Get the current timestamp
        $timestamp = now()->format('Y-m-d H:i:s');

        return Excel::download(new LanguageLineExport, "translations-{$timestamp}.xlsx");
    }
}
