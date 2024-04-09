@extends('front.layouts.app')

@push('css_after')
    <!-- DatePicker CSS -->
    <link rel="stylesheet" href="{{ asset('css/components/daterangepicker.css') }}">
    <!-- SelectPicker CSS -->
    <link rel="stylesheet" href="{{ asset('css/components/bs-select.css') }}">
    <style>

        .white-section {
            background-color: #FFF;
            padding: 25px 20px;
            -webkit-box-shadow: 0px 1px 1px 0px #dfdfdf;
            box-shadow: 0px 1px 1px 0px #dfdfdf;
            border-radius: 0;
        }

        .white-section label {
            display: block;
            margin-bottom: 15px;
        }

        .white-section pre { margin-top: 15px; }

        .dark .white-section {
            background-color: #111;
            -webkit-box-shadow: 0px 1px 1px 0px #444;
            box-shadow: 0px 1px 1px 0px #444;
        }

        .bootstrap-select {
            width: 87% !important;
        }

    </style>
@endpush

@push('meta_tags')
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima"/>
    <meta property="og:image" content="https://goflexi.agmedia.rocks/image/Naslovna.jpg"/>
    <meta property="og:site_name" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima"/>
    <meta property="og:url" content="https://www.goflexi.eu/"/>
    <meta property="og:description" content="Brza i ugodna putovanja putničkim kombi vozilima.Do Zagreba, Rijeke i Splita u pola klika!"/>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:title" content="GOFLEXI - Brza i ugodna piutovanje putničkim vozilima" />
    <meta name="twitter:description" content="Brza i ugodna putovanja putničkim kombi vozilima.Do Zagreba, Rijeke i Splita u pola klika!" />
    <meta name="twitter:image" content="https://goflexi.agmedia.rocks/image/Naslovna.jpg" />
@endpush

@section('content')

    <section id="slider" class="slider-element slider-parallax dark swiper_wrapper min-vh-40 min-vh-lg-60 bg-black include-header">
        <div class="slider-inner" style="background-image: url('{{ asset('media/image/Naslovna.jpg') }}'); background-size: cover; background-position: center center;">


            <div class="vertical-middle slider-element-fade">
                <div class="container py-5">
                    <div class="emphasis-title">
                        <p class="lead d-block fs-3 mb-2" data-animate="fadeInUp">Brza i ugodna putovanja putničkim kombi vozilima.</p>

                        <h3 class="fs-1" data-animate="fadeInUp" data-delay="200">Do Zagreba, Rijeke i Splita u pola klika!</h3>
                    </div>
                </div>
            </div>


            <div class="video-wrap">
                <div class="video-overlay" style="background-color: rgba(0,0,0,0.25);"></div>
            </div>

        </div>
    </section>

    <!-- Content -->
    <section id="content">
        <div class="content-wrap pb-0">
            <!-- Odabir vožnje -->
            <div class="promo promo-full promo-border pt-3 pt-md-3 pb-4 pb-md-2 promo-dark header-stick mb-md-6 mb-4">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg">
                            <h3 class="mb-3">Rezervirajte kartu online</h3>
                        </div>
                    </div>
                    <div class="row align-items-center">

                        <div class="col-12 col-lg">

                            <div class="" data-alert-type="inline">
                                <div class="form-result"></div>
                                <form id="form-cleaning" name="form-cleaning" action="{{ route('view-reservation') }}" method="post" class="row form-cleaning mb-0 mb-md-1">
                                    @csrf
                                    <div class="form-process">
                                        <div class="form-cleaning-loader css3-spinner" style="position: absolute;">
                                            <div class="css3-spinner-double-bounce1"></div>
                                            <div class="css3-spinner-double-bounce2"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-text bg-color text-white"><i class="bi-pin"></i></span>
                                            <select class="required" name="polazak" id="polazak">
                                                <option value="" disabled selected>Odaberite mjesto polaska</option>
                                                <option value="Zagreb">Zagreb</option>
                                                <option value="Split">Split</option>
                                                <option value="Rijeka">Rijeka</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6">
                                        <div class="input-group form-group">
                                            <span class="input-group-text bg-color text-white"><i class="bi-pin"></i></span>
                                            <select class="required" name="dolazak" id="dolazak">
                                                <option value="" disabled selected>Odaberite lokaciju dolaska</option>
                                                <option value="Zagreb">Zagreb</option>
                                                <option value="Split">Split</option>
                                                <option value="Rijeka">Rijeka</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-8">
                                        <div class="input-group form-group">
                                            <span class="input-group-text bg-color text-white"><i class="bi-calendar-week"></i></span>
                                            {{--<input type="text" class="form-control cleaning-date datetimepicker-input required" name="datum" id="datum" value="Odaberite datum polaskae" readonly>--}}
                                            <select class="required" name="listing" id="listing" data-size="5">
                                                <option value="" disabled selected>Odaberite datum polaska</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-4">
                                        <button type="submit" name="form-cleaning-submit" class="btn bg-color text-white fw-semibold w-100 mt-0">Rezerviraj</button>
                                    </div>

                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!-- vozni red -->
            <div class="container-fluid" id="vozni-red">
                <div class="text-center mb-md-5 mb-3">
                    <h2 class="h1">Vozni red</h2>
                </div>
                <div class="row col-mb-50">

                    <div class="col-md-6">

                        <div class="flip-card">
                            <div class="flip-card-front dark bg-black mb-3 p-0" >
                                <div class="flip-card-inner">
                                    <div class="card-header text-primary fs-3">Zagreb - Rijeka - Zagreb</div>
                                    <div class="card-body">
                                        <p class="card-text mb-3 text-contrast-500">Utorkom, četvrtkom i subotom.</p>
                                        <ul class="iconlist mb-0">
                                            <li><i class="bi-clock-fill"></i> Polasci iz Zagreba preme Rijeci u 10:00, a iz Rijeke prema Zagrebu u 12:00 sati.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="flip-card-back bg-primary no-after">
                                <div class="flip-card-inner">
                                    <div class="card-header text-white fs-3">Zagreb - Rijeka - Zagreb</div>
                                    <div class="card-body">
                                        <p class="card-text mb-3 text-white">Utorkom, četvrtkom i subotom.</p>
                                        <ul class="iconlist mb-0">
                                            <li><i class="bi-clock-fill text-white"></i> Polasci iz Zagreba preme Rijeci u 10:00, a iz Rijeke prema Zagrebu u 12:00 sati.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="flip-card">
                            <div class="flip-card-front dark bg-black mb-3 p-0" >
                                <div class="flip-card-inner">
                                    <div class="card-header text-primary fs-3">Zagreb - Split - Zagreb</div>
                                    <div class="card-body">
                                        <p class="card-text mb-3 text-contrast-500">Ponedjeljkom, srijedom i petkom.</p>
                                        <ul class="iconlist mb-0">
                                            <li><i class="bi-clock-fill"></i> Polasci iz Zagreba preme Splituy u 10:00, a iz Splita prema Zagrebu u 16:00 sati.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="flip-card-back bg-primary no-after">
                                <div class="flip-card-inner">
                                    <div class="card-header text-white fs-3">Zagreb - Split - Zagreb</div>
                                    <div class="card-body">
                                        <p class="card-text mb-3 text-white">Ponedjeljkom, srijedom i petkom.</p>
                                        <ul class="iconlist mb-0">
                                            <li><i class="bi-clock-fill text-white"></i> Polasci iz Zagreba preme Splituy u 10:00, a iz Splita prema Zagrebu u 16:00 sati.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="col-md-6">

                        <div class="accordion accordion-bg mb-0" data-collapsible="true" data-active="false">


                            <div class="accordion-header rounded-3 bg-contrast-200  mb-3 p-4 p-md-4">
                                <div class="accordion-icon text-primary">
                                    <i class="accordion-closed bi-caret-down-fill"></i>
                                    <i class="accordion-open bi-caret-up-fill"></i>
                                </div>

                                <div class="accordion-title">
                                    POLAZIŠTE ZAGREB   <a data-href="https://www.google.com/maps/place/GoFlexi+Point+Zagreb/@45.8010156,15.9769545,17z/data=!3m1!4b1!4m6!3m5!1s0x4765d7f47432c9e7:0xdc58e09f8ea85ddc!8m2!3d45.8010156!4d15.9795294!16s%2Fg%2F11v3m9w8dc?authuser=0&entry=ttu" onclick="window.open(this.getAttribute('data-href')); return false;" class="fw-medium float-end"><i class="uil uil-map-marker"></i> Prikaži na karti</a>
                                </div>
                            </div>
                            <div class="accordion-content p-4">
                                Koncertna dvorana Vatroslav Lisinski <br>
                                Trg Stjepana Radića<br>
                                Ugibalište ispred glavnog ulaza<br>
                                <a href="https://www.google.com/maps/place/GoFlexi+Point+Zagreb/@45.8010156,15.9769545,17z/data=!3m1!4b1!4m6!3m5!1s0x4765d7f47432c9e7:0xdc58e09f8ea85ddc!8m2!3d45.8010156!4d15.9795294!16s%2Fg%2F11v3m9w8dc?authuser=0&entry=ttu" target="_blank" class="fw-medium ">Prikaži na karti</a>
                            </div>



                            <div class="accordion-header rounded-3 bg-contrast-200 mb-3 p-4 p-md-4">
                                <div class="accordion-icon text-primary">
                                    <i class="accordion-closed bi-caret-down-fill"></i>
                                    <i class="accordion-open bi-caret-up-fill"></i>
                                </div>
                                <div class="accordion-title">
                                    POLAZIŠTE RIJEKA   <a data-href="https://www.google.com/maps/place/GoFlexi+Point+Rijeka/@45.3249641,14.4412363,17z/data=!3m1!4b1!4m6!3m5!1s0x4764a1006c377e15:0x662a9a7ea40f59fe!8m2!3d45.3249641!4d14.4438112!16s%2Fg%2F11vrclf0g9?authuser=0&entry=ttu"  class="fw-medium float-end" onclick="window.open(this.getAttribute('data-href')); return false;"><i class="uil uil-map-marker"></i> Prikaži na karti</a>
                                </div>
                            </div>
                            <div class="accordion-content p-4">
                                Autobusna postaja Tržnica <br>
                                Ulica Ivana Zajca<br>
                                Kod Kazališnog parka<br>
                                <a href="https://www.google.com/maps/place/GoFlexi+Point+Rijeka/@45.3249641,14.4412363,17z/data=!3m1!4b1!4m6!3m5!1s0x4764a1006c377e15:0x662a9a7ea40f59fe!8m2!3d45.3249641!4d14.4438112!16s%2Fg%2F11vrclf0g9?authuser=0&entry=ttu" target="_blank" class="fw-medium ">Prikaži na karti</a>
                            </div>



                            <div class="accordion-header rounded-3 bg-contrast-200  p-4 p-md-4">
                                <div class="accordion-icon text-primary">
                                    <i class="accordion-closed bi-caret-down-fill"></i>
                                    <i class="accordion-open bi-caret-up-fill"></i>
                                </div>
                                <div class="accordion-title">
                                    POLAZIŠTE SPLIT   <a data-href="https://www.google.com/maps/place/GoFlexi+Point+Split/@43.5206858,16.4453669,17z/data=!3m1!4b1!4m6!3m5!1s0x13355f0bbf2c367f:0x53f2f4e887260500!8m2!3d43.5206858!4d16.4479418!16s%2Fg%2F11v3ynn5l6?authuser=0&entry=ttu" onclick="window.open(this.getAttribute('data-href')); return false;" class="fw-medium float-end"><i class="uil uil-map-marker"></i> Prikaži na karti</a>
                                </div>
                            </div>
                            <div class="accordion-content p-4">
                                Autobusna stanica<br>
                                Put Supavla – Brodarica<br>
                                Preko puta trgovačkog centra Joker<br>
                                <a href="https://www.google.com/maps/place/GoFlexi+Point+Split/@43.5206858,16.4453669,17z/data=!3m1!4b1!4m6!3m5!1s0x13355f0bbf2c367f:0x53f2f4e887260500!8m2!3d43.5206858!4d16.4479418!16s%2Fg%2F11v3ynn5l6?authuser=0&entry=ttu" target="_blank" class="fw-medium ">Prikaži na karti</a>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
            <!-- o nama -->
            <div class="container-fluid bg-black" id="onama" style="background: url('{{ asset('media/image/bg-strets.jpg') }}') no-repeat center bottom / cover;">
                <div class="mb-0">
                    <div class="row align-items-center mt-5 dark">
                        <div class="col-lg-6 text-center p-md-5 p-3">
                            <img src="{{ asset('media/image/onama-1.png') }}"/>
                        </div>

                        <div class="col-lg-6 p-md-5 p-3 ">
                            <div class="heading-block border-bottom-0">
                                <h3><span class="text-primary">GoFlexi</span> je moderna platforma specijalizirana za kombi prijevoz putnika.</h3>
                            </div>
                            <p >Namjera nam je pružiti vrhunski, udoban i siguran prijevoz poštujući želje klijenata.</p>
                            <p class=" mb-0">Udobnost naših vozila omogućuje putnicima da prijevoz dožive sa potpunom lakoćom, a naša je obaveza osigurati siguran transfer i ugodnost putovanja našim klijentima.</p>
                        </div>
                    </div>

                    <div class="row align-items-center mt-0 dark">
                        <div class="col-lg-6 p-md-5 p-3">
                            <div class="feature-box fbox-effect mb-5">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa-solid fa-drivers-license"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <p >Naši vozači su licencirani profesionalci sa višegodišnjim iskustvom prijevoza putnika u domaćem i međunarodnom prometu.</p>
                                </div>
                            </div>

                            <div class="feature-box fbox-effect mb-5">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa-solid fa-van-shuttle"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <p >Sva naša vozila su neupitne kvalitete, sa ugrađenim klima uređajem i besplatnim wi-fi internetom u putničkom prostoru.</p>
                                </div>
                            </div>

                            <div class="feature-box fbox-effect">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa-solid fa-award"></i></a>
                                </div>
                                <div class="fbox-content">
                                    <p class="mb-0">Pružamo profesionalnu uslugu prijevoza putničkim kombi vozilima na liniji Zagreb – Split – Zagreb te Zagreb – Rijeka - Zagreb. Uslugu prijevoza vršimo putničkim kombi vozilima 8+1 sjedala.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 text-center p-md-5 p-3" >
                            <img src="{{ asset('media/image/onama-2.png') }}"/>
                        </div>

                    </div>
                </div>
            </div>
            <!-- faq -->
            <div class="container-fluid bg-contrast-200">
                <div class="mb-0" id="faq">
                    <div class="text-center mb-5 pt-5">
                        <h2 class="h1">FAQ</h2>
                    </div>

                    <div class="accordion accordion-bg mb-0" data-collapsible="true" data-active="false">
                        <div class="row pb-5">
                            <div class="col-md-6">
                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Kako mogu napraviti rezervaciju?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Ako želite kupiti voznu kartu, to možete učiniti na našoj web stranici. Na naslovnici odaberite ponuđene parametre te će vas sustav, kroz par jednostavnih koraka, provesti kroz proces rezervacije.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Mogu li vaše usluge rezervirati telefonom, izravnom uplatom na vaš bankovni račun, ili platiti gotovinski?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Na žalost, ne. Naše usluge možete rezervirati isključivo tako da dovršite proces rezervacije na našoj web stranici.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Mogu li rezervirati transfer za danas, ili sutra?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Vaš transfer možete rezervirati kada god želite pa i na sâm dan transfera, ukoliko na dan transfera u vozilu još ima slobodnih mjesta. Imajte na umu da putnička kombi vozila mogu primiti do 8 putnika, stoga svakako preporučujemo što raniju rezervaciju.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Je li moguće rezervirati povratni transfer?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Moguće je rezervirati transfer samo u jednom smjeru. Ukoliko trebate i povratni transfer, savjetujemo da napravite dvije različite rezervacije. Jednu za odlazno putovanje te jednu za povratno putovanje.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Nisam dobio e-mail sa potvrdom rezervacije. Što mi je činiti?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4"><p>Rezervacija je uspješno privedena kraju kada dođete do posljednjeg koraka procesa rezerviranja i izvršite uplatu, a sustav vam izda broj karte i sažetak svih podataka o transferu. Sustav vam tada šalje voznu kartu sa svim informacijama na vašu email adresu koju ste naveli u postupku rezervacije.</p>
                                    <p>Ako niste došli do posljednjeg koraka rezervacije, rezervacija vjerojatno nije uspjela jer nije dovršena. U tom slučaju, pričekajte nekoliko minuta i pokušajte ponovno.</p>
                                    <p>Ako ste prošli posljednji korak rezervacije, ali niste zaprimili e-mail sa potvrdom, pokušajte sljedeće:</p>
                                    <ul class="iconlist mb-4">
                                        <li><i class="bi-info-circle-fill"></i>  Pričekajte dvije do tri minute.</li>
                                        <li><i class="bi-info-circle-fill"></i> Provjerite spam folder(mapa neželjene pošte) u svom e-mail pretincu. Ponekad se automatski generirani mailovi tretiraju kao reklame i završavaju u spam folderima.</li>
                                    </ul>
                                    <p>Prije potvrde plaćanja na zadnjem koraku rezervacije dodatno provjerite jeste li unijeli ispravnu e-mail adresu.</p></div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Mogu li putovati sa svojim kućnim ljubimcima?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Zbog sigurnosnih razloga, ali i obzira prema drugim putnicima, ne odobravamo prijevoz kućnih ljubimaca.</div>

                            </div>
                            <div class="col-md-6">
                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Plaćam li manje ako kupujem voznu kartu za dijete?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Cijene vozne karte po putniku su jednake, bez obzira na dob. Stoga vrijede iste cijene za odrasle i djecu. Po potrebi, dječje sjedalice dostupne su prilikom rezervacije i uračunate su u cijenu vozne karte za dijete.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Kako mogu platiti?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4"><p>Naše usluge možete naručiti putem naše web stranice i platiti na kraju online procesa rezervacije. Sustav će tražiti da na kraju online procesa rezervacije unesete podatke sa svoje kreditne, ili debitne kartice.</p>
                                    <p>GoFlexi koristi Stripe payment gateway, jedan od najpoznatijih i najsigurnijih sustava za online plaćanja u svijetu. Više na <a href="https://www.stripe.com" target="_blank">www.stripe.com</a></p></div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Mogu li platiti karticom koja nije moja?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Možete platiti tuđom kreditnom karticom, uz suglasnost vlasnika kreditne kartice.</div>


                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Hoćete li me čekati ako zakasnim na polazišnu lokaciju?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Ukoliko putnik zakasni na lokaciju ukrcaja, vozač će ga nazvati na broj telefona koji je upisao prilikom procesa online rezervacije. Ukoliko je kašnjenje 5 – 10 minuta, vozač će pričekati putnika. Ukoliko je kašnjenje duže od 10 minuta, na žalost, dodatno čekanje neće biti moguće.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Mogu li promijeniti datum rezerviranog transfera?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Nakon što ste rezervirali transfer, više nije moguće promijeniti datum rezervacije.</div>

                                <div class="accordion-header rounded mb-3 p-2 p-md-4">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed bi-check-circle-fill"></i>
                                        <i class="accordion-open bi-x-circle-fill"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Imam li pravo na povrat novca ako otkažem rezervaciju?
                                    </div>
                                </div>
                                <div class="accordion-content pb-4">Ukoliko putnik otkaže rezervaciju, <strong>ne ostvaruje pravo na povrat novca</strong>. Povrat uplaćenih sredstava moguć je isključivo ako prijevoznik iz bilo kojeg razloga otkaže, ili nije u mogućnosti izvršiti transfer na datum rezervacije. Potvrdom i uplatom rezervacije putnik pristaje na <a href="">Opće uvjete prijevoza</a></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- kontakt-->
            <div class="container-fluid" id="contact">
                <div class="row align-items-stretch mt-0 dark bg-dark">
                    <div class="col-lg-6 d-block " style="background: url('{{ asset('media/image/kontakt.jpg') }}') center center no-repeat; background-size: cover;"></div>

                    <div class="col-lg-6 p-md-5 p-2 ">
                        <div class="card bg-contrast-0 border-0" style="border-radius: 20px;">
                            <div class="card-body p-md-5 p-3">
                                <h3>Kontaktirajte nas</h3>

                                <div class="form-widget">
                                    <div class="form-result"></div>
                                    <form class="mb-0" id="template-contactform" name="template-contactform" action="include/form.php" method="post">
                                        <div class="form-process">
                                            <div class="css3-spinner">
                                                <div class="css3-spinner-scaler"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <label for="template-contactform-name">Ime i prezime<small>*</small></label>
                                                <input type="text" id="template-contactform-name" name="template-contactform-name" value="" placeholder="Unesite vaše ime i prezime" class="form-control required">
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="template-contactform-email">Email<small>*</small></label>
                                                <input type="email" id="template-contactform-email" name="template-contactform-email" value="" placeholder="Unesite Email adresu" class="required email form-control">
                                            </div>

                                            <div class="col-md-6 mb-4">
                                                <label for="template-contactform-phone">Broj telefona<small>*</small></label>
                                                <input type="text" id="template-contactform-phone" name="template-contactform-phone" value="" placeholder="Unesite broj mtelefona" class="form-control required">
                                            </div>

                                            <div class="col-12 mb-4">
                                                <label for="template-contactform-message">Poruka<small>*</small></label>
                                                <textarea class="form-control required" id="template-contactform-message" name="template-contactform-message" placeholder="Unesite tekst poruke..." rows="5" cols="30"></textarea>
                                            </div>

                                            <div class="col-12 mb-4 d-none">
                                                <input type="text" id="template-contactform-botcheck" name="template-contactform-botcheck" value="" class="form-control">
                                            </div>

                                            <div class="col-12">
                                                <button class="button button-large bg-primary bg-opacity-75 h-bg-dark rounded-pill m-0 w-100" type="submit" id="template-contactform-submit" name="template-contactform-submit" value="submit">Pošaljite poruku</button>
                                            </div>
                                        </div>

                                        <input type="hidden" name="prefix" value="template-contactform-">
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('js_after')
    <script src="{{ asset('js/components/bs-select.js') }}"></script>
    <script>
        $(document).ready(function() {
            let polazak = $('#polazak').selectpicker();
            let dolazak = $('#dolazak').selectpicker();
            let listing = $('#listing').selectpicker();

            polazak.on('changed.bs.select', (e) => {
                resolveSelection(polazak.val(), dolazak.val());
            });
            dolazak.on('changed.bs.select', (e) => {
                resolveSelection(polazak.val(), dolazak.val());
            });
        });

        /**
         *
         * @param from
         * @param to
         */
        function resolveSelection(from, to) {
            axios.post("{{ route('product.api.get') }}", { from: from, to: to })
            .then(response => {
                let data = response.data;
                console.log(data)

                if (data.from instanceof Array) {
                    clearSelection($('#polazak'), 'from');

                    data.from.forEach((item) => {
                        $('#polazak').append('<option value="' + item + '">' + item + '</option>');
                        $('#polazak').selectpicker('refresh');
                    });
                }

                if (data.to instanceof Array) {
                    clearSelection($('#dolazak'), 'to');

                    data.to.forEach((item) => {
                        $('#dolazak').append('<option value="' + item + '">' + item + '</option>');
                        $('#dolazak').selectpicker('refresh');
                    });
                }

                if (data.items instanceof Array) {
                    clearSelection($('#listing'));

                    data.items.forEach((item) => {
                        console.log(item)
                        $('#listing').append('<option value="' + item.id + '" data-subtext="' + item.subtitle + '">' + item.title + '</option>');
                        $('#listing').selectpicker('refresh');
                    });
                }

            });
        }

        /**
         *
         * @param select
         * @param target
         */
        function clearSelection(select, target = 'items') {
            select.find('option').remove();
            select.selectpicker('refresh');

            if (target == 'from') {
                select.append('<option value="">Odaberite mjesto polaska...</option>');
            }
            if (target == 'to') {
                select.append('<option value="">Odaberite lokaciju dolaska...</option>');
            }
            if (target == 'items') {
                select.append('<option value="">Odaberite datum polaska...</option>');
            }

            select.selectpicker('refresh');
        }

        /**
         *
         */
        function clearAllSelections() {
            [$('#polazak'), $('#dolazak'), $('#listing')].forEach((item) => {
                clearSelection(item);
            });
        }
    </script>

    {{--<script src="{{ asset('js/components/daterangepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search-input').on('keyup', (e) => {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $('search-form').submit();
                }
            })

            $('.cleaning-date').daterangepicker({
                "buttonClasses": "button button-rounded button-mini text-transform-none ls-0 fw-semibold",
                "applyClass": "button-color m-0 ms-1",
                "cancelClass": "bg-black m-0 text-light",
                singleDatePicker: true,
                startDate: moment().startOf('hour'),
                minDate: moment().startOf('date'),
                timePicker: false,
                timePickerSeconds: false,
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Potvrdi',
                    cancelLabel: 'Odustani',
                    daysOfWeek: [
                        "Ne",
                        "Po",
                        "Ut",
                        "Sr",
                        "Če",
                        "Pe",
                        "Su"
                    ],
                    monthNames: [
                        "Siječanj",
                        "Veljača",
                        "Ožujak",
                        "Travanj",
                        "Svibanj",
                        "Lipanj",
                        "Srpanj",
                        "Kolovoz",
                        "Rujan",
                        "Listopad",
                        "Studeni",
                        "Prosinac"
                    ],


                },
                isInvalidDate: function(date) {
                    console.log(date.date() + '.' + date.month())
                    return (date.day() == 0 || date.day() == 1 || date.day() == 3 || date.day() == 5 );
                },
                timePickerIncrement: 10
            });

            $('.cleaning-date').val('Odaberite datum polaska');

            $('.form-cleaning').on( 'formSubmitSuccess', function(){
                $('.cleaning-date').val('Odaberite datum polaska');
            });
        });
    </script>--}}
@endpush
