<?php

namespace App\Http\Controllers;

use App\Actions\TranslationUpdateAction;
use App\Http\Requests\ImportTranslationsRequest;
use App\Http\Requests\UpdateTranslationRequest;
use ArtcoreSociety\TranslationImport\Commands\ImportTranslationsCommand;
use ArtcoreSociety\TranslationImport\Excel\LanguageLineExport;
use ArtcoreSociety\TranslationImport\Excel\LanguageLineImport;
use ArtcoreSociety\TranslationImport\Models\LanguageLine;
use ArtcoreSociety\TranslationImport\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class LanguageLineController extends Controller
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
        // Authorize
        $this->authorize('update', LanguageLine::class);

        // Update the translation
        $formData = $request->validated();
        $translationUpdateAction->handle($formData, $languageLine);

        return redirect()->back()->with('success', trans('spa.toasts.description.translation_updated'));
    }

    public function destroy(LanguageLine $languageLine)
    {
        // Authorize
        $this->authorize('delete', LanguageLine::class);

        // Delete the language line
        $languageLine->delete();

        return redirect()->back()->with('success', trans('spa.toasts.description.translation_deleted'));
    }

    public function scan() {
        // Authorize
        $this->authorize('scan', LanguageLine::class);

        // Call trans:import command
        Artisan::call(ImportTranslationsCommand::class);

        return redirect()->back()->with('success', trans('spa.toasts.description.scan_completed'));
    }

    public function import(ImportTranslationsRequest $request) {
        // Authorize
        $this->authorize('import', LanguageLine::class);

        // Validate
        $formData = $request->validated();

        // Import the file
        Excel::import(new LanguageLineImport, $formData['file']);

        // Send back to the previous page after running the importer
        return redirect()->back()->with('success', trans('spa.toasts.description.import_completed'));
    }

    public function export() {
        // Authorize
        $this->authorize('export', LanguageLine::class);

        // Get the current timestamp
        $timestamp = now()->format('Y-m-d H:i:s');

        return Excel::download(new LanguageLineExport, "translations-{$timestamp}.xlsx");
    }
}
