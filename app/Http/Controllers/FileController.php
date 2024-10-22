<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function getValidIdPhoto($barangayId, $role, $userId, $fileName)
    {
        // Build the file path based on the route parameters
        $filePath = storage_path("app\photos\\{$barangayId}\\validIds\\{$role}\\{$userId}\\{$fileName}");

        // Check if the file exists
        if (file_exists($filePath)) {
            // Return the file as a response, so it can be displayed in an <img> tag
            return response()->file($filePath, [
                'Content-Type' => mime_content_type($filePath), // Ensure correct MIME type
                'Content-Disposition' => 'inline',
            ]);
        }

        // Return a 404 error if the file doesn't exist
        return abort(404, 'Image not found');
    }
}
