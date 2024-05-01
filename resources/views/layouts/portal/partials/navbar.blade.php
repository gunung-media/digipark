  <nav class="navbar navbar-expand-lg bg-light shadow-lg">
      <div class="container">
          <a class="navbar-brand" href="{{ route('portal') }}">
              <img src="{{ asset('portal/images/logo.png') }}" class="logo img-fluid" alt="Kind Heart Charity">
              <span>
                  <!-- <small>Digital Palangka Raya Kreatif Ketenagakerjaan</small> -->
              </span>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link click-scroll" href="{{ route('landing') }}">Portal</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link click-scroll" href="{{ route('portal') }}">Beranda</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link click-scroll" href="{{ route('portal.jobs.index') }}">Pekerjaan</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link click-scroll" href="#">Panduan</a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link click-scroll dropdown-toggle" href="#layanan" id="navbarLightDropdownMenuLink"
                          role="button" data-bs-toggle="dropdown" aria-expanded="false">Layanan</a>

                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                          <li><a class="dropdown-item" href="{{ route('portal.consultation') }}">Layanan Konsultasi</a>
                          </li>
                          <li>
                              <a class="dropdown-item" href="{{ route('portal.train-and-internship.index') }}">
                                  Informasi Pelatihan dan Magang
                              </a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.seeker.resources.claim-jhts.create') }}">Klaim JHT</a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.company.resources.company-legalizations.create') }}">Pengesahan
                                  Peraturan Perusahaan</a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.company.resources.company-laid-offs.create') }}">Laporan
                                  PHK</a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.company.resources.jobs.create') }}">Pelaporan
                                  Lowongan</a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.company.resources.placements.create') }}">Pelaporan
                                  Penempatan</a>
                          </li>
                          <li><a class="dropdown-item"
                                  href="{{ route('filament.company.resources.labor-demands.create') }}">Permintaan
                                  Tenaga Kerja</a>
                          </li>
                          <li>
                              <a class="dropdown-item" href="https://account.kemnaker.go.id/register" target="_blank">
                                  Pembuatan AK 1
                              </a>
                          </li>
                          <li class="dropdown-submenu">
                              <a class="dropdown-item dropdown-toggle" href="#">Info Data Ketenagakerjaan</a>
                              <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{ route('portal.news.index') }}">Berita</a></li>
                                  <li><a class="dropdown-item" href="{{ route('portal.info-employment') }}">Data
                                          Statistik
                                          dan Grafik Ketenagakerjaan</a></li>

                              </ul>
                          </li>
                          <!-- <li><a class="dropdown-item" href="{{ route('portal.dummies.magang') }}">Informasi -->
                          <!--         Pelatihan dan Magang</a></li> -->
                          <!-- <li><a class="dropdown-item" href="{{ route('portal.dummies.info') }}">Informasi -->
                          <!--         Ketenagakerjaan</a></li> -->
                      </ul>
                  </li>

                  @foreach ($menus as $key => $menu)
                      @if ($menu->subMenus->count() > 0)
                          <li class="nav-item dropdown">
                              <a class="nav-link click-scroll dropdown-toggle" href="#"
                                  id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                  aria-expanded="false">{{ $menu->name }}</a>
                              <ul class="dropdown-menu dropdown-menu-light"
                                  aria-labelledby="navbarLightDropdownMenuLink"r
                                  @foreach ($menu->subMenus as $sub)
                                      <li>
                                          <a class="dropdown-item"
                                              href="{{ route('portal.sub-menu', ['slug' => $sub->slug]) }}">{{ $sub->title }}</a>
                                      </li> @endforeach
                                  </ul>
                          </li>
                      @endif
                  @endforeach
                  <li class="nav-item dropdown">
                      <a class="nav-link click-scroll dropdown-toggle" href="#profile" id="navbarLightDropdownMenuLink"
                          role="button" data-bs-toggle="dropdown" aria-expanded="false">Login</a>

                      <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                          <li><a class="dropdown-item" href="/member" target="__blank">Member</a></li>
                          <li><a class="dropdown-item" href="/perusahaan" target="__blank">Perusahaan</a></li>
                          <li><a class="dropdown-item" href="/admin" target="__blank">Admin</a></li>
                          <li><a class="dropdown-item" href="/content" target="__blank">Admin Bidang</a></li>
                          <!-- <li><a class="dropdown-item" href="/website#pekerjaan">Pekerjaan</a></li> -->
                          <!-- <li><a class="dropdown-item" href="/website#news">Berita</a></li> -->
                      </ul>
                  </li>

                  <!-- <li class="nav-item ms-3"> -->
                  <!--     @if (auth('seeker')->check())
-->
                  <!--         <a class="nav-link custom-btn custom-border-btn btn" -->
                  <!--             href="{{ route('portal.logout') }}">Logout</a> -->
                  <!--
@else
-->
                  <!--         <a class="nav-link custom-btn custom-border-btn btn" -->
                  <!--             href="{{ route('portal.login', ['mode' => 'seeker']) }}">Login</a> -->
                  <!--
@endif -->
                  <!-- </li> -->
              </ul>
          </div>
      </div>
  </nav>
