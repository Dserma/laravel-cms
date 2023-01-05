<?php

namespace App\Http\Controllers\Backend\Aulasvod;

use App\Models\Aulavod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Backend\BackController;
use App\Models\Backingtrakvod;
use App\Models\Partituravod;

class AulavodController extends BackController
{
    public function partituras(Aulavod $produto)
    {
        return view('backend.aulasvod.partituras', [
          'produto' => $produto,
        ]);
    }

    public function upload(Aulavod $produto, Request $request)
    {
        foreach ($request->all() as $k => $v) {
            if ($v instanceof \Illuminate\Http\UploadedFile) {
                $field = $k;
            }
        }
        $nameFile = null;
        if ($request->hasFile('galeria') && $request->file('galeria')->isValid()) {
            $nameFile = $request->galeria->getClientOriginalName();
            $upload = $request->galeria->storeAs('backend/aulasvod/' . $produto->id . '/', $nameFile);
            if (!$upload) {
                return redirect()
              ->back()
              ->with('error', 'Falha ao fazer upload')
              ->withInput();
            }
            ['link' => url('storage/app/public/backend/aulasvod/') . $produto->id . '/' . $nameFile];
            $imagem = new Partituravod();
            $imagem->arquivo = $nameFile;
            $produto->partituras()->save($imagem);

            return response()->json(['ok'], 200);
        }
    }

    public function apagar(Aulavod $produto, Request $request)
    {
        $dir = 'backend/aulasvod/' . $produto->id . '/';
        $imagem = Partituravod::find($request->key);
        $arquivo = $dir . '/' . $imagem->arquivo;
        Storage::delete($arquivo);
        $imagem->delete();
        $data = [];

        return response()->json($data);
    }

    public function backingtracks(Aulavod $produto)
    {
        return view('backend.aulasvod.backingtracks', [
          'produto' => $produto,
        ]);
    }

    public function uploadBackingtrack(Aulavod $produto, Request $request)
    {
        foreach ($request->all() as $k => $v) {
            if ($v instanceof \Illuminate\Http\UploadedFile) {
                $field = $k;
            }
        }
        $nameFile = null;
        if ($request->hasFile('galeria') && $request->file('galeria')->isValid()) {
            $nameFile = $request->galeria->getClientOriginalName();
            $upload = $request->galeria->storeAs('backend/backingtracksvod/' . $produto->id . '/', $nameFile);
            if (!$upload) {
                return redirect()
              ->back()
              ->with('error', 'Falha ao fazer upload')
              ->withInput();
            }
            ['link' => url('storage/app/public/backend/backingtracksvod/') . $produto->id . '/' . $nameFile];
            $imagem = new Backingtrakvod();
            $imagem->arquivo = $nameFile;
            $produto->backings()->save($imagem);

            return response()->json(['ok'], 200);
        }
    }

    public function apagarBackingtrack(Aulavod $produto, Request $request)
    {
        $dir = 'backend/aulasvod/' . $produto->id . '/';
        $imagem = Backingtrakvod::find($request->key);
        $arquivo = $dir . '/' . $imagem->arquivo;
        Storage::delete($arquivo);
        $imagem->delete();
        $data = [];

        return response()->json($data);
    }
}
