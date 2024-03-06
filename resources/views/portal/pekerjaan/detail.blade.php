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
                                            <i class="bi-person custom-icon me-1"></i>
                                            By {{ $job->company->name }}
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
                        <table class="mt-5">
                            @php
                                $additional = [
                                    'address' => 'Address',
                                    'total_needed_man' => 'Total Needed Man',
                                    'total_needed_woman' => 'Total Needed Woman',
                                    'minimal_education' => 'Minimal Education',
                                    'special' => 'Special',
                                    'salary' => 'Salary',
                                    'deadline_format' => 'Deadline',
                                    'start_date_format' => 'Start Date',
                                ];
                            @endphp
                            @foreach ($additional as $field => $val)
                                @if (!is_null($job->$field))
                                    <tr>
                                        <th>{{ $val }}</th>
                                        <td>:</td>
                                        <td>{{ $job->$field }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
