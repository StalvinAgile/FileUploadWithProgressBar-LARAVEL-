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
        
        try {
            // $request->validate([
            //     'file_name' => 'file|mimes:csv,xlsx,xls|max:10000',
            // ]);
            $filepath = $this->uploadFile($request);
            $file_upload = FileUpload::create([
                'file_name' => $filepath,
            ]);
            $filepathdetails = $this->fetchdatabase($file_upload->id);
            Log::info($filepathdetails);
            return response()->json(['status' => '$status', 'message' => '$message','filepath' => $filepathdetails]);
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
    public function fetchdatabase($id)
    {

        try {
            $filesdata = FileUpload::where('id', $id)->first();

            return $filesdata;
        } catch (Exception $file_exception) {
            return response()->json(['status' => 'E', 'message' => 'invalid file']);
        }
    }
}
