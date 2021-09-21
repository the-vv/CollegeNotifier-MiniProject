<div class="row administration shadow shadow-sm pb-3">
    <div class="col-12 mb-3">
        <p class="h4 text-center">Administration Tools</p>
    </div>
    <div class="container-fluid">
        <div class="row d-flex justify-content-evenly gx-1">
            <div class="col-auto admin-button">
                <a href="administration/departments?<?php echo $url_with_query_params ?>"
                    class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i class="fas fa-building"></i>
                    Departments
                </a>
            </div>
            <div class="col-auto admin-button">
                <a href="administration/batches?<?php echo $url_with_query_params ?>"
                    class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i
                        class='fas fa-graduation-cap me-1'></i>
                    Batches
                </a>
            </div>
            <div class="col-auto admin-button">
                <a href="administration/classes?<?php echo $url_with_query_params ?>"
                    class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i
                        class="fas fa-chalkboard-teacher"></i>
                    Classes
                </a>
            </div>
            <div class="col-auto admin-button">
                <a href="administration/rooms?<?php echo $url_with_query_params ?>"
                    class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i
                        class="bi bi-house-door-fill"></i>
                    Rooms
                </a>
            </div>
            <div class="col-auto admin-button d-none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Coming Soon...!">
                <button disabled class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i
                        class="fas fa-user-friends"></i>
                    Faculties
                </button>
            </div>
            <div class="col-auto admin-button d-none" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Coming Soon...!">
                <button disabled class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i
                        class="fas fa-child"></i>
                    Parents
                </button>
            </div>
            <div class="col-auto admin-button">
                <a href="administration/students?<?php echo $url_with_query_params ?>"
                    class="btn btn-light shadow rounded rounded-pill w-100 py-2"><i class="fas fa-user-graduate"></i>
                    Students
                </a>
            </div>
        </div>
    </div>
</div>