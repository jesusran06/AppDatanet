@extends('layouts.app')

@section('content')

<section class="mt-5">
    <div class="container ">
        <div class="row">
            <div class="col-md-5 mx-auto">
                <div class="card" style="border-radius: 14px; background: #ffffff; box-shadow:  7px 7px 14px #b8b8b8, -7px -7px 14px #ffffff;">
                    <div class="card-body">
                        <div class=" pb-3 pt-1 text-center">
                            <img src="{{asset('images/datanet.png')}}" width="50%" height="50%" alt="" class="img-fluid">
                        </div>
                        <hr>
                        <form method="POST" action="{{ route('login') }}" class="px-3">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>

                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email de Usuario">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="password" class="col-form-label ">{{ __('Password') }}</label>
                                    <!--input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror w-100"
                                        name="password" required autocomplete="current-password"-->
                                    <div class="input-group" style="border: 1px solid#ccc;border-radius: 5px;">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" maxlength="100" style="border: none;" />
                                        <span class="input-group-addon">
                                            <span class="fas fa fa-eye-slash" style="cursor:pointer;font-size:18px;padding:5px;margin:5px;"></span>
                                        </span>
                                    </div>
                                    @error('password')
                                    <span class=" invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!--div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div-->

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Entrar') }}
                                    </button>
                                </div>
                                <div class="col-md-12 text-center mt-1">
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Olvidó su contraseña?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@push('after-scripts')
<script>
    $(document).ready(function() {
        $('#email').on('keypress', function(e) {
            if (e.which == 32) {
                return false;
            }
        })
        $('#password').on('keypress', function(e) {
            if (e.which == 32) {
                return false;
            }
        })

        console.log("script")
        $(".fas").bind("click", function() {

            if ($('#password').attr('type') == 'password') {
                $('#password').attr('type', 'text');
                $('.fas').removeClass('fa fa-eye');
                $('.fas').addClass('fa fa-eye-slash');
            } else if ($('#password').attr('type') == 'text') {
                $('#password').attr('type', 'password');
                $('.fas').removeClass('fa-eye-slash');
                $('.fas').addClass('fa fa-eye');
            }
        })

    });
</script>
@endpush