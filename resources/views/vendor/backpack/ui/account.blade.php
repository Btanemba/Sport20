@extends(backpack_view('blank'))

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    <!-- Account Info Form -->
    <div class="card">
        <div class="card-header">
            {{ trans('backpack::base.my_account') }}
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('backpack.account.info.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">{{ trans('backpack::base.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <br>

                <!-- Add other fields as needed -->

                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Change Password Form -->
    <div class="card mt-4">
        <div class="card-header">
            {{ trans('backpack::base.change_password') }}
        </div>
        <div class="card-body">
            <form action="{{ route('backpack.account.password.store') }}" method="POST">
                @csrf
                <div class="form-group position-relative">
                    <label for="old_password">{{ trans('backpack::base.old_password') }}</label>
                    <input type="password" name="old_password" id="old_password" class="form-control pr-5" required>
                    <button type="button" onclick="togglePassword('old_password', 'eye-icon-old')" class="btn btn-link position-absolute" style="right: 10px; top: 70%; transform: translateY(-50%); padding: 0; border: none; background: none;">
                        <img id="eye-icon-old" src="{{ asset('icons/eye.png') }}" style="height: 20x; width: 20px;" alt="Toggle Password">
                    </button>
                </div>

                <div class="form-group position-relative">
                    <label for="new_password">{{ trans('backpack::base.new_password') }}</label>
                    <input type="password" name="new_password" id="new_password" class="form-control pr-5" required minlength="8">
                    <button type="button" onclick="togglePassword('new_password', 'eye-icon-new')" class="btn btn-link position-absolute" style="right: 10px; top: 70%; transform: translateY(-50%); padding: 0; border: none; background: none;">
                        <img id="eye-icon-new" src="{{ asset('icons/eye.png') }}" style="height: 20px; width: 20px;" alt="Toggle Password">
                    </button>
                </div>

                <div class="form-group position-relative">
                    <label for="confirm_password">{{ trans('backpack::base.confirm_password') }}</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control pr-5" required minlength="8">
                    <button type="button" onclick="togglePassword('confirm_password', 'eye-icon-confirm')" class="btn btn-link position-absolute" style="right: 10px; top: 70%; transform: translateY(-50%); padding: 0; border: none; background: none;">
                        <img id="eye-icon-confirm" src="{{ asset('icons/eye.png') }}" style="height: 20px; width: 20px;" alt="Toggle Password">
                    </button>
                </div>
                <br>

                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function togglePassword(inputId, eyeId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(eyeId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.src = "{{ asset('icons/eye-slash.png') }}";  // Change to eye-slash icon
        } else {
            passwordInput.type = 'password';
            eyeIcon.src = "{{ asset('icons/eye.png') }}";  // Change back to eye icon
        }
    }
</script>
@endsection
