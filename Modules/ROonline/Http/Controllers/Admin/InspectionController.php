<?php

namespace Modules\ROonline\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Modules\ROonline\Entities\ProcessModel;
use Modules\ROonline\Entities\ProductModel as Product;
use Yajra\DataTables\DataTables;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $inspections = ProcessModel::all();
            return DataTables::of($inspections)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn_edit = '<button onclick="edit('.$row->intProcess_ID.')" class="btn btn-sm btn-success" onclick="edit('.$row->intProcess_ID.')"><i class="fa-solid fa-pen-to-square"></i></button>';
                    $btn_delete = '<button class="btn btn-sm btn-danger" onclick="destroy('.$row->intProcess_ID.')"><i class="fa-solid fa-trash"></i></button>';
                    return $btn_edit;
                })
                ->editColumn('dtmInserted', function($row){
                    return date('Y-m-d H:i', strtotime($row->dtmInserted));
                })
                ->addColumn('status', function($row){
                    if ($row->bitActive) {
                        $status = '<span class="badge bg-success">Active</span>';
                    } else {
                        $status = '<span class="badge bg-danger">Non-active</span>';
                    }
                    return $status;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        } else {
            $products = Product::all();
            return view('roonline::pages.admin.inspections', [
                'products' => $products
            ]);
        }
    }

    public function getOkp()
    {
        $response = Http::withBasicAuth('admin', '@0332022')->get(
            'http://10.175.11.56/api-kmi/api/oee/statusfinish',
            [
                'decode_content' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]
        );
        $result = json_decode($response->getBody()->getContents(), true);
        $datas = collect($result['data'])->groupBy('BATCH_NO')->all();
        // echo "<pre>",var_dump($datas),"</pre>";
        // die();
        return response()->json([
            'status' => 'success',
            'datas' => $datas
        ], 200);
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
        $inspections = ProcessModel::find($id);
        if ($inspections) {
            return response()->json([
                'status' => 'success',
                'data' => $inspections
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $input = $request->only([
            'txtLineProcessName', 'txtBatchOrder', 'txtProductName',
            'txtProductionCode', 'dtmExpireDate', 'txtOptFilling', 'txtOptQA'
        ]);
        $inspection = ProcessModel::find($id);
        if ($inspection) {
            $inspection->update($input);
            return response()->json([
                'status' => 'success',
                'message' => 'Inspection updated Successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Record not found'
            ], 404);
        }
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
