  <nav class="navbar navbar-expand-lg bg-light shadow-lg">
      <div class="container">
          <a class="navbar-brand" href="{{ route('portal') }}">
              <img src="{{ asset('portal/images/logo.png') }}" class="logo img-fluid" alt="Kind Heart Charity">
              <span>
                  <small>Digital Palangka Raya Kreatif Ketenagakerjaan</small>
              </span>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">

                  <li class="nav-item dropdown">
                      <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                          id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                          aria-expanded="false">Home</a>

                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                          <li><a class="dropdown-item" href="/website#unit-layanan">Unit Layanan</a></li>
                          <li><a class="dropdown-item" href="/website#profil">Profil</a></li>
                          <li><a class="dropdown-item" href="/website#pekerjaan">Pekerjaan</a></li>
                          <li><a class="dropdown-item" href="/website/berita">Berita</a></li>
                      </ul>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link click-scroll" href="/website#konsultasi">Konsultasi</a>
                  </li>

                  @foreach ($menus as $menu)
                      <li class="nav-item dropdown">
                          <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                              id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">{{ $menu->name }}</a>

                          <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                              @forelse ($menu->subMenus  as $sub)
                                  <li><a class="dropdown-item"
                                          href="{{ route('subMenu', ['slug' => $sub->slug]) }}">{{ $sub->title }}</a>
                                  </li>
                              @empty
                                  <li>-</li>
                              @endforelse
                          </ul>
                      </li>
                  @endforeach

                  <li class="nav-item dropdown">
                      <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                          id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                          aria-expanded="false">Layanan Online</a>

                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                          <li><a class="dropdown-item" href="{{ route('form') }}">Pembuatan Kartu AK/I</a></li>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Lapor Lowongan</a>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Lapor Penempatan</a>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Permintaan Tenaga Kerja</a>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Laporan Pemutusan Hubungan Kerja</a>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Rekomendasi Klaim JHT</a>
                          <li><a class="dropdown-item" href="{{ route('form') }}">Pengesahan Peraturan Perusahaan</a>
                          </li>
                      </ul>
                  </li>


                  <li class="nav-item ms-3">
                      <a class="nav-link custom-btn custom-border-btn btn" href="donate.html">Login</a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
