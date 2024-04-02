@extends('layouts.portal.app')

@section('content')
    <section class="login-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="{{ route('portal.register.post') }}" method="post"
                        role="form">
                        @csrf
                        <h3 class="mb-4">Register</h3>
                        <p>
                            {{ (empty($mode) ? 'Register sebagai apa?' : $mode == 'company') ? 'Badan Perusahaan' : 'Member' }}
                        </p>
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
                                    <a class="btn btn-primary custom-btn auth" style="width:100%"
                                        href="{{ route('portal.register', ['mode' => 'company']) }}">Badan Perusahan</a>
                                </div>
                                <div class="col-md-6 col-12">
                                    <a class="btn btn-primary custom-btn auth" style="width:100%"
                                        href="{{ route('portal.register', ['mode' => 'seeker']) }}">Member</a>
                                </div>
                            </div>
                        @else
                            @if ($mode === 'company')
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
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="">Nama Lengkap *</label>
                                        <input type="text" name="full_name" class="form-control" required />
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
                                        <label for="">Tanggal Lahir *</label>
                                        <input type="date" required="required" class="form-control" name="date_of_birth">
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="">Jenis Kelamin *</label>
                                        <select name="gender" class="form-control">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="male">Laki-Laki</option>
                                            <option value="female">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <input type="hidden" name="mode" value="{{ $mode }} ">
                                <button type="submit" class="form-control mt-4">Register</button>
                            </div>
                        @endif
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
