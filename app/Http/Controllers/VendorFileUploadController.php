<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorFileUpload;
use Illuminate\Support\Facades\DB;

class VendorFileUploadController extends Controller
{
    public function store(Request $request, $vendor_id)
    {
        // Manually validate to prevent redirect
        $validator = Validator::make($request->all(), [
            'files' => 'required|array',
            'files.*' => 'file|max:8192', // 8MB max per file
        ]);

        // If validation fails, return JSON response
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if files exist
        if (!$request->hasFile('files')) {
            return response()->json(['success' => false, 'message' => 'No files uploaded'], 400);
        }

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $filePath = $file->store('vendor_uploads', 'public');

            $vendorFile = VendorFileUpload::create([
                'vendor_id' => $vendor_id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
            ]);

            $uploadedFiles[] = [
                'id' => $vendorFile->id,
                'name' => $vendorFile->file_name,
                'url' => asset('storage/' . $filePath),
            ];
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles
        ]);
    }

    public function storeChunkedUpload(Request $request) {
        $fileName = $request->input('fileName');
        $totalSize = (int) $request->input('totalSize');
        $chunkIndex = (int) $request->input('chunkIndex');
        $totalChunks = (int) $request->input('totalChunks');
        
        $uploadPath = storage_path("uploads/vendor_chunks");
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
    
        $filePath = "{$uploadPath}/{$fileName}.part";
    
        // Append chunk to file
        file_put_contents($filePath, $request->file('file')->get(), FILE_APPEND);
    
        // Store progress in DB
        $uploadedSize = filesize($filePath);
        DB::table('upload_progress')->updateOrInsert(
            ['file_name' => $fileName],
            ['uploaded_size' => $uploadedSize, 'total_size' => $totalSize]
        );
    
        // If all chunks are received, rename the file
        if ($uploadedSize >= $totalSize) {
            rename($filePath, storage_path("uploads/{$fileName}"));
            DB::table('upload_progress')->where('file_name', $fileName)->delete();
        }
    
        return response()->json(['uploadedSize' => $uploadedSize]);
    }
    
    // API to get uploaded file progress
    public function getUploadProgress(Request $request) {
        $fileName = $request->query('fileName');
        $progress = DB::table('upload_progress')->where('file_name', $fileName)->first();
        return response()->json(['uploadedSize' => $progress->uploaded_size ?? 0]);
    }
}
