<?php
$success_to_show = $success_mess ?? 'Action has been completed successfully';
echo "
<svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
<symbol id='check-circle-fill' fill='currentColor' viewBox='0 0 16 16'>
    <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
</symbol>
</svg>
    <div container-fluid mx-3 bg-light p-4>
        <div class='row my-4 text-center'>
            <div class='alert alert-success d-flex align-items-center' role='alert'>
                <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Danger:'><use xlink:href='#check-circle-fill'/></svg>
            <div>
                $success_to_show
            </div>
        </div>
    </div>
</div>
";
?>