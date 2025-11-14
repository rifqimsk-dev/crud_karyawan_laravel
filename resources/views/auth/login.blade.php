@extends('layouts.app')
@section('content')
<div class="container mt-4" style="max-width: 400px;">
    <h4>Login</h4>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        {{-- CAPTCHA MEWS --}}
        <div class="mb-3">
            <label>Kode Captcha</label>
            <div class="d-flex captcha">
                <span>{!! captcha_img() !!}</span>
                <button type="button" id="reload" class="btn btn-default ms-2">
                    <i class="fa fa-undo"></i>
                </button>
            </div>
            <input type="text" name="captcha" class="form-control mt-2  @error('captcha') is-invalid @enderror" placeholder="Masukkan kode di atas">
            @error('captcha') <small class="text-danger">Kode captcha tidak sesuai</small> @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register.form') }}">Register</a></p>
    </form>
</div>
<script>
document.getElementById('reload').addEventListener('click', function () {
    fetch('/reload-captcha')
        .then(res => res.json())
        .then(data => {
            document.querySelector('.captcha span').innerHTML = data.captcha;
        });
});
</script>


@endsection
