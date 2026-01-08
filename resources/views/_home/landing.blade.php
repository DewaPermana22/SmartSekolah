<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/_home/home-costum.css', 'resources/js/_home/landing.js'])
    <title>Smart Sekolah | Beranda</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com" rel="preconnect">
    <link rel="stylesheet" href="https://fonts.gstatic.com" rel="preconnect">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Parisienne&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="preconnect">
  </head>
  <body class="body-landingpage">
    <header class="navbar-element">
      <div class="content-nav">
        <div class="image">
          <a href="/">
            <img src={{ asset("/home/images/smart-sekolah.png") }} alt="Logo" />
          </a>
        </div>
            
        <ul>
          <li class="link-nav"><a href="#beranda">Beranda</a></li>
          <li class="link-nav"><a href="#fitur">Fitur</a></li>
          <li class="link-nav"><a href="#tentang">Tentang</a></li>
          <li class="link-nav"><a href="#testimoni">Testimoni</a></li>
          <li class="link-nav"><a href="#galeri">Galeri</a></li>
        </ul>
            
        <a href="/koleksi.html" class="koleksi_btn">@include('_home.icons.book-open-check') Masuk & Belajar</a>
            
        <div class="hamburger-navbar">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </header>
    <div class="nav-link-mobile">
      <li class="link-nav"><a href="#beranda">Beranda</a></li>
      <li class="link-nav"><a href="#fitur">Fitur</a></li>
      <li class="link-nav"><a href="#tentang">Tentang</a></li>
      <li class="link-nav"><a href="#testimoni">Testimoni</a></li>
      <li class="link-nav"><a href="#galeri">Galeri</a></li>
      <li class="flex justify-center"><a href="/koleksi.html" class="koleksi_btn">@include('_home.icons.book-open-check') Masuk & Belajar</a></li>
    </div>
          
    <!-- HERO SECTION -->
    <section id="beranda" class="pt-30 overflow-hidden relative">
      <div class="h-full w-full absolute top-0 left-0 -z-1">
        <svg class="-rotate-180 top-0 absolute" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
          <path class="fill-gray-100" fill-opacity="1" d="M0,128L60,112C120,96,240,64,360,74.7C480,85,600,139,720,149.3C840,160,960,128,1080,144C1200,160,1320,224,1380,256L1440,288L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path>
        </svg>
        <div class="bg-transparent size-20 absolute top-100 left-50 rounded-full border-5 border-blue-500/20"></div>
        <div class="bg-transparent size-10 absolute bottom-70 left-150 rounded-full border-5 border-blue-500/20"></div>
        <div class="bg-transparent size-15 absolute bottom-20 left-50 rounded-full border-5 border-blue-500/20"></div>
      </div>
      <div class="flex flex-col-reverse min-[990px]:flex-row items-center justify-between gap-x-20 overflow-hidden px-5 min-[450px]:px-10 min-[700px]:px-20">
        <div class="flex-1 mt-15 min-[990px]:mt-0">
          <p class="px-5 inline-block text-[12px] min-[750px]:text-[13px] min-[1040px]:text-[14px] py-2 bg-gray-200 text-blue-500 font-semibold rounded-full">Ayo Belajar Bersama</p>
          <h1 class="font-fredoka text-[30px] min-[475px]:text-[35px] min-[670px]:text-[30px] min-[750px]:text-[35px] min-[1120px]:text-[43px] min-[1250px]:text-[50px] min-[1270px]:text-[55px] 2xl:text-7xl font-semibold leading-15 min-[1120px]:leading-20 2xl:leading-24 min-[1120px]:mt-2 mb-3 flex items-start min-[670px]:items-center min-[990px]:items-start flex-col min-[670px]:flex-row min-[990px]:flex-col">
            <div>
              Platform Pembelajaran Digital untuk 
              <span class="slidetexthero">
                  <span class="wrapper">
                      <span>Membangun</span>
                      <span>Mencetak</span>
                      <span>Mewujudkan</span>
                  </span>
              </span>
            </div>
          Kompetensi Nyata</h1>
        <p class="text-sm min-[1120px]:text-[15px] min-[1270px]:text-[16px]">Platform pembelajaran digital yang membantu kamu membangun kompetensi nyata melalui materi terstruktur, berbasis praktik, dan sesuai kebutuhan industri.</p>
        <div class="flex flex-col gap-y-5 min-[510px]:gap-y-0 min-[510px]:flex-row gap-x-8 items-center mt-8">
          <a href="#terdekat" class="linkhoveranimation text-[13px] min-[1030px]:text-sm min-[1120px]:text-[15px] filled">@include('_home.icons.rocket') Mulai Pembelajaran</a>
          <a href="#populer" class="linkhoveranimation text-[13px] min-[1030px]:text-sm min-[1120px]:text-[15px]">Eksplore Program @include('_home.icons.book-search')</a>
        </div>
        <div class="grid grid-cols-2 min-[560px]:grid-cols-4 mt-10 min-[1040px]:mt-15 gap-x-20 gap-y-10 min-[560px]:gap-y-0">
            <div class="statistikhero">
                <h1>1,2K+</h1>
                <p>Pengguna Terdaftar</p>
            </div>
            <div class="statistikhero">
              <h1>12+</h1>
              <p>Partner Sekolah</p>
            </div>
            <div class="statistikhero">
              <h1>100+</h1>
              <p>Modul Interaktif</p>
            </div>
            <div class="statistikhero">
              <h1>5+</h1>
              <p>Tahun Bergerak</p>
            </div>
        </div>
        </div>
        <div class="w-[300px] min-[480px]:w-[350px] min-[540px]:w-[400px] min-[590px]:w-[450px] min-[990px]:w-[320px] min-[1040px]:w-[350px] min-[1090px]:w-[400px] min-[1170px]:w-[450px] 2xl:w-[700px] relative font-fredoka">
          <div class="absolute top-1/2 -left-10 size-30 bg-blue-500/20 z-1"></div>
          <div class="absolute top-1/3 -right-10 size-30 bg-blue-500/10 z-1"></div>
          <x-home.floating-mini-card text="Profesional" class="right-[40%] top-14">
            @include('_home.icons.star')
          </x-home.floating-mini-card>
          <x-home.floating-mini-card text="Berkualitas" class="left-[20%] top-[40%]">
            @include('_home.icons.badge-check')
          </x-home.floating-mini-card>
          <x-home.floating-mini-card text="Bersertifikat" class="right-[40%] min-[1040px]:right-[30%] bottom-[30%]">
            @include('_home.icons.trophy')
          </x-home.floating-mini-card>
          <img src={{ asset("/home/images/gambar_home/1.png") }} class="w-[700px] relative top-0 z-5" alt="Hero Section Image" />
        </div>
      </div>
    </section>
    <div class="md:my-0 my-10 relative px-5 min-[450px]:px-10 min-[700px]:px-20">
        <div class="pointer-events-none absolute left-0 top-0 h-full w-5 min-[990px]:w-10 bg-linear-to-r from-gray-50 via-gray-50/80 to-transparent z-10"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-5 min-[990px]:w-10 bg-linear-to-l from-gray-50 via-gray-50/80 to-transparent z-10"></div>
        
        <div class="w-full overflow-hidden relative h-52">
          <div class="supportinglogomarqueehero">
            @include('components.home.logo-supporting-marquee')
          </div>
        </div>
    </div>
        
    <!-- TERDEKAT SECTION -->
    <section id="fitur" class="pt-10">
      <div class="titleSectionHome">
        <div>
            <h4 class="font-latin subtitle">Fitur Terbaik Belajar</h4>
            <h2 class="font-fredoka title">Eksplorasi Fitur Membantu Belajar</h2>
        </div>
        {{-- <a class="link linkhoveranimation text-[15px]" href='/wisata.html'>Terus Jelajahi <i class="fa-solid fa-arrow-right"></i></a> --}}
      </div>

      <div class="grid grid-cols-1 min-[900px]:grid-cols-2 min-[1260px]:grid-cols-3 justify-items-center 2xl:grid-cols-4 mt-30 gap-y-40">
        <x-home.card-fiture img="home/images/penginapan/1.jpg" title="Menggunakan AI" text="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde, eaque enim nihil non sit iure voluptate maxime placeat dolor quis." href="/" hrefText="Selengkapnya" />
        <x-home.card-fiture img="home/images/penginapan/1.jpg" title="Menggunakan AI" text="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde, eaque enim nihil non sit iure voluptate maxime placeat dolor quis." href="/" hrefText="Selengkapnya" />
        <x-home.card-fiture img="home/images/penginapan/1.jpg" title="Menggunakan AI" text="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde, eaque enim nihil non sit iure voluptate maxime placeat dolor quis." href="/" hrefText="Selengkapnya" />
        <x-home.card-fiture img="home/images/penginapan/1.jpg" title="Menggunakan AI" text="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Unde, eaque enim nihil non sit iure voluptate maxime placeat dolor quis." href="/" hrefText="Selengkapnya" />
      </div>
    </section>

    <!-- TENTANG KAMI SECTION -->
    <section id="tentang" class="pt-30">
      <div class="flex flex-col min-[901px]:flex-row justify-between gap-7 min-[950px]:gap-15 2xl:gap-25 items-center">
        <div class="grid grid-cols-2 gap-2 min-[370px]:h-[250px] h-[300px] min-[485px]:h-[350px] min-[600px]:h-[450px] min-[901px]:h-[350px] min-[1060px]:h-[450px] 2xl:h-[550px] items-center justify-items-center">
          <div>
            <div class="w-[150px] h-[200px] min-[370px]:h-[230px] min-[404px]:w-[180px] min-[404px]:h-[250px] min-[485px]:w-[200px] min-[485px]:h-[300px] min-[600px]:w-[250px] min-[600px]:h-[360px] min-[901px]:w-[200px] min-[901px]:h-[300px] min-[1060px]:w-[250px] min-[1060px]:h-[360px] 2xl:w-[300px] 2xl:h-[400px] rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/wisata/1.jpg') }}"  alt="Image About 1" class="w-full h-full object-cover"/>
            </div>
          </div>
          <div class="flex flex-col gap-5 justify-center">
            <div class="w-[120px] h-[100px] min-[370px]:w-[135px] min-[370px]:h-[120px] min-[404px]:w-[150px] min-[404px]:h-[130px] min-[485px]:w-[180px] min-[485px]:h-[180px] min-[600px]:w-[230px] min-[600px]:h-[230px] min-[901px]:w-[180px] min-[901px]:h-[180px] min-[1060px]:w-[230px] min-[1060px]:h-[230px] 2xl:w-[350px] 2xl:h-[250px] rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/wisata/2.jpg') }}"  alt="Image About 2" class="w-full h-full object-cover"/>
            </div>
            <div class="w-[90px] h-20 min-[370px]:w-[100px] min-[370px]:h-[90px] min-[404px]:w-[120px] min-[404px]:h-[90px] min-[485px]:w-[180px] min-[485px]:h-[150px] 2xl:w-[280px] 2xl:h-60 rounded-2xl shadow-xl overflow-hidden">
              <img src="{{ asset('/home/images/wisata/3.jpg') }}"  alt="Image About 3" class="w-full h-full object-cover"/>
            </div>
          </div>
        </div>
        <div class="flex-1">
          <h3 class="font-latin text-blue-500 text-[25px] xl:text-3xl 2xl:text-4xl -mb-3">Ayo Jelajahi Indonesia</h3>
          <h1 class="font-fredoka text-2xl xl:text-3xl 2xl:text-4xl font-semibold">Kami Hadir Untuk Menginspirasi Perjalananmu</h1>
          <p class="mt-5 text-sm xl:text-[15px] 2xl:text-[16px]">FK Travel adalah platform informasi pariwisata dan penginapan yang membantu traveler menemukan destinasi terbaik di Indonesia. Kami berkomitmen untuk menghadirkan pengalaman jelajah yang lebih mudah, akurat, dan menyenangkan mulai dari rekomendasi tempat wisata, penginapan, hingga panduan perjalanan yang kamu butuhkan.</p>
          <p class="mt-3 text-sm xl:text-[15px] 2xl:text-[16px]">Didirikan oleh Fahmy Bima Az Zukhruf dan Kirania Kharisa Suyatno pada tahun 2025, platform ini dibangun untuk mendukung industri pariwisata lokal dengan informasi yang menarik, teknologi modern dan tampilan yang ramah pengguna.</p>
          
          <div class="visimisiswapperabout hidden xl:block">
            <div class="button-container">
              <button id="visibtn">VISI</button>
              <button id="misibtn">MISI</button>
              <div id="visimisiindicator"></div>
            </div>
            <div class="content-text">
              <div id="contentBoxVisiMisi">
                <p id="visicontent">Menjadi platform informasi wisata terdepan di Indonesia yang menginspirasi jutaan traveler untuk menjelajahi keindahan negeri, memperkenalkan pesona budaya lokal, serta mendukung pertumbuhan pariwisata berkelanjutan di seluruh nusantara.</p>
                <ol id="misicontent">
                  <li>Menyediakan informasi destinasi dan penginapan yang akurat, menarik, dan mudah diakses.</li>
                  <li>Mendukung pariwisata lokal dengan menampilkan potensi terbaik dari setiap daerah.</li>
                        <li>Menghadirkan pengalaman digital yang modern dan menyenangkan bagi setiap pengguna.</li>
                      </ol>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="visimisiswapperabout block xl:hidden">
        <div class="button-container">
          <button id="visibtn">VISI</button>
          <button id="misibtn">MISI</button>
          <div id="visimisiindicator"></div>
        </div>
        <div class="content-text">
          <div id="contentBoxVisiMisi">
            <p id="visicontent">Menjadi platform informasi wisata terdepan di Indonesia yang menginspirasi jutaan traveler untuk menjelajahi keindahan negeri, memperkenalkan pesona budaya lokal, serta mendukung pertumbuhan pariwisata berkelanjutan di seluruh nusantara.</p>
            <ol id="misicontent">
              <li>Menyediakan informasi destinasi dan penginapan yang akurat, menarik, dan mudah diakses.</li>
              <li>Mendukung pariwisata lokal dengan menampilkan potensi terbaik dari setiap daerah.</li>
              <li>Menghadirkan pengalaman digital yang modern dan menyenangkan bagi setiap pengguna.</li>
            </ol>
          </div>
        </div>
      </div>

      <div>
        <h2 class="font-bold font-fredoka text-[22px] min-[475px]:text-2xl my-10 text-center">KONTRIBUTOR</h2>
        <div class="grid grid-cols-1 min-[575px]:grid-cols-2 min-[875px]:grid-cols-3 min-[1600px]:grid-cols-4 min-[1600px]:grid-cols-6 gap-5 justify-items-center">
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/1.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/2.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/3.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/4.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/5.png" />
          <x-home.card-kontributor linkinstagram="#" linklinkedin="#" linkgithub="#" nama="Fahmy Bima Az Zukhruf" role="Frontend Developer" profileimage="/home/images/avatar/6.png" />
        </div>
      </div>
    </section> 

    <section id="testimoni" class="pt-30">
      <div class="flex flex-col items-center">
        <h5 class="text-center font-latin text-[22px] min-[475px]:text-2xl min-[550px]:text-3xl font-bold text-blue-500">Testimoni Pengguna</h5>
        <h3 class="text-center font-extrabold text-2xl min-[475px]:text-3xl min-[550px]:text-4xl font-fredoka tracking-widest -mt-3">APA KATA MEREKA ?</h3>
        <p class="text-center text-[13px] min-[475px]:text-sm min-[550px]:text-[15px] mb-10 mt-3 w-full min-[750px]:w-[700px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque.</p>
      </div>

      <div class="grid grid-cols-1 min-[875px]:grid-cols-2 min-[1250px]:grid-cols-3 gap-5">
        <x-home.card-testimoni img="/home/images/avatar/1.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
        <x-home.card-testimoni img="/home/images/avatar/2.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
        <x-home.card-testimoni img="/home/images/avatar/3.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
        <x-home.card-testimoni img="/home/images/avatar/3.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
        <x-home.card-testimoni img="/home/images/avatar/3.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
        <x-home.card-testimoni img="/home/images/avatar/3.png" name="Fahmy Bima Az Zukhruf" role="Siswa SMKN 8 JEMBER" message="Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi nemo nostrum fugit. Numquam eos, perspiciatis adipisci doloribus ullam minus doloremque." />
      </div>
    </section>

    <section id="galeri" class="pt-30">
      <div class="titleSectionHome">
        <div>
            <h4 class="font-latin subtitle">Galeri Smart Sekolah</h4>
            <h2 class="font-fredoka title">Dokumentasi Perjalanan Kami</h2>
        </div>
        {{-- <a class="link linkhoveranimation text-[15px]" href='/wisata.html'>Terus Jelajahi <i class="fa-solid fa-arrow-right"></i></a> --}}
      </div>

      <div class="grid grid-cols-1 min-[780px]:grid-cols-2 min-[1090px]:grid-cols-3 min-[1390px]:grid-cols-4 min-[1700px]:grid-cols-4 gap-5 mt-10 justify-items-center">
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
        <x-home.card-gallery img="home/images/penginapan/1.jpg" title="SMKN 8 Jember" date="22 Februari 2024" />
      </div>
    </section>
              
    <!-- FOOTER SECTION -->
    @include('_home._layout.footer')
</body>
</html>