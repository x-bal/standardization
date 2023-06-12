<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Device;
use Modules\Faceid\Entities\Log;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $now = Carbon::now('Asia/Jakarta')->format('YmdHis');

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('logs', $now . '-' . rand(1000, 9999) . '.' . $foto->extension());

            $device = Device::where('iddev', $request->id_device)->first();

            $user = DB::connection('mysql')->table('musers')->where('txtNik', $request->nik)->first();

            Log::create([
                'user_id' => $user->id,
                'device_id' => $device->id,
                'moustache' => $request->moustache,
                'beard' => $request->beard,
                'suhu' => $request->suhu,
                'waktu' => $request->waktu,
                'foto' => $fotoUrl,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Log berhasil disimpan"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
