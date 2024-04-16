 @filamentStyles
 @filamentScripts
 @extends('layouts.portal.app')

 @section('content')
     <main>
         <section class="news-detail-header-section text-center">
             <div class="section-overlay"></div>

             <div class="container">
                 <div class="row">

                     <div class="col-lg-12 col-12">
                         <h1 class="text-white">Data Statistik Dan Info Ketenagakerjaan </h1>
                     </div>

                 </div>
             </div>
         </section>

         <section class="news-section section-padding">
             <div class="container">
                 <div class="row">

                     <div class="col-12">
                         <div class="news-block">
                             <div class="news-block-info">
                                 <div class="news-block-title mb-2">
                                     <h4>Data Statistik Dan Info Ketenagakerjaan</h4>
                                 </div>

                                 <div class="d-flex">
                                     <div class="news-block-date">
                                         <p>
                                             <i class="bi-calendar4 custom-icon me-1"></i>
                                             {{ now()->format('Y') }}
                                         </p>
                                     </div>

                                 </div>
                                 <div class="news-block-body">
                                     @livewire(\App\Livewire\Portal\InfoEmploymentBarChart::class)
                                     @livewire(\App\Livewire\Portal\InfoEmploymentLineChart::class)
                                     @livewire(\App\Livewire\Portal\InfoEmploymentBarChartVillage::class)
                                     @livewire(\App\Livewire\Portal\InfoEmploymentLineChartVillage::class)
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>
         </section>
     </main>
 @endsection
