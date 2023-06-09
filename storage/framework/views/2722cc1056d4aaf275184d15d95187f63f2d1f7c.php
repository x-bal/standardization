
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css')); ?>">
    <style>
        .highcharts-data-table table {
            min-width: 360px;
            max-width: 800px;
            margin: 1em auto;
        }

            .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item active"><a href="javascript:;">Dashboard</a></li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">PT Kalbe Morinaga Indonesia
        <br><small>Monitoring RO Online</small>
    </h1>
	<!-- END page-header -->
    <div class="row">
        <div class="col-12 ui-sortable">
            <div class="panel panel-inverse">
                <div class="panel-body">
                    <div id="widget" class="row">
                        
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col">
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control datepicker" name="start" placeholder="Date Time Start">
                                        <span class="input-group-text input-group-addon">to</span>
                                        <input type="text" class="form-control datepicker" name="end" placeholder="Date Time End">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <button onclick="filterBtn()" class="btn btn-sm btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Filter</button>
                            <button class="btn btn-danger btn-sm" onclick="resetBtn()"><i class="fa-solid fa-times"></i> Reset</button>
                        </div>
                    </div>
                    <div class="row p-3 mb-3">
                        <div class="col justify-content-center">
                            <div id="timeseries"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/highcharts/highcharts.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/accessibility.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/exporting.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/export-data.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/highcharts/indicators.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js')); ?>"></script>
    <script>
        function chartData(categories, datas){            
            Highcharts.chart('timeseries', {
                    chart: {
                        zoomType: 'x'
                    },
                    title: {
                        text: 'RO Online Chart',
                        align: 'center'
                    },
                    subtitle: {
                        text: document.ontouchstart === undefined ?
                        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in',
                        align: 'center'
                    },
                    xAxis: {
                        categories: categories,
                        // labels: {
                        //     style: {
                        //         textOverflow:'none'
                        //     }
                        // }
                    },
                    yAxis: {
                        title: {
                            text: 'RO Value'
                        }
                    },
                    legend: {
                        enabled: true
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                                ]
                            },
                        },
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    exporting: {
                        csv: {
                            dateFormat: '%Y'
                        }
                    },
            
                    series: datas
                });
        }
        function groupArray(datas, param){      
            if (param == 'chart') {            
                grouped = datas.reduce((r, v, i, a) => {
                    if (typeof a[i - 1] === 'undefined') {
                        r.push([v]);
                    } else {
                        if (v.txtLineProcessName === a[i - 1].txtLineProcessName) {
                            r[r.length - 1].push(v);
                        } else {
                            r.push(v.txtLineProcessName === a[i + 1].txtLineProcessName ? [v] : v);
                        }
                    }
                    return r;
                }, []);                    
            } else { 
                grouped = datas.reduce((r, v, i, a) => {
                    if (typeof a[i - 1] === 'undefined') {
                        r.push([v]);
                    } else {
                        if (v.txtLineProcessName === a[i - 1].txtLineProcessName) {
                            r[r.length - 1].push(v);
                        } else {
                            r.push(v.txtLineProcessName === a[i + 1].txtLineProcessName ? [v] : v);
                        }
                    }
                    return r;
                }, []);    
            }
            return grouped;
        }
        function groupWidget(datas){
            grouped = datas.reduce((r, v, i, a) => {
                    if (typeof a[i - 1] === 'undefined') {
                        r.push([v]);
                    } else {
                        if (v.txtLineProcessName.slice(0, -1) === a[i - 1].txtLineProcessName.slice(0, -1)) {
                            r[r.length - 1].push(v);
                        } else {
                            if (typeof a[i + 1] != 'undefined') {                                
                                r.push(v.txtLineProcessName.slice(0, -1) === a[i + 1].txtLineProcessName.slice(0, -1) ? [v] : v);
                            } else {
                                r.push([v]);
                            }
                        }
                    }
                    return r;
                }, []); 
                return grouped;
        }
        function ajaxChart(startDate = false, endDate = false){
            $.ajax({
                url: "<?php echo e(route('roonline.chart')); ?>",
                type: "GET",
                data: {
                    'start': startDate,
                    'end': endDate
                },
                dataType: "JSON",
                success: function(response){
                    let categories = [];
                    let seriesData = [];
                    let datas = response.data;
                    let floatVal = groupArray(datas, 'chart');
                    for (let i = 0; i < floatVal.length; i++) {
                        let series = {
                            type: 'area'
                        };
                        let chartVal = floatVal[i];
                        let resultVal = [];
                        $.each(chartVal, function(i, val){
                            Object.assign(series, {name: val.txtLineProcessName});
                            resultVal.push(val.floatValues);
                        });
                        Object.assign(series, {data: resultVal});
                        seriesData.push(series);
                    }
                    $.each(datas, function(i, val){
                        categories.push(val.xAxis);
                    })
                    chartData(categories, seriesData);
                }
            })
        }
        function filterBtn(){
            let start = $('input[name="start"]').val();
            let end = $('input[name="end"]').val();
            ajaxChart(start, end);
        }
        function resetBtn(){
            $('input[name="start"], input[name="end"]').val('');
            ajaxChart();
        }
        function widget(){
            let wrapper = $('#widget');
            wrapper.empty();
            $.get("<?php echo e(route('roonline.widget')); ?>", function(response){
                let datas = response.data;
                let dataGroup = groupWidget(datas);
                console.log(dataGroup);
                $.each(dataGroup, function(i, value){
                    let midrow = '';
                    let column = '';
                    let list = '';
                    midrow += '<div class="col">'+
                                '<div class="panel">'+
                                    '<div class="panel-body">'+
                                        '<h4>'+value[0].txtLineProcessName.slice(0, -1)+'</h4>'+
                                        '<div id="'+value[0].txtLineProcessName.slice(0, -1).replace(/\s/g, '')+'" class="row"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    wrapper.append(midrow);
                    //Over 2% : #fd97ff
                    //Offline : #8990a4
                    $.each(value, function(idx, val){
                        column += '<div class="col">'+
                                        '<div class="widget widget-stats bg-primary">'+
                                            '<div class="stats-icon stats-icon-lg"><i class="fa fa-cube fa-fw"></i></div>'+
                                            '<div class="stats-content">'+
                                            '<div class="stats-title"><Strong>'+val.txtLineProcessName+'</strong></div>'+
                                            '<div class="stats-number text-center">'+val.floatValues+'%</div>'+
                                            '<div class="stats-desc text-center">Status: <strong>'+val.txtStatus+'</strong></div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                                });
                    $('#'+value[0].txtLineProcessName.slice(0, -1).replace(/\s/g, '')).append(column);
                    list = '<div class="row">'+
                            '<div class="widget-list rounded mb-4" data-id="widget">'+
                                '<div class="widget-list-item">'+
                                    '<div class="widget-list-media icon">'+
                                        '<i class="fa fa-clipboard bg-info text-white"></i>'+
                                    '</div>'+
                                    '<div class="widget-list-content">'+
                                        '<h4 class="widget-list-title">OKP :</h4>'+
                                    '</div>'+
                                    '<div class="widget-list-action text-end">'+
                                        '<h4 class="widget-list-title">'+value[0].txtBatchOrder+'</h4>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="widget-list-item">'+
                                    '<div class="widget-list-media icon">'+
                                        '<i class="fa fa-note-sticky bg-teal text-white"></i>'+
                                    '</div>'+
                                    '<div class="widget-list-content">'+
                                        '<h4 class="widget-list-title">Product :</h4>'+
                                    '</div>'+
                                    '<div class="widget-list-action text-end">'+
                                        '<h4 class="widget-list-title">'+value[0].txtProductName+'</h4>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="widget-list-item">'+
                                    '<div class="widget-list-media icon">'+
                                        '<i class="fa fa-calendar bg-purple text-white"></i>'+
                                    '</div>'+
                                    '<div class="widget-list-content">'+
                                        '<h4 class="widget-list-title">Product :</h4>'+
                                    '</div>'+
                                    '<div class="widget-list-action text-end">'+
                                        '<h4 class="widget-list-title">'+(value[0].txtProductionCode == 'undefined'?value[1].txtProductionCode+'/'+value[1].dtmExpireDate:value[0].txtProductionCode+'/'+value[0].dtmExpireDate)+'</h4>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    $('#'+value[0].txtLineProcessName.slice(0, -1).replace(/\s/g, '')).after(list);
                });
            })
        }
    $(document).ready(function(){
        $(".datepicker").datetimepicker({
            todayHighlight: true,
            autoclose: true
        });
        // setInterval(() => {
        //     widget();
        //     ajaxChart();
        // }, 6000);
        widget();
        ajaxChart();
    })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('roonline::layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mac/Documents/tazaka/standardization/Modules/ROonline/Resources/views/pages/dashboard.blade.php ENDPATH**/ ?>