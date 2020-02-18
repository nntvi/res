@extends('header')
            <div class="log-w3">
                    <div class="w3layouts-main">
                        <h2>Sign In Now</h2>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <input id="email" type="email" class="ggg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-MAIL" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input id="password" type="password" class="ggg @error('password') is-invalid @enderror" name="password" placeholder="PASSWORD" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />Remember Me</span>

                                @if (Route::has('password.request'))
                                    <h6><a class="btn btn-link" href="{{ route('password.request') }}">Forgot Password?</a></h6>
                                @endif

                                <div class="clearfix"></div>
                                <input type="submit" value="Sign In" name="login">

                            </form>

                    </div>
             </div>

@extends('footer')