<?php

namespace Modules\ROonline\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ROonline\Entities\LogHistoryModel as LogHistory;

class ROonlineController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('roonline::pages.dashboard');
    }

    public function getROWidget()
    {
        $subQuery = LogHistory::selectRaw("MAX(intLog_History_ID) AS intLog_History_ID")
            ->groupBy('txtLineProcessName')
            ->get();
        $datas = LogHistory::where('txtLineProcessName', '<>', 'undefined')
            ->whereIn('intLog_History_ID', $subQuery)
            ->orderBy('txtLineProcessName', 'ASC')
            ->get(['intLog_History_ID', 'txtLineProcessName', 'txtBatchOrder', 'txtProductName', 'txtProductionCode', 'dtmExpireDate',
            'txtStatus', 'floatValues', 'TimeStamp']);
        return response()->json([
            'status' => 'success',
            'data' => $datas
        ], 200);
    }

    public function ROChart(Request $request){
        if ($request->start != 'false') {
            $from = $request->start;
        } else {
            $from = LogHistory::selectRaw("DATE_SUB(`TimeStamp`, INTERVAL 1 HOUR) AS `from`")
                ->orderBy('intLog_History_ID', 'DESC')
                ->take(1)
                ->first()->from;
        }
        if ($request->end != 'false') {
            $to = $request->end;
        } else {
            $to = LogHistory::orderBy('intLog_History_ID', 'DESC')->first(['TimeStamp'])->TimeStamp;
        }
        $logs = LogHistory::selectRaw("`TimeStamp` AS xAxis, floatValues, txtLineProcessName")
            ->whereBetween('TimeStamp', [$from, $to])
            ->where('txtLineProcessName', '<>', 'undefined')
            ->orderBy('txtLineProcessName', 'ASC')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $logs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('roonline::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('roonline::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('roonline::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
