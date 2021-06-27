<?php
$room_to_add = '';
if ($query_param_values['clid'] != 0) {
    $room_to_add = 'College';
} elseif ($query_param_values['bid'] != 0) {
    $room_to_add = 'Batch';
} elseif ($query_param_values['did'] != 0) {
    $room_to_add = 'Department';
}
?>


<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-notifications-tab" data-bs-toggle="tab" data-bs-target="#nav-notifications" type="button"
            role="tab" aria-controls="nav-notifications" aria-selected="true">All Notifications</button>
        <button class="nav-link" id="nav-events-tab" data-bs-toggle="tab" data-bs-target="#nav-events" type="button"
            role="tab" aria-controls="nav-events" aria-selected="false">All Events</button>
        <button class="nav-link" id="nav-room-tab" data-bs-toggle="tab" data-bs-target="#nav-room" type="button"
            role="tab" aria-controls="nav-room" aria-selected="false">room</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-notifications" role="tabpanel" aria-labelledby="nav-notifications-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements</h5>
                <span>
                    <button type="button" class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </button>
                </span>
            </div>
        </div>
        <ul class="list-group">
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <a href="javascript:void(0)"
                    class="d-inline-block text-truncate h6 text-decoration-none stretched-link">
                    Here is the dummy event content
                    <small class="small text-muted">
                        | Content description
                    </small>
                </a>
            </li>
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <a href="javascript:void(0)"
                    class="d-inline-block text-truncate h6 text-decoration-none stretched-link">
                    Here is the dummy event content
                    <small class="small text-muted">
                        | Content description
                    </small>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-pane fade" id="nav-events" role="tabpanel" aria-labelledby="nav-events-tab">...</div>
    <div class="tab-pane fade" id="nav-room" role="tabpanel" aria-labelledby="nav-room-tab">...</div>
</div>