<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModifyDocumentRequest;
use App\Http\Requests\uploadFileRequest;
use App\services\EditWordService;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{

    protected $wordService;

    public function __construct(EditWordService $wordService)
    {
        $this->wordService = $wordService;
    }

    public function editDocument(ModifyDocumentRequest $request)
    {
        $textToAdd = $request->input('text');
        $response = $this->wordService->editWord($textToAdd);

        return $response;
    }


    public function upload(UploadFileRequest $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $originalName, 'public');

            $userName = $request->input('name');
            $lastName = $request->input('lastname');
            $id = $request->input('id');

            $fullPath = Storage::disk('public')->path($path);

            try {
                $templateProcessor = new TemplateProcessor($fullPath);

                $templateProcessor->setValue('userName', $userName);
                $templateProcessor->setValue('lastname', $lastName);
                $templateProcessor->setValue('id', $id);

                $newPath = 'uploads/modified_' . $originalName;
                $newFullPath = Storage::disk('public')->path($newPath);
                $templateProcessor->saveAs($newFullPath);

                return response()->download($newFullPath, 'modified_'.$originalName)->deleteFileAfterSend(true);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error processing file: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'No file'], 400);
    }

    public function downloadWord($name, $lastName, $serial)
    {
    $fileName = "{$name}_{$lastName}_{$serial}.docx";
    $filePath = storage_path("app/public/uploads/{$fileName}");

    if (file_exists($filePath)) {
        return response()->download($filePath, $fileName);
    }

    return back()->with('error', 'File not found');
    }
}
