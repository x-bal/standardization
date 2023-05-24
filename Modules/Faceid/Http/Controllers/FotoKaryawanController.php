<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Faceid\Entities\Device;
use Modules\Faceid\Entities\FotoKaryawan;
use Yajra\DataTables\Facades\DataTables;

class FotoKaryawanController extends Controller
{
    public function index()
    {
        $fotoId = DB::connection('faceid')->table('foto_karyawans')->pluck('user_id');

        $karyawan = DB::connection('mysql')->table('musers')->whereNotIn('id', $fotoId)->get();
        $devices = Device::get();

        return view('faceid::pages.karyawan.index', compact('karyawan', 'devices'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('standardization.musers as users')->join('faceid.foto_karyawans as foto', 'foto.user_id', '=', 'users.id')->get(['txtName', 'created_at', 'foto', 'foto.id', 'is_export']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('checkbox', function ($row) {
                    $checkbox = '';
                    if ($row->is_export == 0) {
                        $checkbox .= '<input type="checkbox" name="" id="' . $row->id . '" class="check-karyawan">';
                    }
                    return $checkbox;
                })
                ->editColumn('action', function ($row) {
                    $actionBtn = '<a href="#modal-dialog" id="' . $row->id . '" class="btn btn-sm btn-success btn-edit" data-route="' . route('faceid.karyawan.update', $row->id) . '" data-bs-toggle="modal">Edit</a> <button type="button" data-route="' . route('faceid.karyawan.destroy', $row->id) . '" class="delete btn btn-danger btn-delete btn-sm">Delete</button>';

                    return $actionBtn;
                })
                ->editColumn('foto', function ($row) {
                    return '<div class="menu-profile-image">
                    <img src="' . asset('/storage/' . $row->foto) . '" alt="User Photo" width="50">
                </div>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    return Carbon::parse($row->created_at)->format('d/m/Y H:i:s');
                })
                ->rawColumns(['action', 'foto', 'checkbox'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('faceid::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'karyawan' => 'required|numeric',
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            DB::beginTransaction();

            $karyawan = DB::connection('mysql')->table('musers')->find($request->karyawan);

            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('users', $karyawan->txtNik . '.' . $foto->extension());

            $karyawan = FotoKaryawan::create([
                'user_id' => $request->karyawan,
                'foto' => $fotoUrl,
            ]);

            DB::commit();

            return back()->with('success', "Foto karyawan berhasil diupload");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $karyawan = FotoKaryawan::find($id);

        return response()->json([
            'karyawan' => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('faceid::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'foto' => 'required|mimes:jpg,jpeg,png'
        ]);

        try {
            DB::beginTransaction();

            $fotoKaryawan = FotoKaryawan::find($id);
            $karyawan = DB::connection('mysql')->table('musers')->find($fotoKaryawan->user_id);

            Storage::delete($fotoKaryawan->foto);
            $foto = $request->file('foto');
            $fotoUrl = $foto->storeAs('users', $karyawan->txtNik . '.' . $foto->extension());

            $fotoKaryawan->update([
                'foto' => $fotoUrl,
                'is_export' => 0
            ]);

            DB::commit();

            return back()->with('success', "Foto karyawan berhasil diupdate");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $fotoKaryawan = FotoKaryawan::find($id);

            Storage::delete($fotoKaryawan->foto);

            $fotoKaryawan->delete();

            DB::commit();

            return back()->with('success', "Foto karyawan berhasil dihapus");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function addPersons(Request $request)
    {
        $device = Device::find($request->device);
        $deviceTarget = $device->iddev;
        $ipDevice = $device->ipaddres;

        $personInfo = [];

        $karyawan = FotoKaryawan::whereIn('id', $request->idkary)->get();

        $newArray = [
            "operator" => "AddPersons",
            "DeviceID" => $deviceTarget,
            "Total" => count($karyawan),
        ];

        foreach ($karyawan as $i => $person) {
            $member = DB::connection('mysql')->table('musers')->find($person->user_id);

            $gambar = file_get_contents(storage_path('/app/public/' . $person->foto));
            $gambar_format = base64_encode($gambar);
            $id = $member->txtNik;

            $personInfo = [
                "Name" => $member->txtName,
                "CustomizeID" => intval($id),
                "PersonUUID" => $id,
                "picinfo" => $gambar_format
            ];
            $newArray["Personinfo_$i"] = $personInfo;
        }

        // Encode newArray to json format
        $json = json_encode($newArray, JSON_UNESCAPED_SLASHES);

        $headers = array(
            "Authorization: Basic " . base64_encode("admin:admin"),
            'Content-Type: application/x-www-form-urlencoded'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ipDevice . '/action/AddPersons');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result['code'] == 200) {
            foreach ($karyawan as $p) {
                $p->update(['is_export' => 1]);
            }

            return back()->with('success', "Foto karyawan berhasil diexport");
        } else {
            return back()->with('error', $result);
        }
    }

    public function export($id)
    {
        $deviceTarget = 1935378;
        $ipDevice = '192.168.99.121';

        $personInfo = [];

        $karyawan = FotoKaryawan::find($id);

        $member = DB::connection('mysql')->table('musers')->find($karyawan->user_id);

        $gambar = file_get_contents(storage_path('/app/public/' . $karyawan->foto));

        $gambar_format = base64_encode($gambar);
        $id = $member->txtNik;

        $personInfo = [
            "operator" => "AddPerson",
            "info" => [
                "DeviceID" => $deviceTarget,
                "Name" => $member->txtName,
                "CustomizeID" => intval($id),
                "PersonUUID" => $id,
            ],
            "picinfo" => $gambar_format
        ];

        // Encode newArray to json format
        $json = json_encode($personInfo, JSON_UNESCAPED_SLASHES);

        $headers = array(
            "Authorization: Basic " . base64_encode("admin:admin"),
            'Content-Type: application/x-www-form-urlencoded'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ipDevice . '/action/AddPerson');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if ($result['code'] == 200) {
            return back()->with('success', "Foto karyawan berhasil diexport");
        } else {
            return back()->with('error', $result);
        }
    }
}
