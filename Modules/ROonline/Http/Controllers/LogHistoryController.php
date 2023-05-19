<?php

namespace Modules\ROonline\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;
use Yajra\DataTables\DataTables;

class LogHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private function _logHistory(){
        return LogHistory::latest()->select('*');
    }
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $logs = $this->_logHistory();
            return DataTables::of($logs)
                ->addColumn('action', function($row){
                    $btn_view = '<button class="btn btn-sm btn-info" onclick="view('.$row->intLog_History_ID.')"><i class="fa-solid fa-eye"></i></button>';
                    return $btn_view;
                })
                ->editColumn('TimeStamp', function($row){
                    return date('Y-m-d H:i', strtotime($row->TimeStamp));
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('roonline::pages.log-history');
        }
    }
}
