<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
            $data = DB::table('standardization.musers as users')->join('faceid.logs as log', 'log.user_id', '=', 'users.id')->get(['txtName', 'waktu', 'foto', 'log.id', 'moustache', 'beard', 'suhu']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="#modal-dialog" id="' . $row->id . '" class="btn btn-sm btn-success btn-edit" data-route="' . route('faceid.karyawan.update', $row->id) . '" data-bs-toggle="modal">Edit</a> <button type="button" data-route="' . route('faceid.karyawan.destroy', $row->id) . '" class="delete btn btn-danger btn-delete btn-sm">Delete</button>';

                    return $actionBtn;
                })
                ->editColumn('foto', function ($row) {
                    return '<div class="menu-profile-image">
                    <img src="' . asset('/storage/' . $row->foto) . '" alt="User Photo" width="50">
                </div>';
                })
                ->editColumn('dtmCreated', function ($row) {
                    return Carbon::parse($row->waktu)->format('d/m/Y H:i:s');
                })
                ->rawColumns(['action', 'foto'])
                ->make(true);
        }
    }
}
