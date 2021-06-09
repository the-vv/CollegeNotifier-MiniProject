<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modelSingle">
    Launch static backdrop modal
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
                    <p class="h6">Create single student:</p>
                    <form class="row gx-1 align-items-end" action="submit" method="POST">
                        <div class="form-group col-12 col-md-5">
                            <label for="name">Email Id*</label>
                            <input type="text" class="form-control" name="name" id="name" required
                                aria-describedby="nameHelp" placeholder="Create Email">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-8 col-md-5">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="text" class="form-control" name="category" id="exampleInputcategory1"
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
                <button type="button" class="btn btn-primary" data-bs-target="#modelMultiple" data-bs-toggle="modal"
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
                <div class="col-12">
                    <div class="row align-items-end gx-1">
                        <p class="h6">Generate Multiple student:</p>
                        <div class="form-group col-4 col-md-4">
                            <label for="name">Email template start</label>
                            <input type="text" class="form-control" name="name" id="estart" required
                                aria-describedby="nameHelp" placeholder="Email Start">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-4 col-md-2">
                            <label for="exampleInputEmail1">Variable upto</label>
                            <input type="number" class="form-control" name="category" id="elimit"
                                aria-describedby="categoryHelp" placeholder="Enter limit">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group col-4 col-md-4">
                            <label for="exampleInputEmail1">Email template end</label>
                            <input type="text" class="form-control" name="category" id="eend"
                                aria-describedby="categoryHelp" placeholder="Email End">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="text-center col-4 col-md-2">
                            <button class="btn btn-primary col-12" name="generate" id="generate">Generate</button>
                        </div>
                        <div class="container" id="multipleContanier">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#modelSingle" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Create single</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
document.getElementById("generate").onclick = function() {
    var start = document.getElementById('estart').value;
    var limit = document.getElementById('elimit').value;
    var end = document.getElementById('eend').value;
    console.log(start, limit, end);
    if (document.contains(document.getElementById("multipleForm"))) {
        document.getElementById("multipleForm").remove();
    }
    var studentsForm = document.createElement('form');
    studentsForm.action = 'submit?multiple=1';
    studentsForm.method = 'post';
    studentsForm.id = 'multipleForm'
    studentsForm.classList = ['row gx-1 mt-2']
    var container = document.getElementById('multipleContanier');
    container.appendChild(studentsForm);
    studentsForm.innerHTML = "<div class='col-5'>Email Id List</div><div class='col-5 ms-3'>Name List</div>";
    for (var i = 1; i <= parseInt(limit); i++) {
        var control = document.createElement('input');
        control.type = 'text';
        control.value = start + i + end;
        control.readOnly = true;
        control.name = 'row[' + i + '][email]';
        control.classList = ['col-5  mt-2'];
        var controlroll = document.createElement('input');
        controlroll.type = 'text';
        controlroll.value = start + i + end;
        controlroll.hidden = true;
        controlroll.name = 'row[' + i + '][roll]';
        var controllName = document.createElement('input');
        controllName.type = 'text';
        controllName.value = 'Unknown Name' + i;
        controllName.hidden = false;
        controllName.classList = ['ms-3 col-5 mt-2'];;
        controllName.name = 'row[' + i + '][name]';
        var controllPhone = document.createElement('input');
        controllPhone.type = 'number';
        controllPhone.value = 0;
        controllPhone.hidden = true;
        controllPhone.name = 'row[' + i + '][phone]';
        studentsForm.appendChild(control);
        studentsForm.appendChild(controlroll);
        studentsForm.appendChild(controllName);
        studentsForm.appendChild(controllPhone);
    }
}
</script>