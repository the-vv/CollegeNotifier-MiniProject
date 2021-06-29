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

require_once $_SERVER['DOCUMENT_ROOT'] . '/dbActions/event.php';
$events = get_events_by_param($query_param_values['cid'], $query_param_values['did'], $query_param_values['bid'], $query_param_values['clid']);

// echo "<pre>";
// print_r($events);
// echo "</pre>";
?>


<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-room-tab" data-bs-toggle="tab" data-bs-target="#nav-room" type="button"
            role="tab" aria-controls="nav-room" aria-selected="false">All</button>
        <button class="nav-link" id="nav-notifications-tab" data-bs-toggle="tab"
            data-bs-target="#nav-notifications" type="button" role="tab" aria-controls="nav-notifications"
            aria-selected="true">All Notifications</button>
        <button class="nav-link" id="nav-events-tab" data-bs-toggle="tab" data-bs-target="#nav-events" type="button"
            role="tab" aria-controls="nav-events" aria-selected="false">All Events</button>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade" id="nav-notifications" role="tabpanel"
        aria-labelledby="nav-notifications-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements</h5>
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
            ?>
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <a href="javascript:void(0)"
                    class="d-inline-block text-truncate h6 text-decoration-none stretched-link">
                    <p class="h6 p-0 m-0">
                        <?php echo $e['title'] ?>
                    </p>
                    <small class="text-muted">
                        <?php echo substr(htmlentities(strip_tags($e['content'])), 0, 100) ?>...
                    </small>
                </a>
                <span class="d-flex align-items-center">
                    <?php echo date('d/m/y H:i:s', $e['sendtime']) ?>
                    <?php if(strlen($e['attatchement']) > 0){ ?><i class="bi bi-paperclip text-primary"
                        style="font-size:1.8rem"></i><?php } ?>
                </span>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-pane fade" id="nav-events" role="tabpanel" aria-labelledby="nav-events-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements</h5>
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
            ?>
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <a href="javascript:void(0)"
                    class="d-inline-block text-truncate h6 text-decoration-none stretched-link">
                    <p class="h6 p-0 m-0">
                        <?php echo $e['title'] ?>
                    </p>
                    <small class="text-muted">
                        <?php echo substr(htmlentities(strip_tags($e['content'])), 0, 100) ?>...
                    </small>
                </a>
                <span class="d-flex align-items-center">
                    <?php echo date('d/m/y H:i:s', $e['sendtime']) ?>
                    <i class="bi bi-paperclip text-primary" style="font-size:1.8rem"></i>
                </span>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="tab-pane fade active show" id="nav-room" role="tabpanel" aria-labelledby="nav-room-tab">
        <div class="row p-1">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="p-0 m-0">Events/Announcements</h5>
                <span>
                    <a href="events/create?<?php echo $url_with_query_params ?>" type="button"
                        class="btn btn-outline-primary rounded rounded-pill btn-sm">
                        Create <i class="bi bi-plus-lg"></i>
                    </a>
                </span>
            </div>
        </div>
        <ul class="list-group">
            <?php foreach ($events as $e) { ?>
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <a href="javascript:void(0)"
                    class="d-inline-block text-truncate h6 text-decoration-none stretched-link">
                    <p class="h6 p-0 m-0">
                        <?php echo $e['title'] ?>
                    </p>
                    <small class="text-muted">
                        <?php echo substr(htmlentities(strip_tags($e['content'])), 0, 100) ?>...
                    </small>
                </a>
                <span class="d-flex align-items-center">
                    <?php echo date('d/m/y H:i:s', $e['sendtime']) ?>
                    <i class="bi bi-paperclip text-primary" style="font-size:1.8rem"></i>
                </span>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>