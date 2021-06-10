<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary rounded rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#modelSingle">
    Create/Add
</button>

<!-- Modal -->
<div class="modal fade" id="modelSingle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Students</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <p class="h6 text-start">Create single student:</p>
                    <form class="row gx-1 align-items-end" action="students/submit" method="POST">
                        <div class="form-group col-12 col-md-5 text-start">
                            <label for="name">Email Id*</label>
                            <input type="text" class="form-control" name="email" id="name" required
                                aria-describedby="nameHelp" placeholder="Create Email">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-8 col-md-5 text-start">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputcategory1"
                                aria-describedby="categoryHelp" placeholder="Create Password">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="text-center col-4 col-md-2">
                            <button type="submit" class="btn btn-primary col-12" name="create">Create</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="button" class="btn btn-secondary" data-bs-target="#modelMultiple" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Create Multiple</button>
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
                <form action="students/submit?cid=<?php echo $query_params['id'] ?>" method="post"
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
                    data-bs-dismiss="modal">Create single</button>
                <button type="button" class="btn btn-primary" id="submitMultiple">Submit</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
document.getElementById("submitMultiple").onclick = function() {
    if (document.getElementById("formFile").value) {
        document.getElementById('fileForm').submit();
    } else {
    }
}
</script>