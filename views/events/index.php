<?php
$room_to_add = '';
if ($query_param_values['clid'] != 0) {
    $room_to_add = 'Class';
} elseif ($query_param_values['bid'] != 0) {
    $room_to_add = 'Batch';
} elseif ($query_param_values['did'] != 0) {
    $room_to_add = 'Department';
} elseif ($query_param_values['cid'] != 0) {
    $room_to_add = 'College';
}
if ($query_param_values['rid'] != 0) {
    $room_to_add = 'Room';
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/db/event.php';
if ($room_to_add == 'College') {
    $events = get_events_by_college($query_param_values['cid']);
} elseif ($room_to_add == 'Department') {
    $events = get_events_by_dpt($query_param_values['cid'], $query_param_values['did']);
} elseif ($room_to_add == 'Batch') {
    $events = get_events_by_batch($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid']);
} elseif ($room_to_add == 'Class') {
    $events = get_events_by_class($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid'], $query_param_values['clid']);
} else {
    $events = get_events_by_param($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid'], $query_param_values['clid'], $query_param_values['rid']);
}
// echo "<pre>";
// print_r($events);
// echo "</pre>";

function eventItem($e)
{ ?>
<li class='list-group-item d-flex justify-content-between align-items-center eid-<?php echo $e['id'] ?>'>
    <a onclick="showEvent('<?php echo $e['id'] ?>')" class="d-inline-block text-truncate h6 text-decoration-none">
        <div class="row">
            <div class="col-auto d-flex align-items-center">
                <?php if ($e['is_event'] == 0) { ?>
                <i class="bi bi-app-indicator text-primary d-inline" style="font-size:2rem"></i>
                <?php } else { ?>
                <i class="bi bi-calendar2-event text-primary d-inline" style="font-size:2rem"></i>
                <?php } ?>
            </div>
            <div class="col-auto">
                <p class="h6 p-0 m-0">
                    <?php echo "<span class='fw-bold' style='font-size:1.2em'>{$e['title']}</span>";
                    
                        if (strlen($e['attatchement']) > 0) { ?>
                    <i class="bi bi-paperclip text-primary" title="Has Attatchement"></i>
                    <?php } ?>                    
                </p>
                <small class="text-muted">
                    <?php
                        echo substr(htmlentities(strip_tags($e['content'])), 0, 50);
                        if (strlen(htmlentities(strip_tags($e['content']))) > 50) {
                            echo "...";
                        }
                        if ($e['content'] == '<p><br></p>') {
                            echo "<i>Empty Content</i>";
                        } elseif (strlen(htmlentities(strip_tags($e['content']))) == 0 && strlen($e['content']) > 0) {
                            echo "<i>Click to view Content</i>";
                        }
                        ?>
                </small>
                <small class="text-muted mt-2 text-dark d-block"><strong>From:
                    </strong><?php echo $e['level']['name']; ?> (<span
                        class="text-capitalize"><?php echo $e['level']['type'] ?></span>)</small>
                        <?php if ($e['is_event'] == 1) { ?>
                <span class="mt-1 d-block text-muted">
                    <?php echo "<span class='satetime_value'>{$e['starttime']}</span> - <span class='satetime_value'>{$e['endtime']}</span>"?>
                    <?php } ?>
                </span>                
            </div>
        </div>
    </a>
    <span class="d-flex align-items-center event-actions">
        <div>
            <div class="me-2 ms-auto">
                <p class="m-0 p-0 text-end">
                    <?php echo date('d/m/y h:i:s', $e['sendtime']); ?>
                    <button type='button' class='btn btn-sm btn-danger m-0 border border-dark'
                        onclick="deleteEvent('<?php echo $e['id'] ?>', '<?php echo $e['title'] ?>', <?php echo $e['is_event'] ?>)">
                        <i class='bi bi-trash-fill'></i></button>
                    <a href="/events/create?eid=<?php echo $e['id'] ?>" type='button'
                        class='btn btn-sm btn-warning m-0 border border-dark ms-1'>
                        <i class='bi bi-pencil-square'></i></a>
                </p>
            </div>
            <div class="me-2 d-block text-truncate text-end">
                <span class="h6">
                    <?php echo $e['user']['name']; ?>
                </span> |
                <small class="text-capitalize">
                    <?php echo $e['from_user_type']; ?>
                </small>
            </div>
        </div>
    </span>
</li>
<?php } ?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-room-tab" data-bs-toggle="tab" data-bs-target="#nav-room" type="button"
            role="tab" aria-controls="nav-room" aria-selected="false">All</button>
        <button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications"
            type="button" role="tab" aria-controls="nav-notifications" aria-selected="true">All Notifications</button>
        <button class="nav-link" id="nav-events-tab" data-bs-toggle="tab" data-bs-target="#nav-events" type="button"
            role="tab" aria-controls="nav-events" aria-selected="false">All Events</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent" id="evants-view">
    <div class="tab-pane fade" id="nav-notifications" role="tabpanel" aria-labelledby="nav-notifications-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="p-0 m-0">
                        Events/Notifications
                        <div class="event-spinner spinner-border  spinner-border-sm"
                            style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </h5>
                </div>
                <span>
                    <a href="events/create?<?php echo $url_with_query_params ?>" type="button"
                        class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </a>
                </span>
            </div>
        </div>
        <ul class="list-group">
            <?php foreach ($events as $e) {
                if ($e['is_event'] == 1) {
                    continue;
                }
                eventItem($e);
            } ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="nav-events" role="tabpanel" aria-labelledby="nav-events-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements
                    <div class="event-spinner spinner-border  spinner-border-sm"
                        style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </h5>
                <span>
                    <a href="events/create?<?php echo $url_with_query_params ?>" type="button"
                        class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </a>
                </span>
            </div>
        </div>
        <ul class="list-group">
            <?php foreach ($events as $e) {
                if ($e['is_event'] == 0) {
                    continue;
                }
                eventItem($e);
            }
            ?>
        </ul>
    </div>
    <div class="tab-pane fade active show" id="nav-room" role="tabpanel" aria-labelledby="nav-room-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements
                    <div class="event-spinner spinner-border spinner-border-sm"
                        style="font-size:0.8rem; display: inline-block; vertical-align: center" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </h5>
                <span>
                    <a href="events/create?<?php echo $url_with_query_params ?>" type="button"
                        class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </a>
                </span>
            </div>
        </div>
        <ul class="list-group" id="all_events_view">
            <?php foreach ($events as $e) {
                eventItem($e);
            } ?>
        </ul>
    </div>
</div>

<div class="modal fade" id="eventDisplay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="eventtitle">Modal title</h5>
                    <div id="event_timing" class="fw-bold text-muted" class="text-muted"></div>
                    <div id="ownerInfo" class="text-muted"></div>
                    <div id="fromLevel" class="text-muted"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <p class="text-start p-0 m-0 col-6 ps-3" id="attatchementlink"></p>
                <p class="text-end p-0 m-0 mb-3 small col-6 pe-3" id="eventtime"></p>
                <div id="eventcontent"></div>
            </div>
            <div class="modal-footer">
                <span data-bs-toggle="tooltip" data-bs-placement="top" title="Coming Soon...!">
                    <button type="button" class="btn btn-primary" id="registerEvent" disabled>Register Now</button>
                </span>
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
        $('#ownerInfo').html(`<strong>${res.user.name}</strong> | <small>${res.user.email}</small>`);
        $('#fromLevel').html(
            `<strong>From: </strong> ${res.level.name} <span class='text-capitalize'>(${res.level.type})</span>`
            );
        $('#event_timing').html(`<span class='satetime_value'>${formatDateFromString(res['starttime'])}</span> - <span class='satetime_value'>${formatDateFromString(res['endtime'])}</span>`)
        document.getElementById('eventDisplay').addEventListener('shown.bs.modal', () => {
            $(".event-spinner").hide(300);
        }, {
            once: true
        })
        document.getElementById('eventDisplay').addEventListener('hidden.bs.modal', () => {
            quill.root.innerHTML = '';
            $('#eventtime').html('');
            $('#eventtitle').html('');
        }, {
            once: true
        })
        myModal.toggle();
    })
}

function deleteEvent(eid, title, isEvent) {
    console.log(isEvent);
    let type = isEvent ? 'event' : 'notification';
    $.confirm({
        theme: 'material',
        containerFluid: true,
        backgroundDismiss: true,
        title: 'Confirm Delete!',
        content: `Are you sure want to delete the ${type}:<br><strong>${title}</strong>`,
        type: 'red',
        icon: 'bi bi-trash-fill',
        bgOpacity: 0.8,
        buttons: {
            confirm: {
                btnClass: 'btn btn-danger',
                action: () => {
                    HoldOn.open({
                        theme: 'sk-fading-circle',
                        message: 'Please wait...'
                    });
                    $.getJSON(`/services/events/deleteone?eid=${eid}`, (res) => {
                        HoldOn.close();
                        if (res.success) {
                            $(`.eid-${eid}`).remove();
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
                    }).fail((e) => {
                        HoldOn.close();
                        // console.log(e);
                        $.toast({
                            heading: 'Error',
                            text: 'Error Deleting Event, Try again later',
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
function formatDateFromString(dateString) {
    return new Date(dateString).toLocaleTimeString("en-US", { year: 'numeric', month: 'short', day: 'numeric' })
}
$('.satetime_value').each(function(index, element) {
    // console.log($(this).html())
    let date = formatDateFromString($(this).html())
    $(this).html(date)
})
</script>