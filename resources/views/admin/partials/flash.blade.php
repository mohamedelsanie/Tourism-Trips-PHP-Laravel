@if(session('message'))
    <br>
    <div class="alert alert-{{ session('alert_type') }} alert-dismissible fade show" role="alert" id="alert_session">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif