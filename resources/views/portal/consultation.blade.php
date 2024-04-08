@extends('layouts.portal.app')

@section('content')
    <main>
        <section class="volunteer-section section-padding" id="konsultasi">
            <div class="overlay"></div>
            <div class="container consultation-container">
                <div class="row">

                    <div class="col-lg-6 col-12">
                        <h2 class="text-white mb-4">Konsultasi</h2>

                        <form class="custom-form volunteer-form mb-5 mb-lg-0" action="{{ route('portal.consultation') }}"
                            method="post" role="form" enctype="multipart/form-data">
                            <h3 class="mb-4">Form Konsultasi</h3>
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label class="required">Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukan Nama"
                                        required>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <label class="required">NIK</label>
                                    <input type="text" name="identity_number" class="form-control"
                                        placeholder="Masukan NIK" required>
                                </div>
                                <div class="col-12">
                                    <label class="required">Email</label>
                                    <input type="email" name="email" pattern="[^ @]*@[^ @]*" class="form-control"
                                        placeholder="Masukan Email" required>
                                </div>

                                <div class="col-12">
                                    <label class="required">Subject</label>
                                    <input type="text" name="subject" class="form-control" placeholder="Masukan Subject"
                                        required>
                                </div>
                                <div class="col-12">
                                    <label class="">Deskripsi</label>
                                    <textarea name="description" rows="3" class="form-control" id="volunteer-message" placeholder="Masukan Deskripsi"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="">Dokumen</label>
                                    <div class="input-group input-group-file">
                                        <input type="file" class="form-control" id="inputGroupFile02" name="file">
                                        <label class="input-group-text" for="inputGroupFile02">Dokumen
                                            (Opsional)</label>
                                        <i class="bi-cloud-arrow-up ms-auto"></i>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="form-control">Submit</button>
                        </form>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="custom-block-body">
                            <h4 class="text-white mt-lg-3 mb-lg-3">Kontak Informasi</h4>

                            <div class="container">
                                @if (!is_null($dashboard?->phone_number))
                                    <p class="text-white d-flex mb-2">
                                        <i class="bi-telephone me-2"></i>

                                        <a href="https://wa.me/{{ $dashboard?->phone_number }}?text={{ urlencode($dashboard?->default_text ?? '') }}"
                                            class="site-footer-link" target="_blank">
                                            {{ $dashboard->phone_number }}
                                        </a>
                                    </p>
                                @endif

                                @if (!is_null($dashboard?->email))
                                    <p class="text-white d-flex">
                                        <i class="bi-envelope me-2"></i>
                                        <a href="mailto:{{ $dashboard->email }}" class="site-footer-link">
                                            {{ $dashboard->email }}
                                        </a>
                                    </p>
                                @endif

                                @if (!is_null($dashboard?->address))
                                    <p class="text-white d-flex mt-3">
                                        <i class="bi-geo-alt me-2"></i>
                                        {{ $dashboard->address }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
