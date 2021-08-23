<?php

$collegeEvents = array();
$dptEvents = array();
$batchEvents = array();
$classEvents = array();
$roomEvents = array();
$allEvents = array();

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/event.php';

// variables used below are coming from parent home.php
if ($cid) {
    $collegeEvents = get_events_by_param($cid);
    foreach ($rids as $r) {
        $te = get_events_by_room($cid, $r);

        foreach ($te as $t) {
            array_push($roomEvents, $t);
        }
    }
    // print_r($roomEvents);
}
if ($did) {
    $dptEvents = get_events_by_param($cid, $did);
}
if ($bid) {
    $batchEvents = get_events_by_param($cid, $did, $bid);
}
if ($clid) {
    $classEvents = get_events_by_param($cid, $did, $bid, $clid);
}

$allEvents = array_merge($collegeEvents, $dptEvents, $batchEvents, $classEvents, $roomEvents);

// echo "<pre>";
// print_r($events);
// echo "</pre>";
function eventItem($e)
{ ?>
    <li class='list-group-item d-flex justify-content-between align-items-center'>
        <a onclick="showEvent('<?php echo $e['id'] ?>')" class="d-inline-block text-truncate h6 text-decoration-none">
            <div class="row">
                <div class="col-auto d-flex align-items-center">
                    <?php if ($e['is_event'] == 0) { ?>
                        <i class="bi bi-app-indicator text-primary d-inline" style="font-size:1.5rem"></i>
                    <?php } else { ?>
                        <i class="bi bi-calendar2-event text-primary d-inline" style="font-size:1.5rem"></i>
                    <?php } ?>
                </div>
                <div class="col-auto">
                    <p class="h6 p-0 m-0">
                        <?php echo $e['title'];
                        if (strlen($e['attatchement']) > 0) { ?>
                            <i class="bi bi-paperclip text-primary" title="Has Attatchement"></i>
                        <?php } ?>
                    </p>
                    <small class="text-muted">
                        <?php echo substr(htmlentities(strip_tags($e['content'])), 0, 200) ?>...
                    </small>
                </div>
            </div>
        </a>
        <span class="d-flex align-items-center event-actions">
            <span class="me-2">
                <?php echo date('d/m/y h:i:s', $e['sendtime']);
                ?>
            </span>
        </span>
    </li>
<?php } ?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button" role="tab" aria-controls="nav-all" aria-selected="true">All</button>
        <?php if ($cid) { ?>
            <button class="nav-link" id="nav-college-tab" data-bs-toggle="tab" data-bs-target="#nav-college" type="button" role="tab" aria-controls="nav-college" aria-selected="false">College</button>
        <?php }
        if ($did) { ?>
            <button class="nav-link" id="nav-department-tab" data-bs-toggle="tab" data-bs-target="#nav-department" type="button" role="tab" aria-controls="nav-department" aria-selected="false">Department</button>
        <?php }
        if ($bid) { ?>
            <button class="nav-link" id="nav-batch-tab" data-bs-toggle="tab" data-bs-target="#nav-batch" type="button" role="tab" aria-controls="nav-batch" aria-selected="false">Batch</button>
        <?php }
        if ($clid) { ?>
            <button class="nav-link" id="nav-class-tab" data-bs-toggle="tab" data-bs-target="#nav-class" type="button" role="tab" aria-controls="nav-class" aria-selected="false">Class</button>
        <?php }
        if (count($roomEvents) > 0) { ?>
            <button class="nav-link" id="nav-rooms-tab" data-bs-toggle="tab" data-bs-target="#nav-rooms" type="button" role="tab" aria-controls="nav-rooms" aria-selected="false">All Rooms</button>
        <?php } ?>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade active show" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="p-0 m-0">
                        All Events/Notifications
                        <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </h5>
                </div>
                <!-- <span>
                    <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </a>
                </span> -->
            </div>
        </div>
        <ul class="list-group">
            <?php foreach ($allEvents as $e) {
                // if ($e['is_event'] == 1) {
                //     continue;
                // }
                eventItem($e);
            } ?>
        </ul>
    </div>
    <?php if ($cid) { ?>
        <div class="tab-pane fade" id="nav-college" role="tabpanel" aria-labelledby="nav-college-tab">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="p-0 m-0">
                            Events/Notifications of College
                            <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                    </div>
                    <span>
                        <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($collegeEvents as $e) {
                    // if ($e['is_event'] == 1) {
                    //     continue;
                    // }
                    eventItem($e);
                } ?>
            </ul>
        </div>
    <?php }
    if ($did) { ?>
        <div class="tab-pane fade" id="nav-department" role="tabpanel" aria-labelledby="nav-department-tab">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="p-0 m-0">
                            Events/Notifications of Departments
                            <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                    </div>
                    <span>
                        <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($dptEvents as $e) {
                    // if ($e['is_event'] == 1) {
                    //     continue;
                    // }
                    eventItem($e);
                } ?>
            </ul>
        </div>
    <?php }
    if ($bid) { ?>
        <div class="tab-pane fade" id="nav-batch" role="tabpanel" aria-labelledby="nav-batch-tab">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="p-0 m-0">
                            Events/Notifications of Batch
                            <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                    </div>
                    <span>
                        <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($batchEvents as $e) {
                    // if ($e['is_event'] == 1) {
                    //     continue;
                    // }
                    eventItem($e);
                } ?>
            </ul>
        </div>
    <?php }
    if ($clid) { ?>
        <div class="tab-pane fade" id="nav-class" role="tabpanel" aria-labelledby="nav-class-tab">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="p-0 m-0">
                            Events/Notifications of Class
                            <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                    </div>
                    <span>
                        <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($classEvents as $e) {
                    // if ($e['is_event'] == 1) {
                    //     continue;
                    // }
                    eventItem($e);
                } ?>
            </ul>
        </div>
    <?php }
    if (count($rids) > 0) { ?>
        <div class="tab-pane fade" id="nav-rooms" role="tabpanel" aria-labelledby="nav-rooms-tab">
            <div class="row p-1">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="p-0 m-0">
                            Events/Notifications of All Rooms
                            <div class="event-spinner spinner-border  spinner-border-sm" style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </h5>
                    </div>
                    <span>
                        <a href="events/create?<?php echo $url_with_query_params ?>" type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                            Create <i class="bi bi-plus-lg"></i>
                        </a>
                    </span>
                </div>
            </div>
            <ul class="list-group">
                <?php foreach ($roomEvents as $e) {
                    // if ($e['is_event'] == 1) {
                    //     continue;
                    // }
                    eventItem($e);
                } ?>
            </ul>
        </div>
    <?php } ?>
</div>

<div class="modal fade" id="eventDisplay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventtitle">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <p class="text-start p-0 m-0 col-6 ps-3" id="attatchementlink"></p>
                <p class="text-end p-0 m-0 mb-3 small col-6 pe-3" id="eventtime"></p>
                <div id="eventcontent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="registerEvent">Register Now</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    'use strict';

    $(".event-spinner").hide();
    function showEvent(id) {
        $(".event-spinner").show();
        var myModal = new bootstrap.Modal(document.getElementById('eventDisplay'));
        $.getJSON(`/services/events/getone?eid=${id}`, (res) => {
            if (!res.error) {
                res = res[0];
            } else {
                $(".event-spinner").hide(300);
            }
            $('#eventtime').html(new Date(res.sendtime * 1000).toLocaleString())
            $('#eventtitle').html(res.title);
            // $('#eventcontent').html(res.content);
            let quill = new Quill('#eventcontent', {
                theme: 'snow'
            });
            quill.root.innerHTML = res.content;
            quill.disable();
            $('.ql-toolbar').hide();
            $('.ql-container.ql-snow').css('border', 'none');
            $('#attatchementlink').empty();
            if (res.attatchement.length > 0) {
                let fileLink = document.createElement('a');
                fileLink.href = res.attatchement;
                fileLink.innerHTML = 'Download Attatchement Here';
                fileLink.download = res.attatchement.split('/')[1].slice(0, res.attatchement.length);
                $('#attatchementlink').append(fileLink);
            }
            if (res.is_event == 1) {
                $('#registerEvent').show();
            } else {
                $('#registerEvent').hide();
            }
            $(".event-spinner").hide(300);
            myModal.toggle();
        })
    }
</script>