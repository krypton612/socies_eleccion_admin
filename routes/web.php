<?php

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return Redirect::to('/control/login');
});

Route::get('/login', function () {
    return Redirect::to('/control/login');
})->name('login');


Route::get('/test-b2-upload', function () {
    try {
        $filename = 'candidatos/test-' . now()->timestamp . '.txt';
        $result = Storage::disk('backblaze_bucket')->put($filename, 'Contenido de prueba desde Laravel');

        if ($result) {
            $exists = Storage::disk('backblaze_bucket')->exists($filename);
            $url = Storage::disk('backblaze_bucket')->temporaryUrl($filename, now()->addMinutes(10));
            return response()->json([
                'message' => '✅ Subida exitosa',
                'filename' => $filename,
                'url_temp' => $url,
                'exists' => $exists,
            ]);
        } else {
            return response()->json(['message' => '❌ Falló la subida'], 500);
        }
    } catch (\Throwable $e) {
        Log::error('Error en Backblaze B2: ' . $e->getMessage());
        return response()->json([
            'message' => '❌ Excepción durante la subida',
            'error' => $e->getMessage(),
        ], 500);
    }
});
