<?php

namespace Modules\Faceid\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Faceid\Entities\Log;

class FaceidController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $year = '';
        $month = '';
        $dailyhealth = [];
        $dailynothealth = [];
        $dates = [];
        $temps = [];
        $users = [];
        $userid = [];
        $gmpok = [];
        $gmpnok = [];
        $totalDaily = [];
        $departments = DB::table('standardization.mdepartments')->get();

        if ($request->month || $request->from && $request->to) {
            $year = explode('-', $request->month)[0];
            $month = explode('-', $request->month)[1];
            $startDate = Carbon::create($request->from);
            $endDate = Carbon::create($request->to);
            $startMonth = Carbon::parse($request->month)->startOfMonth();
            $endMonth = Carbon::parse($request->month)->endOfMonth();
        } else {
            $year = Carbon::now('Asia/Jakarta')->format('Y');
            $month = Carbon::now('Asia/Jakarta')->format('m');
            $startDate = Carbon::now('Asia/Jakarta')->startOfMonth();
            $endDate = Carbon::now('Asia/Jakarta')->endOfMonth();
            $startMonth = Carbon::now('Asia/Jakarta')->startOfMonth();
            $endMonth = Carbon::now('Asia/Jakarta')->endOfMonth();
        }

        $dateList = [];
        $newdateList = [];

        for ($date = $startMonth; $date->lte($endMonth); $date->addDay()) {
            $dateList[] = $date->format('Y-m-d');
        }


        for ($newdate = $startDate; $newdate->lte($endDate); $newdate->addDay()) {
            $newdateList[] = $newdate->format('Y-m-d');
        }

        foreach ($dateList as $period) {
            $totalDaily[] = Log::whereDate('waktu', $period)->groupBy('user_id')->count();
            $dates[] = $period;
        }

        foreach ($newdateList as $tgl) {
            $dailyhealth[] = Log::where('status', "Healthy")->whereDate('waktu', $tgl)->count();
            $dailynothealth[] = Log::where('status', "Not Healthy")->whereDate('waktu', $tgl)->count();
            $gmpok[] = Log::where(['moustache' => 0, 'beard' => 0])->whereDate('waktu', $tgl)->count();
            $gmpnok[] = Log::where(['moustache' => 1, 'beard' => 1])->whereDate('waktu', $tgl)->count();
        }


        // return $dateList;
        $counthealth = Log::where('status', "Healthy")->whereYear('waktu', $year)->whereMonth('waktu', $month)->count();
        $countnothealth = Log::where('status', "Not Healthy")->whereYear('waktu', $year)->whereMonth('waktu', $month)->count();

        $userid = DB::table('standardization.musers as users')->pluck('users.id');

        foreach ($userid as $id) {
            $temps[] = Log::where('user_id', $id)->whereYear('waktu', $year)->whereMonth('waktu', $month)->latest()->first()->suhu ?? 0;
            $users[] = DB::table('faceid.logs as logs')->join('standardization.musers as users', 'logs.user_id', '=', 'users.id')->where("logs.user_id", $id)->first()->txtName ?? '-';
        }

        return view('faceid::index', compact('counthealth', 'countnothealth', 'dailyhealth', 'dailynothealth', 'dates', 'temps', 'users', 'gmpok', 'gmpnok', 'newdateList', 'totalDaily', 'departments'));
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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('faceid::show');
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
