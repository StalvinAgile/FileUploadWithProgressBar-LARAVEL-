<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\FileUpload;
use Illuminate\Support\Str;
use Image;
use Log;

class FileUploadApiController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'file|mimes:csv,xlsx,xls|max:10000',
        ]);
        $image = new FileUpload();
        $image->file_name = $this->uploadFile($request);
        $image->save();
        return response()->json(['status' => 'S', 'message', 'file uploaded successfully']);
    }
    protected function uploadFile(Request $request)
    {
        if ($request->hasFile('file_name')) {
            $image = $request->file('file_name');
            $originalFileName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
            $fileName = Str::slug($fileNameOnly) . '-' . time() . '.' . $extension;
            return $image->storeAs('public', $fileName);
        }
        return null;
    }
}
