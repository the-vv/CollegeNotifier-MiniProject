<?php
$cid = $query_param_values['cid'];
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/college.php';
$college = get_college($cid)[0];
require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/student.php';
$all_students = get_all_students_bi_cid($cid);
?>

<div class="container border shadow rounded">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item">Students</li>
    </ol>
    <div class="row pt-4">
        <h3 class="text-center">Students Management</h3>
    </div>
    <div class="row pb-5 overflow-auto">
        <table class="table table-success table-striped table-bordered rounded" id="studnetslist">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Department</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Class</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; foreach ($all_students as $stud) {
                    $batch = strlen($stud['start_year']) > 0 ? "{$stud['start_year']} - {$stud['end_year']}" : '-';
                    $dpt = strlen($stud['dpt_name']) > 0 ? "{$stud['dpt_name']}" : '-';
                    $class = strlen($stud['division']) > 0 ? "Division {$stud['division']}" : '-';
                    echo "<tr>
                        <td scope='row'>{$stud['id']}</td>
                        <td scope='row'>{$count}</td>
                        <td>{$stud['student_name']}</td>
                        <td>{$stud['gender']}</td>
                        <td>{$stud['email']}</td>
                        <td>{$stud['phone']}</td>
                        <td>$dpt</td>
                        <td>$batch</td>
                        <td>$class</td>
                        <td></td>
                    </tr>";
                    $count++;
                }?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
'use strict';

let gridOptions = {
    size: 10,
    editable: false,
    showFooter: true,
    showTableTotal: true,
    showGraph: false,
    columns: [{
            editable: false,
            visible: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            editable: false
        },
        {
            printable: false,
            editable: false,
            html: function(item) {
                return `
                <button type='button' class='btn btn-sm btn-danger p-1 px-xl-2 m-0 border border-dark'
                    onclick="deleteStudent('${[item[0]]}', '${[item[2]]}', '${[item[4]]}')">
                <i class='bi bi-trash-fill'></i></button>
                <button type='button' class='btn btn-sm btn-warning p-1 px-xl-2 m-0 border border-dark'>
                <i class='bi bi-pencil-square'></i></button>
                `
            }
        },
    ]
}
let myDataTable = FathGrid("studnetslist", gridOptions);

function deleteStudent(id, name, email) {
    $.confirm({
        theme: 'material',
        containerFluid: true,
        backgroundDismiss: true,
        title: 'Confirm Delete!',
        content: `Are you sure want to delete the student:<br>${name}<br>${email}`,
        type: 'red',
        icon: 'bi bi-trash-fill',
        bgOpacity: 0.8,
        buttons: {
            confirm: {
                btnClass: 'btn btn-danger',
                action: function() {
                    $.getJSON(`/services/students/deleteone?sid=${id}`, function(res) {
                        if (res.success) {
                            myDataTable.getData().forEach(function(el, index) {
                                if(el[0] == id) {
                                    myDataTable.deleteRow(index + 1);
                                }
                            })
                            $.toast({
                                heading: 'Success',
                                text: res.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: 'bottom-right',
                            })
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: res.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right',
                            })
                        }
                    });
                }
            },
            cancel: function() {}
        }
    })
}
</script>