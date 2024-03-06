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
                          <li><a class="dropdown-item" href="/website#news">Berita</a></li>
                          <li><a class="dropdown-item" href="/website#konsultasi">Konsultasi</a></li>
                      </ul>
                  </li>

                  <li class="nav-item"><a class="nav-link click-scroll"
                          href="{{ route('portal.berita.index') }}">Berita</a></li>
                  <li class="nav-item"><a class="nav-link click-scroll"
                          href="{{ route('portal.jobs.index') }}">Pekerjaan</a></li>

                  @foreach ($menus as $menu)
                      @if ($menu->subMenus->count() > 0)
                          <li class="nav-item dropdown">
                              <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                                  id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                  aria-expanded="false">{{ $menu->name }}</a>

                              <ul class="dropdown-menu dropdown-menu-light"
                                  aria-labelledby="navbarLightDropdownMenuLink">
                                  @foreach ($menu->subMenus as $sub)
                                      <li style="margin-top:10px">
                                          <a class="dropdown-item"
                                              href="{{ route('subMenu', ['slug' => $sub->slug]) }}">{{ $sub->title }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          </li>
                      @endif
                  @endforeach

                  <li class="nav-item dropdown">
                      <a class="nav-link click-scroll dropdown-toggle" href="#section_5"
                          id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                          aria-expanded="false">Layanan Online</a>

                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                          @if (auth('company')->check())
                              <li>
                                  <a class="dropdown-item"
                                      href="{{ route('portal.layanan.pembuatanPekerjaan.index') }}">Pelaporan
                                      Lowongan<a>
                              </li>
                              <li>
                                  <a class="dropdown-item"
                                      href="{{ route('portal.layanan.pelaporanPenempatan.index') }}">Pelaporan
                                      Penempatan<a>
                              </li>
                              <li>
                                  <a class="dropdown-item"
                                      href="{{ route('portal.layanan.permintaanTenagaKerja.index') }}">Permintaan Tenaga
                                      Kerja<a>
                              </li>
                          @else
                              <li><a class="dropdown-item" href="{{ route('form') }}">Pembuatan Kartu AK/I</a></li>
                              <li><a class="dropdown-item" href="{{ route('form') }}">Laporan Pemutusan Hubungan
                                      Kerja</a>
                              <li><a class="dropdown-item" href="{{ route('form') }}">Rekomendasi Klaim JHT</a>
                              <li><a class="dropdown-item" href="{{ route('form') }}">Pengesahan Peraturan
                                      Perusahaan</a>
                              </li>
                          @endif
                      </ul>
                  </li>
                  <li class="nav-item ms-3">
                      @if (auth('company')->check())
                          <a class="nav-link custom-btn custom-border-btn btn"
                              href="{{ route('portal.logout') }}">Logout</a>
                      @else
                          <a class="nav-link custom-btn custom-border-btn btn"
                              href="{{ route('portal.login') }}">Login</a>
                      @endif
                  </li>
              </ul>
          </div>
      </div>
  </nav>
