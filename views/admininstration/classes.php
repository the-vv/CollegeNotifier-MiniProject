<!-- JavaScript Data Table Plugin -->
<script src="/jsLibs/jsPDF/dist/jspdf.min.js"></script>
<script type="text/javascript" src="/jsLibs/FathGrid-master/dist/FathGrid.js"></script>

<?php
$cid = $query_param_values['cid'];
if ($cid == 0) {
    $error_mess = 'CID not provided';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/college.php';
$college = get_college($cid)[0];

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
$classes = get_all_classes($query_params['cid']);
// echo "<pre>";
// print_r($classes);
// echo "</pre>";
// die();
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a href="/college?cid=<?php echo $cid; ?>">Administration</a></li>
        <li class="breadcrumb-item">Classes</li>
    </ol>
    <div class="row pt-2">
        <h3 class="text-center">Classes Management</h3>
    </div>
    <div class="row pb-5 overflow-auto">
        <table class="table table-success table-striped table-bordered rounded" id="departmentslist">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">DPT_ID</th>
                    <th scope="col">BATCH_ID</th>
                    <th scope="col">No</th>
                    <th scope="col">Division Name</th>
                    <th scope="col">Batch</th>
                    <th scope="col">Department</th>
                    <th scope="col">Total Faculties</th>
                    <th scope="col">Total Students</th>
                    <th scope="col">Total Events</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($classes as $class) {
                    $students_count = count(get_students_from_class($class['id']));
                    $events_count = count(get_events_by_class($query_params['cid'], $class['dpt_id'], $class['batch_id'], $class['id']));
                    echo "<tr>
                        <td scope='row'>{$class['id']}</td>
                        <td scope='row'>{$class['dpt_id']}</td>
                        <td scope='row'>{$class['batch_id']}</td>
                        <td scope='row'>{$count}</td>
                        <td>{$class['division']}</td>
                        <td>{$class['start_year']} - {$class['end_year']}</td>
                        <td>{$class['dpt_name']}({$class['dpt_category']})</td>
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
            editable: false,
            visible: false
        },
        {
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
            editable: false,
        },
        {
            printable: false,
            editable: false,
            html: (item) => {
                return `
                    <a href='/class?cid=<?php echo $cid ?>&clid=${item[0]}&did=${item[1]}&bid=${item[2]}' type='button' class='btn btn-sm btn-primary p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-eye'></i></a>                        
                    <a href='/class/edit?cid=<?php echo $cid ?>&clid=${item[0]}' type='button' class='btn btn-sm btn-warning p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-pencil-square'></i></a>                        
                    <button type='button' class='btn btn-sm btn-danger p-1 px-xl-2 m-0 border border-dark'
                        onclick="deleteClass('${item[0]}', '${item[4]}', '${item[1]}', '${item[2]}')">
                    <i class='bi bi-trash-fill'></i></button>
                `;
            }
        },
    ]
}
let myDataTable = FathGrid("departmentslist", gridOptions);

function deleteClass(id, name, did, bid) {
    $.confirm({
        theme: 'material',
        containerFluid: true,
        backgroundDismiss: true,
        title: 'Confirm Delete!',
        content: `Are you sure want to delete the Class:<br><strong class="h4 d-block">${name}</strong><br><i class="text-danger"><strong>Warning:</strong> All the events under ${name} class will be deleted and the students under the ${name} class will be unmapped!</i>`,
        type: 'red',
        icon: 'bi bi-trash-fill',
        bgOpacity: 0.8,
        buttons: {
            confirm: {
                btnClass: 'btn btn-danger',
                action: () => {
                    HoldOn.open({ theme: 'sk-fading-circle', message: 'Please wait...' });
                    $.getJSON(
                        `/services/class/deleteone?cid=<?php echo $query_params['cid']; ?>&bid=${bid}&did=${did}&clid=${id}`,
                        (res) => {
                        HoldOn.close();
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
                        HoldOn.close();
                        $.toast({
                            heading: 'Error',
                            text: "Error occured while deleting Class",
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