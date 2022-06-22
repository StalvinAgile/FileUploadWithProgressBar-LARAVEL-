<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

class FileUploadApiController extends Controller
{

    public function store(Request $request)
    {
        Log::info($request);
        try {
            // $request->validate([
            //     'file_name' => 'file|mimes:csv,xlsx,xls|max:10000',
            // ]);
            $file = new FileUpload();
            $file->file_name = $this->uploadFile($request);
            $file->save();
            return response()->json(['status' => 'S', 'message' => 'file uploaded successfully']);
        } catch (Exception $file_exception) {
            return response()->json(['status' => 'E', 'message' => 'invalid file']);
        }
    }
    protected function uploadFile(Request $request)
    {
        $folder_name = $request->folder_name;
        try {
            if ($request->hasFile('file_name')) {
                $file = $request->file('file_name');
                $originalFileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileName = Str::slug($fileNameOnly) . '-' . time() . '.' . $extension;
                return $file->move('storage'.'/'.$folder_name, $fileName);
            }
            return null;
        } catch (Exception $file_exception) {
            return response()->json(['status' => 'E', 'message' => 'Error Uploading file ']);
        }
    }
}
