   <header class="site-header">
       <div class="container">
           <div class="row">

               <div class="col-lg-8 col-12 d-flex flex-wrap">
                   <p class="d-flex me-4 mb-0">
                       {{ date('l, d F Y') }}
                   </p>

                   @if (!is_null($dashboard?->email))
                       <p class="d-flex mb-0">
                           <i class="bi-envelope me-2"></i>

                           <a href="mailto:{{ $dashboard->email }}">
                               {{ $dashboard->email }}
                           </a>
                       </p>
                   @endif
               </div>

               <div class="col-lg-3 col-12 ms-auto d-lg-block d-none">
                   <ul class="social-icon">
                       @php
                           $socials = ['facebook', 'twitter', 'instagram', 'youtube', ' linkedin'];
                       @endphp
                       @foreach ($socials as $social)
                           @if (!is_null($dashboard?->$social))
                               <li class="social-icon-item">
                                   <a href="{{ $dashboard->$social }}" class="social-icon-link bi-{{ $social }}">
                                   </a>
                               </li>
                           @endif
                       @endforeach
                   </ul>
               </div>

           </div>
       </div>
   </header>
