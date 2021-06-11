<?php
$cid = isset($query_params['cid']) ? $query_params['cid'] : 0;
$did = isset($query_params['did']) ? $query_params['did'] : 0;
$bid = isset($query_params['bid']) ? $query_params['bid'] : 0;
$clid = isset($query_params['clid']) ? $query_params['clid'] : 0;
$submit_url_params = "cid=$cid&did=$did&bid=$bid&clid=$clid";
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary rounded rounded-pill w-100" data-bs-toggle="modal"
    id="studentAdd" data-bs-target="#modelMultiple">
    Create/Add
</button>

<!-- Modal -->
<div class="modal fade" id="modelSingle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <p class="h6 text-start">Create single student:</p>
                    <form class="row gx-1 align-items-end" action="students/submit?<?php echo $submit_url_params ?>" method="POST" id="singleForm">
                        <div class="form-group col-12 col-md-6 text-start">
                            <label for="exampleInputEmail1">Full Name*</label>
                            <input type="text" class="form-control" name="name" id="sname" required
                                aria-describedby="categoryHelp" placeholder="Enter Name">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-12 col-md-6 text-start">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" class="form-control" name="phone" id="snumber"
                                aria-describedby="categoryHelp" placeholder="Enter phone">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-12 col-md-6 text-start mt-2">
                            <label for="name">Email Id*</label>
                            <input type="text" class="form-control" name="email" id="semail" required
                                aria-describedby="nameHelp" placeholder="Create Email">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <!-- <div class="text-center col-4 col-md-2">
                            <button type="submit" class="btn btn-primary col-12" name="create">Create</button>
                        </div> -->
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#modelMultiple" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Create Multiple Students</button>
                <button type="button" class="btn btn-primary" id="singleSubmit" disabled>Submit</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modelMultiple" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="students/submit?<?php echo $submit_url_params ?>&multiple=1" method="post"
                    enctype="multipart/form-data" id="fileForm">
                    <div class="mb-3 text-start">
                        <label for="formFile" class="form-label">Select Excel files with student details</label>
                        <input class="form-control" type="file" id="formFile" class="btn btn-primary" name="students"
                            required>
                    </div>
                </form>
                <div class="text-end"><a href="/uploads/students-template.xlsx" download> Download template Excel
                        here</a></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#modelSingle" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Create Single Student</button>
                <button type="button" class="btn btn-primary" id="submitMultiple" disabled>Submit</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
document.getElementById("singleForm").oninput = function() {
    if (document.getElementById("sname").value &&
        document.getElementById("semail").value
    ){
        document.getElementById("singleSubmit").disabled = false;
    }else {
        document.getElementById("singleSubmit").disabled = true;
    }
}
document.getElementById("singleSubmit").onclick = function() {
    if (document.getElementById("sname").value &&
        document.getElementById("semail").value
    ) {
        document.getElementById("singleForm").submit();
    }
}
document.getElementById('fileForm').onchange = function() {
    if (document.getElementById("formFile").value) {
        document.getElementById("submitMultiple").disabled = false;
    } else {        
        document.getElementById("submitMultiple").disabled = true;
    }
}
document.getElementById("submitMultiple").onclick = function() {
    if (document.getElementById("formFile").value) {
        document.getElementById('fileForm').submit();
    } else {}
}
</script>