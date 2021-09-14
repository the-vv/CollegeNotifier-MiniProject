<!-- 
    JavaScript Data Table Plugin -->
<script src="/js-vendor/jsPDF/dist/jspdf.min.js"></script>
<script type="text/javascript" src="/js-vendor/FathGrid-master/dist/FathGrid.js"></script>

<?php
$cid = $query_param_values['cid'];
if ($cid == 0) {
    $error_mess = 'CID not provided';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
$college = get_college($cid)[0];

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/department.php';
$departments = get_dpts($query_params['cid']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border pt-2" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a href="/college?cid=<?php echo $cid; ?>">Administration</a></li>
        <li class="breadcrumb-item">Departments</li>
    </ol>
    <div class="row pt-4">
        <h3 class="text-center">Departments Management</h3>
    </div>
    <div class="row pb-5 overflow-auto">
        <table class="table table-success table-striped table-bordered rounded" id="departmentslist">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Total Batches</th>
                    <th scope="col">Total Classes</th>
                    <th scope="col">Total Faculties</th>
                    <th scope="col">Total Students</th>
                    <th scope="col">Total Events</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1;
                foreach ($departments as $dpt) {
                    $batches = get_batches($query_params['cid'], $dpt['id']);
                    $batches_count = count($batches);
                    $classes_count = 0;
                    foreach ($batches as $b) {
                        $c_count = count(get_classes($dpt['id'], $query_params['cid'], $b['id']));
                        $classes_count += $c_count;
                    }
                    $students_count = count(get_students_from_dpt($dpt['id']));
                    $category_name = strlen($dpt['category']) ? $dpt['category'] : '-';
                    $events_count = count(get_events_by_dpt( $query_params['cid'], $dpt['id']));
                    echo "<tr>
                        <td scope='row'>{$dpt['id']}</td>
                        <td scope='row'>{$count}</td>
                        <td>{$dpt['dpt_name']}</td>
                        <td>$category_name</td>
                        <td>{$batches_count}</td>
                        <td>{$classes_count}</td>
                        <td>-</td>
                        <td>{$students_count}</td>
                        <td>{$events_count}</td>
                    </tr>";
                    $count++;
                } ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
'use strict';

let gridOptions = {
    onChange: function(data, col, old, value) {
        console.log(data);
    },
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
            html: (item) => {
                return `
                    <a href='/department?cid=<?php echo $cid ?>&did=${item[1]}' type='button' class='btn btn-sm btn-primary p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-eye'></i></a>       
                    <a href='/departments/edit?cid=<?php echo $cid ?>&did=${item[0]}' type='button' class='btn btn-sm btn-warning p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-pencil-square'></i></a>                        
                    <button type='button' class='btn btn-sm btn-danger p-1 px-xl-2 m-0 border border-dark'
                        onclick="deleteDpt('${[item[0]]}', '${[item[2]]}')">
                    <i class='bi bi-trash-fill'></i></button>
                `;
            }
        },
    ]
}
let myDataTable = FathGrid("departmentslist", gridOptions);

function deleteDpt(id, name, email) {
    $.confirm({
        theme: 'material',
        containerFluid: true,
        backgroundDismiss: true,
        title: 'Confirm Delete!',
        content: `Are you sure want to delete the Department:<br><strong class="h4 d-block">${name}</strong><br><i class="text-danger"><strong>Warning:</strong> All the batches, classes and events under ${name} department will be deleted and the students under the ${name} department will be unmapped!</i>`,
        type: 'red',
        icon: 'bi bi-trash-fill',
        bgOpacity: 0.8,
        buttons: {
            confirm: {
                btnClass: 'btn btn-danger',
                action: () => {
                    $.getJSON(`/services/department/deleteone?cid=<?php echo $query_params['cid']; ?>&did=${id}`, (res) => {
                        if (res.success) {
                            myDataTable.getData().forEach((el, index) => {
                                if (el[0] == id) {
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
                    }).fail(err => {
                        $.toast({
                                heading: 'Error',
                                text: "Error occured while deleting Department",
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right',
                            })
                    });
                }
            },
            cancel: () => {}
        }
    })
}
$('#departmentslist thead tr.filter th input').attr('placeholder', 'Search').addClass('form-control py-0');
</script>
