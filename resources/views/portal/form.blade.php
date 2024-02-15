@extends('layouts.portal.app')

@section('content')
    <section class="donate-section">
        <div class="section-overlay"></div>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mx-auto">
                    <form class="custom-form donate-form" action="#" method="get" role="form">
                        <h3 class="mb-4">Pembuatan Kartu K/I</h3>

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <h5 class="mb-3">Jenis Kartu</h5>
                            </div>

                            <div class="col-lg-6 col-6 form-check-group form-check-group-donation-frequency">
                                <div class="form-check form-check-radio">
                                    <input class="form-check-input" type="radio" name="DonationFrequency"
                                        id="DonationFrequencyOne" checked>

                                    <label class="form-check-label" for="DonationFrequencyOne">
                                        One Time
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-6 col-6 form-check-group form-check-group-donation-frequency">
                                <div class="form-check form-check-radio">
                                    <input class="form-check-input" type="radio" name="DonationFrequency"
                                        id="DonationFrequencyMonthly">

                                    <label class="form-check-label" for="DonationFrequencyMonthly">
                                        Monthly
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <h5 class="mt-1">Personal Info</h5>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="text" name="donation-name" id="donation-name" class="form-control"
                                    placeholder="Jack Doe" required>
                            </div>

                            <div class="col-lg-6 col-12 mt-2">
                                <input type="email" name="donation-email" id="donation-email" pattern="[^ @]*@[^ @]*"
                                    class="form-control" placeholder="Jackdoe@gmail.com" required>
                            </div>

                            <div class="col-lg-12 col-12 mt-2">
                                <button type="submit" class="form-control mt-4">Submit Donation</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
