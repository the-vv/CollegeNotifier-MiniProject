<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/form_submissions.php';
if (isset($query_params['fid'])) {
    $formdata = get_form($query_params['fid'])[0];
} else {
    $error_mess = "Form Id not provided";
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/show_error.php';
    die();
}
$submissions = get_submissions_by_formid($query_params['fid']);
// print_r($submissions);


$cid = $query_params['cid'] ?? 0;
$did = $query_params['did'] ?? 0;
$bid = $query_params['bid'] ?? 0;
$clid = $query_params['clid'] ?? 0;
$rid = $query_params['rid'] ?? 0;

if ($rid) {
    $mapper = new RoomStudentMap();
    $students = $mapper->get_all_students_in_room($cid, $rid);
} elseif ($clid) {
    $students = get_students_from_class($clid);
} elseif ($bid) {
    $students = get_students_from_batch($bid);
} elseif ($did) {
    $students = get_students_from_dpt($did);
} elseif ($cid) {
    $students = get_students_from_college($cid);
}

?>

<script src="/jsLibs/form-builder/form-render.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js"
    integrity="sha512-tMabqarPtykgDtdtSqCL3uLVM0gS1ZkUAVhRFu1vSEFgvB73niFQWJuvviDyBGBH22Lcau4rHB5p2K2T0Xvr6Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="container-fluid bg-light mx-md-4 shadow rounded mb-4" id="departments" style="min-height: 85vh">
    <div class="row my-4" id="printContents">
        <div class="col-12">
            <p class="h3 text-center">Form Submissions of <?php echo $formdata['title'] ?> </p>
        </div>
        <div id="charts text-center d-flex justify-content-center">
            <canvas id="submissionsCount" width="300px" height="300px" style="margin: auto;"> </canvas>
        </div>
        <div class="col-12 text-center pt-4">
            <button class="btn btn-primary" onclick="exportPrint()">Save Report</button>
        </div>
        <div class="col-12 mt-4">
            <p class="h3 text-center">Submission List</p>
        </div>
        <div class="offset-md-2 col-md-8 mt-3">
            <div class="accordion" id="accordionFlushExample">
                <?php foreach ($submissions as $submission) { ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="acc_id_<?php echo $submission['id'] ?>">
                        <button class="accordion-button collapsed d-flex justify-content-between" type="button"
                            data-bs-toggle="collapse" data-bs-target="#flush-<?php echo $submission['id'] ?>"
                            aria-expanded="false" aria-controls="flush-<?php echo $submission['id'] ?>">
                            <p class="m-0 p-0">
                                <span class="fw-bold"><?php echo $submission['user']['name'] ?></span>&nbsp;|&nbsp;<span
                                    class="fst-italic fw-light"><?php echo $submission['user']['email'] ?>
                                </span>
                            </P>
                            <p class="m-0 p-0 d-block mx-1">
                                (<span class="sub_time"><?php echo $submission['submission_time'] ?></span>)
                            </p>
                        </button>
                    </h2>
                    <div id="flush-<?php echo $submission['id'] ?>" class="accordion-collapse collapse"
                        aria-labelledby="acc_id_<?php echo $submission['id'] ?>"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div id="render_wrap_<?php echo $submission['id'] ?>"></div>
                            <script>
                            $('#render_wrap_<?php echo $submission['id'] ?>').formRender({
                                formData: '<?php echo $submission['user_data'] ?>'
                            })
                            </script>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

</script>
<script>
$(".accordion-body :input").prop("readonly", true);
$(document).ready(() => {
    $("li.formbuilder-icon-file").hide()
});

$('.sub_time').each(function(index, element) {
    console.log($(this).html())
    let date = new Date($(this).html() * 1000).toLocaleTimeString("en-US", {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    })
    $(this).html(date)
})

const ctx = document.getElementById('submissionsCount');
const myChart = new Chart(ctx, {
    plugins: [ChartDataLabels],
    type: 'pie',
    data: {
        labels: ['Submitted', 'Not Submitted'],
        datasets: [{
            label: 'Submissions',
            data: [
                <?php echo count($submissions) ?>,
                <?php echo count($students) - count($submissions) ?>
            ],
            backgroundColor: ['#0000ff', '#ff0000'],
            hoverBackgroundColor: ['#0000aa', '#aa0000'],
            hoverOffset: 5,
        }]
    },
    options: {
        responsive: false,
        plugins: {
            title: {
                display: true,
                text: `<?php echo $formdata['title'] ?> Submissions Report`,
                font: {
                    size: 18
                }
            },
            datalabels: {
                formatter: (val) => val + ' Student(s)',
                labels: {
                    title: {
                        font: {
                            weight: 'bold',
                        },
                        color: 'white'
                    }
                }
            }
        }
    }
})

function exportPrint() {
    var a = document.createElement('a');
    a.href = myChart.toBase64Image();
    a.download = `<?php echo $formdata['title'] ?> Report`;
    // Trigger the download
    a.click();
}
</script>