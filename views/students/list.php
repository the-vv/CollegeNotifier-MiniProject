
<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary rounded rounded-pill w-100" data-bs-toggle="modal"
    data-bs-target="#exampleModal">
    View Students
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Students Here</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <?php
                    foreach ($students as $s) {
                        echo "<li class='list-group-item d-inline-block text-truncate text-start d-flex align-items-center'>\n";
                        echo "<span class='d-inline-block'><i class='bi bi-person me-3' style='font-size:2rem'></i></span>\n";
                        echo "<span class='d-inline-block'><strong>{$s['student_name']}</strong><br>\n";
                        echo "<small class='small'>{$s['email']}</small></span>\n\n";
                    }
                    ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>