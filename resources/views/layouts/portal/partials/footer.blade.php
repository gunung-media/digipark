   <footer class="site-footer">
       <div class="container">
           <div class="row">
               <div class="col-lg-3 col-12 mb-4">
                   <img src="{{ asset('portal/images/logo.png') }}" class="logo img-fluid" alt="">
               </div>

               <div class="col-lg-4 col-md-6 col-12 mb-4">
                   <h5 class="site-footer-title mb-3">Quick Links</h5>

                   <ul class="footer-menu">
                       <li class="footer-menu-item"><a href="/website#unit-layanan" class="footer-menu-link">Unit
                               Layanan</a>
                       </li>

                       <li class="footer-menu-item"><a href="/website#profil" class="footer-menu-link">Profil</a></li>

                       <li class="footer-menu-item"><a href="/website#pekerjaan" class="footer-menu-link">Pekerjaan</a>
                       </li>

                       <li class="footer-menu-item"><a href="/website/berita" class="footer-menu-link">Berita</a>
                       </li>
                   </ul>
               </div>

               <div class="col-lg-4 col-md-6 col-12 mx-auto">
                   <h5 class="site-footer-title mb-3">Contact Infomation</h5>

                   @if (!is_null($dashboard->phone_number))
                       <p class="text-white d-flex mb-2">
                           <i class="bi-telephone me-2"></i>

                           <a href="tel: {{ $dashboard->phone_number }}" class="site-footer-link">
                               {{ $dashboard->phone_number }}
                           </a>
                       </p>
                   @endif

                   @if (!is_null($dashboard->email))
                       <p class="text-white d-flex">
                           <i class="bi-envelope me-2"></i>
                           <a href="mailto:{{ $dashboard->email }}" class="site-footer-link">
                               {{ $dashboard->email }}
                           </a>
                       </p>
                   @endif

                   @if (!is_null($dashboard->address))
                       <p class="text-white d-flex mt-3">
                           <i class="bi-geo-alt me-2"></i>
                           {{ $dashboard->address }}
                       </p>
                   @endif
               </div>
           </div>
       </div>

       <div class="site-footer-bottom">
           <div class="container">
               <div class="row">

                   <div class="col-lg-6 col-md-7 col-12">
                       <p class="copyright-text mb-0">Copyright © {{ date('Y') }} <a href="#">Digital Palangka
                               Raya Kreatif Ketenagakerjaan</a>
                           Charity Org.<brr Design: <a href="https://gunungmedia.com" target="_blank">Gunung Media</a>
                       </p>
                   </div>

                   <div class="col-lg-6 col-md-5 col-12 d-flex justify-content-center align-items-center mx-auto">
                       <ul class="social-icon">
                           @php
                               $socials = ['facebook', 'twitter', 'instagram', 'youtube', ' linkedin'];
                           @endphp
                           @foreach ($socials as $social)
                               @if (!is_null($dashboard->$social))
                                   <li class="social-icon-item">
                                       <a href="{{ $dashboard->$social }}"
                                           class="social-icon-link bi-{{ $social }}">
                                       </a>
                                   </li>
                               @endif
                           @endforeach
                       </ul>
                   </div>

               </div>
           </div>
       </div>
   </footer>
