@extends('layouts.portal.app')

@section('content')
    <section class="login-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="{{ route('portal.login') }}" method="post" role="form">
                        @csrf
                        <h3 class="mb-4">Login</h3>
                        <p>Login to your account</p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif


                        <div class="row">
                            <div class="col-12 mt-2">
                                <input type="email" name="email" id="donation-name" class="form-control"
                                    placeholder="Email" pattern="[^ @]*@[^ @]*" required>
                            </div>

                            <div class="col-12 mt-2">
                                <input type="password" name="password" id="donation-email" class="form-control"
                                    placeholder="Password" required>
                            </div>

                            <div class="col-lg-12 col-12 mt-2">
                                <button type="submit" class="form-control mt-4">Login</button>
                                <p class="mt-5">Don't have an account? <a href="{{ route('portal.register') }}"
                                        style="color: blue">Register</a> </p>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
