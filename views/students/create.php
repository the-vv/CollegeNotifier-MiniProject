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
                    <form class="row gx-1 align-items-end" action="students/submit" method="POST">
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
                <p>
                    &nbsp;</p>
                <div id="div1" style="width: '100%';" align="center">
                </div>
                <br />
                <br />
                <input type="button" value="Click To Read Your Cell (1,1) Value" onclick="ReadData(1,1);" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-target="#modelSingle" data-bs-toggle="modal"
                    data-bs-dismiss="modal">Create single</button>
                <button type="button" class="btn btn-primary" id="submitMultiple">Submit</button>
            </div>
        </div>
    </div>
</div>

<script language = "javascript" >
    function ReadData(cell, row) {
        var excel = new ActiveXObject("Excel.Application");
        var excel_file = excel.Workbooks.Open("C:\\RS_Data\\MyFile.xls");
        var excel_sheet = excel.Worksheets("Sheet1");
        var data = excel_sheet.Cells(cell, row).Value;
        document.getElementById('div1').innerText = data;
    }
</script>