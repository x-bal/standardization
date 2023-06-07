<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Log;
use Yajra\DataTables\Facades\DataTables;

class LogController extends Controller
{
    public function index()
    {
        return view('faceid::pages.logs.index');
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
                    if ($row->beard == 1 || $row->moustache == 1) {
                        return '<span class="text-danger">' . $row->txtName . '</span>';
                    } else {
                        return $row->txtName;
                    }
                })
                ->editColumn('beard', function ($row) {
                    if ($row->beard == 1) {
                        $beard = 'Yes';
                    } else {
                        $beard = 'No';
                    }

                    if ($row->beard == 1 || $row->moustache == 1) {
                        return '<span class="text-danger">' . $beard . '</span>';
                    } else {
                        return $beard;
                    }
                })
                ->editColumn('moustache', function ($row) {

                    if ($row->moustache == 1) {
                        $moustache = 'Yes';
                    } else {
                        $moustache = 'No';
                    }

                    if ($row->beard == 1 || $row->moustache == 1) {
                        return '<span class="text-danger">' . $moustache . '</span>';
                    } else {
                        return $moustache;
                    }
                })
                ->editColumn('suhu', function ($row) {

                    if ($row->beard == 1 || $row->moustache == 1) {
                        return '<span class="text-danger">' . $row->suhu . '</span>';
                    } else {
                        return $row->suhu;
                    }
                })
                ->editColumn('foto', function ($row) {
                    return '<a href="#modal-dialog" id="" class="btn-action" data-route="' . route('faceid.logs.show', $row->id) . '" data-bs-toggle="modal">
                    <div class="menu-profile-image">
                        <img src="' . $row->foto . '" alt="User Photo" width="50">
                    </div>
                </a>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    if ($row->beard == 1 || $row->moustache == 1) {
                        return '<span class="text-danger">' . Carbon::parse($row->waktu)->format('d/m/Y H:i:s') . '</span>';
                    } else {
                        return Carbon::parse($row->waktu)->format('d/m/Y H:i:s');
                    }
                })
                ->rawColumns(['action', 'foto', 'txtName', 'beard', 'moustache', 'suhu', 'dtmCreated'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $log = Log::find($id);

        return response()->json([
            'log' => $log
        ]);
    }
}
