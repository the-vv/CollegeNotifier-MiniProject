<?php
$cid = 0;
$bid = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
} else {
    $error_mess = 'Required Params are not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php'; 
    die();
}
if (isset($query_params['bid'])) {
    $bid = $query_params['bid'];
} else {
    $error_mess = 'Required Params are not provided';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';   
    die();
}
$batch = get_batch($query_params['bid']);
if(isset($batch[0])) {
    $batch = $batch[0];
} else {
    $error_mess = 'Invalid Batch ID';
    require $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php'; 
    die();
}
// echo "<pre>"; print_r($batch);
// echo "</pre>";
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Edit Batch </h2>
            <form class="mt-4" action="/batch/submit?cid=<?php echo $cid ?>&bid=<?php echo $bid ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Enter Starting Month</label>
                    <input type="month" class="form-control" name="smonth" id="name" required
                        aria-describedby="nameHelp" placeholder="Starting month"
                        value="<?php echo $batch['start_year'];?>-<?php echo str_pad($batch['start_month'], 2, '0', STR_PAD_LEFT);?>">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Enter ending Month</label>
                    <input type="month" class="form-control" name="emonth" id="name" required
                        aria-describedby="nameHelp" placeholder="Ending month"
                        value="<?php echo $batch['end_year'];?>-<?php echo str_pad($batch['end_month'], 2, '0', STR_PAD_LEFT);?>">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'];?>">
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="update">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>