@extends('layouts.portal.app')

@section('content')
    <main>

        <section class="news-detail-header-section text-center"
            style="background-image: url({{ asset(is_null($job->image) ? 'storage/' . $job->company->image : 'storage/' . $job->image) }});">
            <div class="section-overlay"></div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <h1 class="text-white">{{ $job->name_job }}</h1>
                    </div>

                </div>
            </div>
        </section>

        <section class="news-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-12">
                        <div class="news-block">
                            <div class="news-block-info">
                                <div class="news-block-title mb-2">
                                    <h4>{{ $job->name_job }}</h4>
                                </div>

                                <div class="d-flex mt-2">
                                    <div class="news-block-date">
                                        <p>
                                            <i class="bi-calendar4 custom-icon me-1"></i>
                                            {{ $job->created_at_format }}
                                        </p>
                                    </div>

                                    <div class="news-block-author mx-5">
                                        <p>
                                            <i class="bi-building custom-icon me-1"></i>
                                            {{ $job->company->name }}
                                        </p>
                                    </div>
                                </div>

                                <div class="news-block-body">
                                    {!! $job->description !!}

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <table class="mt-5" style="border-spacing: 0 10px; border-collapse: separate;   ">
                            @php
                                $additional = [
                                    'address' => 'Alamat',
                                    'total_needed_man' => 'Total Pria dibutuhkan',
                                    'total_needed_woman' => 'Total Wanita dibutuhkan',
                                    'minimal_education' => 'Pendidikan Minimal',
                                    'special' => 'Spesialisasi',
                                    'salary' => 'Gaji',
                                    'deadline_format' => 'Tgl Deadline Penerimaan Kerja',
                                    'start_date_format' => 'Tgl Mulai Bekerja',
                                ];
                            @endphp
                            @foreach ($additional as $field => $val)
                                @if (!is_null($job->$field))
                                    <tr>
                                        <th>{{ $val }}</th>
                                        <td style="padding: 0 1rem">:</td>
                                        <td>{{ $job->$field }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        <form action="{{ route('portal.jobs.apply') }}" method="post">
                            @csrf
                            <input type="hidden" name="job_id" value="{{ $job->id }}">
                            <input type="submit" value="Daftar" class="custom-btn btn-primary"
                                style="margin-top:2rem; width:55%" />
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
