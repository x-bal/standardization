<?php

namespace Modules\Faceid\Http\Controllers;

use App\Exports\LogFaceidExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Faceid\Entities\Log;
use Modules\Faceid\Entities\Setting;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        $setting = Setting::find(1);

        return view('faceid::pages.logs.index', compact('setting'));
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {

            if ($request->from || $request->to) {
                $to = Carbon::parse($request->to)->addDay(1)->format('Y-m-d');

                $data = DB::table('standardization.musers as users')->join('faceid.logs as log', 'log.user_id', '=', 'users.id')->whereBetween('waktu', [$request->from, $to]);
            } else {
                $data = DB::table('standardization.musers as users')->join('faceid.logs as log', 'log.user_id', '=', 'users.id');
            }

            return DataTables::query($data)
                ->addIndexColumn()
                ->editColumn('action', function ($row) {
                    $actionBtn = '<a href="#modal-dialog" id="' . $row->id . '" class="btn btn-sm btn-success btn-edit" data-route="' . route('faceid.karyawan.update', $row->id) . '" data-bs-toggle="modal">Edit</a> <button type="button" data-route="' . route('faceid.karyawan.destroy', $row->id) . '" class="delete btn btn-danger btn-delete btn-sm">Delete</button>';

                    return $actionBtn;
                })
                ->editColumn('txtName', function ($row) {
                    return '<span class="text-dark">' . $row->txtName . '</span>';
                })
                ->editColumn('beard', function ($row) {
                    if ($row->beard == 1) {
                        $beard = 'Yes';
                    } else {
                        $beard = 'No';
                    }

                    if ($row->beard == 1) {
                        return '<span class="badge bg-danger">' . $beard . '</span>';
                    } else {
                        return '<span class="badge bg-success">' . $beard . '</span>';
                    }
                })
                ->editColumn('moustache', function ($row) {

                    if ($row->moustache == 1) {
                        $moustache = 'Yes';
                    } else {
                        $moustache = 'No';
                    }

                    if ($row->moustache == 1) {
                        return '<span class="badge bg-danger">' . $moustache . '</span>';
                    } else {
                        return '<span class="badge bg-success">' . $moustache . '</span>';
                    }
                })
                ->editColumn('suhu', function ($row) {
                    $setting = Setting::find(1);
                    if ($row->suhu > $setting->limit) {
                        return '<span class="badge bg-danger">' . $row->suhu . '</span>';
                    } else {
                        return '<span class="badge bg-success">' . $row->suhu . '</span>';
                    }
                })
                ->editColumn('foto', function ($row) {
                    return '<a href="#modal-dialog" id="' . $row->id . '" class="btn-action" data-route="' . route('faceid.logs.show', $row->id) . '" data-bs-toggle="modal">
                    <div class="menu-profile-image">
                        <img src="' . asset('/storage/' . $row->foto) . '" alt="User Photo" width="50">
                    </div>
                </a>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    return '<span class="text-dark">' . Carbon::parse($row->waktu)->format('d/m/Y H:i:s') . '</span>';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == "Healthy") {
                        $status = '<span class="badge bg-success">' . $row->status . '</span>';
                    } else {
                        $status = '<span class="badge bg-danger">' . $row->status . '</span>';
                    }

                    return $status;
                })
                ->rawColumns(['action', 'foto', 'txtName', 'beard', 'moustache', 'suhu', 'dtmCreated', 'status'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $log = Log::find($id);

        return response()->json([
            'log' => $log,
            'image' => asset('/storage/' . $log->foto)
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $setting = Setting::find(1);

            $setting->update([
                'limit' => $request->limit
            ]);

            DB::commit();

            return back()->with('success', "Limit successfully updated");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function updateLog(Request $request, Log $log)
    {
        $beard = $request->beard;
        $moustache = $request->moustache;
        $setting = Setting::find(1);

        if ($beard == 0 && $moustache == 0 && $log->suhu < $setting->limit) {
            $status = "Healthy";
        } else {
            $status = "Not Healthy";
        }

        try {
            DB::beginTransaction();
            $log->update([
                'beard' => $beard,
                'moustache' => $moustache,
                'status' => $status,
            ]);

            DB::commit();

            return back()->with('success', "Log successfully updated");
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage());
        }
    }

    public function export(Request $request)
    {
        $data = [];

        $logs = DB::table('standardization.musers as users')
            ->join('faceid.logs as log', 'log.user_id', '=', 'users.id')
            ->join('standardization.mdepartments as department', 'users.intDepartment_ID', '=', 'department.intDepartment_ID')
            ->select(['log.waktu', 'users.txtNik', 'users.txtName', 'department.txtDepartmentName', 'log.moustache', 'log.beard', 'log.suhu', 'log.status'])->get();

        foreach ($logs as $log) {
            $kondisi = '';
            $gmp = '';
            $moustache = '';
            $beard = '';

            if ($log->moustache == 0) {
                $moustache = 'OK';
            } else {
                $moustache = 'NOK';
            }

            if ($log->beard == 0) {
                $beard = 'OK';
            } else {
                $beard = 'NOK';
            }

            if ($log->status == 'Healthy') {
                $kondisi = 'OK';
            } else {
                $kondisi = 'NOK';
            }

            if ($log->moustache == 0 && $log->beard == 0) {
                $gmp = 'OK';
            } else {
                $gmp = 'NOK';
            }

            $data[] = [Carbon::parse($log->waktu)->format('d-F-y'), Carbon::parse($log->waktu)->format('H.i'), $log->txtNik, $log->txtName, $log->txtDepartmentName, $moustache, $beard, $log->suhu, 'Ya', $kondisi, $gmp];
        }

        // return $data;

        return Excel::download(new LogFaceidExport($data), 'logs_export.xlsx');
    }
}
