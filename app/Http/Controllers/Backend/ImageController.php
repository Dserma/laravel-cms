<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function Upload(Request $request)
    {
        $nameFile = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->file->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->file->storeAs('backend', $nameFile);
            if (!$upload) {
                return redirect()
                ->back()
                ->with('error', 'Falha ao fazer upload')
                ->withInput();
            }
            $data = ['link' => url('/storage/app/public/backend/') . '/' . $nameFile];

            return response()->json($data);
        }
    }

    public function Load()
    {
        $files = Storage::files('backend');
        $x = 0;
        foreach ($files as $f) {
            $images[$x]['url'] = url('/storage/app/public/') . '/' . $f;
            $images[$x]['thumb'] = url('/storage/app/public/') . '/' . $f;
            $x++;
        }

        return response()->json($images);
    }

    public function Delete(Request $request)
    {
        $src = explode('backend', $request->src);
        Storage::delete($src[1]);
    }
}
