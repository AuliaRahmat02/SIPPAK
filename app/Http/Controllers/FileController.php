<?php

namespace App\Http\Controllers;

use App\Models\cutiUp;
use App\Models\history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    public function history($ket){
        history::Create([
            'NIP' => auth()->user()->NIP_User,
            'Nama'=> auth()->user()->Nama_User,
            'Keterangan'=>$ket]
        );
    }
    public function store(Request $request)
    {
        // Validate the file input
        $request->validate([
            'file' => 'required|mimes:pdf|',
            'nip' => 'required',
            'nama' => 'required',
            'jenisSurat' => 'required',
        ]);

        $jenisSurat=[
            1=>"Surat Pengantar",
            2=>"Nota",
            3=>"Blanko",
            4=>"Bukti Dukung",
        ];


        $file = $request->file('file');
        $fileName = $jenisSurat[$request->jenisSurat]."_". $request->nama;

            // Ambil informasi file

            $fileType = $file->getClientMimeType();
            $nip = $request->nip;
            $fileData = file_get_contents($file->getRealPath()); // Baca isi file sebagai binary

            // Simpan ke database sebagai LONGBLOB
            cutiUp::updateOrCreate(
                // Condition to find the existing record
                [
                    'nip' => $nip,
                    'jenis_file' => $request->jenisSurat,
                ],
                // Data to update or insert
                [
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'file_data' => $fileData,
                ]
            );

            $this->history("Mengupload Kelengkapan Cuti (".$jenisSurat[$request->jenisSurat].")");


        return redirect()->back()->with('error', 'Gagal mengupload file.');
    }

}


