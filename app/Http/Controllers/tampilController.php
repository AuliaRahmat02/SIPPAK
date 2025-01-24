<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\cutiUp;

class TampilController extends Controller
{

    public function viewPdf($id)
    {
        // Find the file by its ID
        $file = DB::table('cuti_ups')
            ->where('id', $id)
            ->first(); // Adjust to match your actual table structure


        // Get the binary PDF data
        $pdfData = $file->file_data; // Assuming the binary data is stored in 'file_data'

        // Return the PDF as a response
        return response($pdfData, 200)
            ->header('Content-Type', 'application/pdf')  // Set PDF content type
            ->header('Content-Disposition', 'inline; filename="document.pdf"');  // Inline means it will be displayed in the browser
    }

    // Show the page with the embedded PDF
    public function showPdfView($id)
    {
        // Retrieve the file info from the database
        $file = cutiUp::where('id', "=", $id)->first();


        // Return the view with the file info
        return view('pdfview', ['data' => $file, 'title' => 'Tampil PDF']);
    }



    public function checkpdf($id)
    {
        // Retrieve the file info from the database
        $file = DB::table('cuti_ups')
            ->where('ID', "=", $id)
            ->first();



        // Return the view with the file info
        return $file;
    }
}
