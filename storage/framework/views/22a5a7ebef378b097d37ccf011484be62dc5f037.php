<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<!-- BEGIN breadcrumb -->
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item active"><a href="javascript:;">Dashboard</a></li>
</ol>
<!-- END breadcrumb -->
<!-- BEGIN page-header -->
<h1 class="page-header">PT Kalbe Morinaga Indonesia
    <br><small>Dashboard Module Faceid</small>
</h1>
<!-- END page-header -->

<div class="row">
    <div class="col-12 ui-sortable">
        <form action="" method="get" id="form-filter" class="row">
            <div class="form-group col-md-3 mb-3">
                <label for="month">Month</label>
                <input type="month" name="month" id="month" class="form-control" value="<?php echo e(request('month') ?? Carbon\Carbon::now('Asia/Jakarta')->format('Y-m')); ?>">
            </div>

            <div class="form-group col-md-3 mb-3">
                <label for="from">From</label>
                <select name="from" id="from" class="form-control">
                    <option disabled selected>-- Select Date --</option>
                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($date); ?>" <?php echo e(request('from') == $date ? 'selected' : ''); ?>><?php echo e($date); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group col-md-3 mb-3">
                <label for="to">To</label>
                <select name="to" id="to" class="form-control">
                    <option disabled selected>-- Select Date --</option>
                    <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dt); ?>" <?php echo e(request('to') == $dt ? 'selected' : ''); ?>><?php echo e($dt); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group col-md-3 mb-3">
                <label for="department">Department</label>
                <select name="department" id="department" class="form-control">
                    <option selected>-- All Department --</option>
                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept->intDepartment_ID); ?>" <?php echo e(request('department') == $dept->intDepartment_ID ? 'selected' : ''); ?>><?php echo e($dept->txtDepartmentName); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group col-md-3 mb-3">
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </div>
        </form>
        <div class="panel panel-inverse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center">Rekap Status GMP per-Tanggal</h5>
                                <canvas id="count-gmp"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center">Rekap Status Hygiene Declare per-Tanggal</h5>
                                <canvas id="count-health"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center">Hygiene Declare</h5>
                                <canvas id="health-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('/')); ?>plugins/chart.js/dist/chart.min.js"></script>

<script>
    $("#month").on('change', function() {
        $("#form-filter").submit()
    })
</script>

<script>
    let gmpok = <?php echo json_encode($gmpok, 15, 512) ?>;
    let gmpnok = <?php echo json_encode($gmpnok, 15, 512) ?>;
    let newdateList = <?php echo json_encode($newdateList, 15, 512) ?>;

    let counthealth = "<?php echo e($counthealth); ?>"
    let countnothealth = "<?php echo e($countnothealth); ?>";

    let dailyhealth = <?php echo json_encode($dailyhealth, 15, 512) ?>;
    let dailynothealth = <?php echo json_encode($dailynothealth, 15, 512) ?>;

    let totalDaily = <?php echo json_encode($totalDaily, 15, 512) ?>;
    let dates = <?php echo json_encode($dates, 15, 512) ?>;

    let temps = <?php echo json_encode($temps, 15, 512) ?>;
    let users = <?php echo json_encode($users, 15, 512) ?>;

    var ctx = document.getElementById('count-gmp').getContext('2d');
    var barChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: newdateList,
            datasets: [{
                label: 'GMP OK',
                borderWidth: 2,
                borderColor: "#068FFF",
                backgroundColor: "#068FFF",
                data: gmpok
            }, {
                label: 'GMP NOK',
                borderWidth: 2,
                borderColor: "#EB8242",
                backgroundColor: "#EB8242",
                data: gmpnok
            }]
        }
    });

    var ctx2 = document.getElementById('count-health').getContext('2d');
    var barChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: newdateList,
            datasets: [{
                label: 'Health OK',
                borderWidth: 2,
                borderColor: "#068FFF",
                backgroundColor: "#068FFF",
                data: dailyhealth
            }, {
                label: 'Health NOK',
                borderWidth: 2,
                borderColor: "#EB8242",
                backgroundColor: "#EB8242",
                data: dailynothealth
            }]
        }
    });

    var ctx3 = document.getElementById('health-chart').getContext('2d');
    var barChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Total',
                borderWidth: 2,
                borderColor: "#068FFF",
                backgroundColor: "#068FFF",
                data: totalDaily
            }, ]
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('faceid::layouts.default_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/mac/Documents/tazaka/standardization/Modules/Faceid/Resources/views/index.blade.php ENDPATH**/ ?>