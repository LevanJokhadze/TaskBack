<?php
namespace App\services;

use PhpOffice\PhpWord\IOFactory;


class EditWordService
{
    public function editWord($textToAdd)
    {
        $path = storage_path('app/public/student.docx');
        if (!file_exists($path)) {
            return ['error' => 'File not found.'];
        }

        try {
            $phpWord = IOFactory::load($path);
            $section = $phpWord->addSection();
            $section->addText($textToAdd);
            $editedFilePath = storage_path('app/public/student_0.docx');
            $phpWord->save($editedFilePath, 'Word2007');

            return response()->download($editedFilePath, 'edited_document.docx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ])->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return ['error' => 'Failed to edit document: ' . $e->getMessage()];
        }
    }
}
