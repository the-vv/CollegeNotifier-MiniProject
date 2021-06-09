<?php
$cid = 0;
$did = 0;
if (isset($query_params['cid'])) {
    $cid = $query_params['cid'];
}
if (isset($query_params['did'])) {
    $did = $query_params['did'];
}
?>
<div class="container shadow border rounded rounded-lg">
    <div class="row">
        <div class="col-12 p-5">
            <h2 class="text-center"> Create Batch now </h2>
            <form class="mt-4" action="submit?cid=<?php echo $cid ?>&did=<?php echo $did ?>" method="POST">
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Enter Starting Month</label>
                    <input type="month" class="form-control" name="smonth" id="name" required
                        aria-describedby="nameHelp" placeholder="Starting month">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="form-group mx-auto col-md-6 mt-3">
                    <label for="name">Enter ending Month</label>
                    <input type="month" class="form-control" name="emonth" id="name" required
                        aria-describedby="nameHelp" placeholder="Ending month">
                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5" name="create">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>