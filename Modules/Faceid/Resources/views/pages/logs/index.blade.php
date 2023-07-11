@extends('faceid::layouts.default_layout')
@section('title', 'Logs Foto Karyawan')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="{{ asset('/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
<link href="{{ asset('/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/') }}plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />

@endpush
@section('content')
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
    <li class="breadcrumb-item active">Logs Foto Karyawan</li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">Logs Foto Karyawan</h1>
<!-- END page-header -->
<div class="row">
    <div class="col">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Logs Karyawan Table</h4>
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
                    <a type="button" onclick="refresh()" class="btn btn-xs btn-icon btn-success" data-toggle="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-warning" data-toggle="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-danger" data-toggle="panel-remove"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <form method="GET" class="row mb-3">
                    <div class="col-md-3 form-group">
                        <label for="from">From</label>
                        <input type="date" name="from" id="from" class="form-control" value="{{ request('from') ?? Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="to">To</label>
                        <input type="date" name="to" id="to" class="form-control" value="{{ request('to') ?? Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 form-group">
                        <label for="department">Separtment</label>
                        <select name="department" id="department" class="form-control">
                            <option value="all" selected>-- All Department --</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->intDepartment_ID }}" {{ request('department') == $dept->intDepartment_ID ? 'selected' : '' }}>{{ $dept->txtDepartmentName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group mt-3">
                        <button type="submit" class="btn btn-primary mt-1"><i class="fas fa-filter"></i> Filter</button>
                    </div>
                </form>

                <form method="POST" class="row mb-3" action="{{ route('faceid.setting') }}">
                    @csrf
                    <div class="col-md-3 form-group">
                        <label for="limit">Limit Suhu</label>
                        <input type="text" name="limit" id="limit" class="form-control" value="{{ $setting->limit }}">
                    </div>
                    <div class="col-md-4 form-group mt-3">
                        <button type="submit" class="btn btn-primary mt-1"><i class="fas fa-sync"></i> Update</button>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('faceid.logs.export') }}?from={{ request('from') }}&to={{ request('to') }}&department={{ request('department') }}" class="btn btn-success mt-1"><i class="fas fa-file-excel"></i> Export</a>
                        {{-- <a href="{{ route('faceid.logs.pdf') }}?from={{ request('from') }}&to={{ request('to') }}&department={{ request('department') }}" class="btn btn-success mt-1">Export PDF</a> --}}
                    </div>
                    <!-- html -->
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Date Created</th>
                                    <th>Nama Karyawan</th>
                                    <th>Nik</th>
                                    <th>Nama Dept</th>
                                    <th>Beard</th>
                                    <th>Moustache</th>
                                    <th>Suhu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Foto Karyawan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>


            <form action="" method="post" id="form-edit">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="" alt="" id="img-target" width="100">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="beard">Beard</label>
                                <select name="beard" id="beard" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="moustache">Moustache</label>
                                <select name="moustache" id="moustache" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Close</a>
                    <a href="" class="btn btn-success btn-download"><i class="fa-solid fa-download"></i> Download</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

</div>

<form action="" class=" d-none" id="form-delete" method="post">
    @csrf
    @method('DELETE')
</form>
@endsection
@push('scripts')
<script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/plugins/select-picker/dist/picker.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('/plugins/gritter/js/jquery.gritter.js') }}"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('/') }}plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('/') }}plugins/pdfmake/build/pdfmake.min.js"></script>
<script src="{{ asset('/') }}plugins/pdfmake/build/vfs_fonts.js"></script>
<script src="{{ asset('/') }}plugins/jszip/dist/jszip.min.js"></script>

<script>
    let from = $("#from").val();
    let to = $("#to").val();
    let department = $("#department").val();

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('faceid.logs.list') }}",
            type: "GET",
            data: {
                "from": from,
                "to": to,
                "department": department,
            }
        },
        deferRender: true,
        pagination: true,
        // dom: 'Bfrtip',
        // buttons: [{
        //         extend: 'csv',
        //         className: 'btn-sm'
        //     },
        //     {
        //         extend: 'excel',
        //         className: 'btn-sm btn-success'
        //     },
        //     {
        //         extend: 'pdf',
        //         className: 'btn-sm btn-danger'
        //     }
        // ],
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                sortable: false,
                searchable: false
            },
            {
                data: 'foto',
                name: 'foto'
            },
            {
                data: 'dtmCreated',
                name: 'dtmCreated'
            },
            {
                data: 'txtName',
                name: 'txtName'
            },
            {
                data: 'txtNik',
                name: 'txtNik'
            },
            {
                data: 'txtDepartmentName',
                name: 'txtDepartmentName'
            },
            {
                data: 'beard',
                name: 'beard'
            },
            {
                data: 'moustache',
                name: 'moustache'
            },
            {
                data: 'suhu',
                name: 'suhu'
            },
            {
                data: 'status',
                name: 'status'
            },
        ]
    });

    $("#btn-add").on('click', function() {
        let route = $(this).attr('data-route')
        $(".karyawan").addClass('show')
        $("#form-foto").attr('action', route)
    })

    $("#btn-close").on('click', function() {
        $("#form-foto").removeAttr('action')
    })

    $("#datatable").on('click', '.btn-edit', function() {
        let route = $(this).attr('data-route')
        let id = $(this).attr('id')

        $(".karyawan").addClass('hide')
        $("#form-foto").attr('action', route)
        $("#form-foto").append(`<input type="hidden" name="_method" value="PUT">`);

        $.ajax({
            url: "/faceid/karyawan/" + id,
            type: 'GET',
            method: 'GET',
            success: function(response) {
                let karyawan = response.karyawan;

                $("#karyawan").val(karyawan.txtName)
            }
        })
    })

    $("#datatable").on('click', '.btn-action', function() {
        let route = $(this).attr('data-route')
        let id = $(this).attr('id');
        let url = "/faceid/log/" + id
        $("#form-edit").attr("action", url);

        $.ajax({
            url: route,
            type: 'GET',
            method: 'GET',
            success: function(response) {
                let log = response.log;

                $("#img-target").attr("src", response.image)
                $("#beard").val(log.beard)
                $("#moustache").val(log.moustache)
            }
        })
    })

    $("#datatable").on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let route = $(this).attr('data-route')
        $("#form-delete").attr('action', route)

        swal({
            title: 'Hapus foto karyawan?',
            text: 'Menghapus foto karyawan bersifat permanen.',
            icon: 'error',
            buttons: {
                cancel: {
                    text: 'Cancel',
                    value: null,
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: 'Yes',
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            }
        }).then((result) => {
            if (result) {
                $("#form-delete").submit()
            } else {
                $("#form-delete").attr('action', '')
            }
        });
    })
</script>
@endpush