<!-- JavaScript Data Table Plugin -->
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

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
$batches = get_all_batches($query_params['cid']);
// echo "<pre>";
// print_r($batches);
// echo "</pre>";
// die();
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/batch.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/student.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
?>

<div class="container-fluid bg-light mx-md-4 shadow rounded border" id="departments" style="min-height: 85vh">
    <ol class="breadcrumb" style="--bs-breadcrumb-divider: '>';">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/admin"><?php echo $college['college_name'] ?></a></li>
        <li class="breadcrumb-item"><a href="/college?cid=<?php echo $cid; ?>">Administration</a></li>
        <li class="breadcrumb-item">Batches</li>
    </ol>
    <div class="row pt-2">
        <h3 class="text-center">Batches Management</h3>
    </div>
    <div class="row pb-5 overflow-auto">
        <table class="table table-success table-striped table-bordered rounded" id="departmentslist">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">DPT_ID</th>
                    <th scope="col">No</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col">Department</th>
                    <th scope="col">Total Classes</th>
                    <th scope="col">Total Faculties</th>
                    <th scope="col">Total Students</th>
                    <th scope="col">Total Events</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                foreach ($batches as $batch) {
                    $classes_count =  count(get_classes($batch['dpt_id'], $query_params['cid'], $batch['id']));
                    $students_count = count(get_students_from_batch($batch['id']));
                    $events_count = count(get_events_by_batch($query_params['cid'], $batch['dpt_id'], $batch['id']));
                    $start_date_obj = DateTime::createFromFormat('!m', $batch['start_month']);
                    $start_month = $start_date_obj->format('F');
                    $end_date_obj = DateTime::createFromFormat('!m', $batch['end_month']);
                    $end_month = $end_date_obj->format('F');
                    echo "<tr>
                        <td scope='row'>{$batch['id']}</td>
                        <td scope='row'>{$batch['dpt_id']}</td>
                        <td scope='row'>{$count}</td>
                        <td>" . $start_month . '-' . $batch['start_year'] . "</td>
                        <td>" . $end_month . '-' . $batch['end_year'] . "</td>
                        <td>{$batch['dpt_name']}({$batch['dpt_category']})</td>
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
            editable: false,
        },
        {
            printable: false,
            editable: false,
            html: (item) => {
                return `
                    <a href='/batch?cid=<?php echo $cid ?>&bid=${item[0]}&did=${item[1]}' type='button' class='btn btn-sm btn-primary p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-eye'></i></a>                        
                    <a href='/batch/edit?cid=<?php echo $cid ?>&bid=${item[0]}' type='button' class='btn btn-sm btn-warning p-1 px-xl-2 m-0 border border-dark'>
                    <i class='bi bi-pencil-square'></i></a>                        
                    <button type='button' class='btn btn-sm btn-danger p-1 px-xl-2 m-0 border border-dark'
                        onclick="deleteBatch('${[item[0]]}', '${[item[3]]} ${[item[4]]}', '${[item[1]]}')">
                    <i class='bi bi-trash-fill'></i></button>
                `;
            }
        },
    ]
}
let myDataTable = FathGrid("departmentslist", gridOptions);

function deleteBatch(id, name, did) {
    $.confirm({
        theme: 'material',
        containerFluid: true,
        backgroundDismiss: true,
        title: 'Confirm Delete!',
        content: `Are you sure want to delete the Batch:<br><strong class="h4 d-block">${name}</strong><br><i class="text-danger"><strong>Warning:</strong> All the classes and events under ${name} batch will be deleted and the students under the ${name} Batch will be unmapped!</i>`,
        type: 'red',
        icon: 'bi bi-trash-fill',
        bgOpacity: 0.8,
        buttons: {
            confirm: {
                btnClass: 'btn btn-danger',
                action: () => {
                    HoldOn.open({ theme: 'sk-fading-circle', message: 'Please wait...' });
                    $.getJSON(
                        `/services/batch/deleteone?cid=<?php echo $query_params['cid']; ?>&bid=${id}&did=${did}`,
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
                            text: "Error occured while deleting Batch",
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