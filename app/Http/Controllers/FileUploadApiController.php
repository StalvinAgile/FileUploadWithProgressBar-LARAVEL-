<?php

namespace App\Http\Controllers;

use App\Models\FileUpload;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

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

            $the_file = $filepathdetails->file_name;

            $spreadsheet = IOFactory::load($the_file);
            $sheet = $spreadsheet->getActiveSheet();
            $row_limit = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range = range(2, $row_limit);
            $column_range = range('F', $column_limit);
            $startcount = 2;
            $errorcount = 0;
            $data = array();
            $cityinsertcount = 0;
            foreach ($row_range as $row) {
                $data[] = [
                    'Event Name' => $sheet->getCell('A' . $row)->getValue(),
                    'Type' => $sheet->getCell('B' . $row)->getValue(),
                    'Parent Event' => $sheet->getCell('C' . $row)->getValue(),
                    'Organiser' => $sheet->getCell('D' . $row)->getValue(),
                    'Start Date' => $sheet->getCell('E' . $row)->getValue(),
                    'Start Time' => $sheet->getCell('F' . $row)->getValue(),
                    'End Date' => $sheet->getCell('G' . $row)->getValue(),
                    'End Time' => $sheet->getCell('H' . $row)->getValue(),
                    'Description' => $sheet->getCell('I' . $row)->getValue(),
                    'Featured' => $sheet->getCell('J' . $row)->getValue(),
                    'Active' => $sheet->getCell('K' . $row)->getValue(),
                    'Event Link' => $sheet->getCell('L' . $row)->getValue(),
                    'Venue Name' => $sheet->getCell('M' . $row)->getValue(),
                    'Address' => $sheet->getCell('N' . $row)->getValue(),
                    'Town/City' => $sheet->getCell('O' . $row)->getValue(),
                    'PostCode' => $sheet->getCell('P' . $row)->getValue(),
                    'County/District' => $sheet->getCell('Q' . $row)->getValue(),
                    'Country' => $sheet->getCell('R' . $row)->getValue(),
                ];

                $startcount++;
            }

            foreach ($data as $key => $value) {
                Log::info('In loop');
                $country = Upload::create([
                    'Event_Name' => $value['Event Name'],
                    'Type' => $value['Type'],
                    'Parent_Event' => $value['Parent Event'],
                    'Organiser' => $value['Organiser'],
                    'Start_Date' => $value['Start Date'],
                    'Start_Time' => $value['Start Time'],
                    'End_Date' => $value['End Date'],
                    'End_Time' => $value['End Time'],
                    'Description' => $value['Description'],
                    'Featured' => $value['Featured'],
                    'Active' => $value['Active'],
                    'Event_Link' => $value['Event Link'],
                    'Venue_Name' => $value['Venue Name'],
                    'Address' => $value['Address'],
                    'Town' => $value['Town/City'],
                    'PostCode' => $value['PostCode'],
                    'County' => $value['County/District'],
                    'Country' => $value['Country'],
                ]);

            }

            return response()->json(['status' => '$status', 'message' => '$message', 'filepath' => $filepathdetails]);
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
                return $file->move('storage' . '/' . $folder_name, $fileName);
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