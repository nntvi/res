@extends('header')
<div class="reg-w3">
        <div class="w3layouts-main">
            <h2>Register Now</h2>
                <form action="{{ route('register')}}" method="post">
                    @csrf
                    <input id="name" type="text" class="ggg form-control @error('name') is-invalid @enderror" name="name" placeholder="NAME" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input id="email" type="email" class="ggg form-control @error('email') is-invalid @enderror" name="email" placeholder="E-MAIL" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    {{--  <input type="text" class="ggg" name="Phone" placeholder="PHONE" required="">  --}}

                    <input id="password" type="password" class="ggg form-control @error('password') is-invalid @enderror" name="password" placeholder="PASSWORD" required autocomplete="new-password">
                    @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                    <input id="password-confirm" type="password" class="ggg form-control" name="password_confirmation" placeholder="PASSWORD CONRIRM" required autocomplete="new-password">
                    @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                    {{--  <h4><input type="checkbox" />I agree to the Terms of Service and Privacy Policy</h4>  --}}

                        <div class="clearfix"></div>
                        <input type="submit" value="REGISTER" name="register">
                </form>
                <p>Already Registered.<a href="{{ route('login')}}">Login</a></p>
        </div>
@extends('footer')


