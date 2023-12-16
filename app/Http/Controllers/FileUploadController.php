<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->file('file')) {
            $anh = $request->file('file');
            $fileAnh = '/files/attachments/' . uniqid() . '.' . $anh->extension();
            $anh->move(public_path('files/attachments'), $fileAnh);
            return response()->json(['url' => $request->root() . $fileAnh]);
        }

        return response()->json(['url' => null]);
    }
}
