@if(session('message'))

    <div class="alert show showAlert">
        <span class="fas fa-exclamation-circle alert alert-{{ session('alert_type') }}"></span>
        <span class="msg">{{ session('message') }}</span>
        <div class="close-btn">
            <span class="fa fa-times"></span>
        </div>
    </div>

@endif