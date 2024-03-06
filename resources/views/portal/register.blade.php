@extends('layouts.portal.app')

@section('content')
    <section class="login-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="{{ route('portal.register') }}" method="post" role="form">
                        @csrf
                        <h3 class="mb-4">Register</h3>
                        <p>{{ empty($mode) ? 'Register sebagai apa?' : "Register $mode" }}</p>
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
                        @if (empty($mode))
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <a class="btn btn-primary" style="width:100%"
                                        href="{{ route('portal.register', ['mode' => 'perusahaan']) }}">Badan Perusahan</a>
                                </div>
                                <div class="col-md-6 col-12">
                                    <a class="btn btn-primary" style="width:100%"
                                        href="{{ route('portal.register', ['mode' => 'seeker']) }}">Pencari Kerja</a>
                                </div>
                            </div>
                        @else
                            @if ($mode === 'perusahaan')
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="">Nama Perusahaan *</label>
                                        <input type="text" name="name" class="form-control" required />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Email *</label>
                                        <input type="email" name="email" class="form-control" required name="email" />
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Password *</label>
                                        <input type="password" required="required" class="form-control" name="password">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Alamat *</label>
                                        <input type="text" required="required" class="form-control" name="address">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Phone Number *</label>
                                        <input type="tel" required="required" class="form-control" name="phone_number">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Image *</label>
                                        <input type="file" required="required" class="form-control" name="image">
                                    </div>
                                @else
                                    <div class="row">
                                        <center>
                                            <h3>Tahap Pengembangan</h3>
                                        </center>
                                    </div>
                            @endif
                            <div class="col-12">
                                <input type="hidden" name="mode" value="{{ $mode }} ">
                                <input type="submit" class="mt-4 form-control btn-primary" value="Register"
                                    style="background-color: #007bff; color:white">
                            </div>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
