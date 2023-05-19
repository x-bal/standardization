@extends('layouts.auth_layout')
@section('title', 'Login | Standardization')
@push('css')
    <style>
        .panel-body {
            position: relative;
        }
        .panel-body .qa {
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translate(-25%, -50%);
            -ms-transform: translate(-25%, -50%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .whs {
            position: absolute;
            top: 17%;
            left: 42%;
            transform: translate(-17%, -42%);
            -ms-transform: translate(-17%, -42%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .eng {
            position: absolute;
            top: 55%;
            left: 48%;
            transform: translate(-55%, -48%);
            -ms-transform: translate(-55%, -48%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .bda {
            position: absolute;
            top: 37%;
            left: 47%;
            transform: translate(-37%, -47%);
            -ms-transform: translate(-37%, -47%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .mdp {
            position: absolute;
            top: 30%;
            left: 40%;
            transform: translate(-30%, -40%);
            -ms-transform: translate(-30%, -40%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .prd {
            position: absolute;
            top: 20%;
            left: 60%;
            transform: translate(-20%, -60%);
            -ms-transform: translate(-20%, -60%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .ios {
            position: absolute;
            top: 39%;
            left: 63%;
            transform: translate(-39%, -63%);
            -ms-transform: translate(-39%, -63%);
            cursor: pointer;
            border: 2px solid #fff;
        }
        .panel-body .hc {
            position: absolute;
            top: 30%;
            left: 70%;
            transform: translate(-30%, -70%);
            -ms-transform: translate(-30%, -70%);
            cursor: pointer;
            border: 2px solid #fff;
        }
    </style>
@endpush
@section('content')
    <h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br>
        <small>Login to one of Many Web Application </small>
    </h1>
    <div class="panel panel-inverse">
        <div class="panel-body">            
            <button class="btn btn-success qa"><i class="fa-solid fa-microscope"></i> QA Dept</button>
            <button class="btn btn-success whs"><i class="fa-solid fa-warehouse"></i> WHS Dept</button>
            <button class="btn btn-success eng"><i class="fa-solid fa-user-gear"></i> ENG Dept</button>
            <button class="btn btn-success bda"><i class="fa-solid fa-envelope"></i> BDA Dept</button>
            <button class="btn btn-success mdp"><i class="fa-solid fa-timeline"></i> MDP Dept</button>
            <button class="btn btn-success prd"><i class="fa-solid fa-gear"></i> PRD Dept</button>
            <button class="btn btn-success ios"><i class="fa-solid fa-chart-pie"></i> IOS Dept</button>
            <button class="btn btn-success hc"><i class="fa-solid fa-users"></i> HC Dept</button>
            <?xml version="1.0" encoding="UTF-8"?>
            <!-- Do not edit this file with editors other than diagrams.net -->
            <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
        </div>
    </div>    
@endsection