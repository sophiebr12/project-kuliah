 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

     <!-- Sidebar Toggle (Topbar) -->
     <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
         <i class="fa fa-bars"></i>
     </button>


     <div class="">
         <div class="navbar-nav mt-3 d-none d-sm-block">

         </div>
     </div>

     <ul class="navbar-nav ">
         <li class="nav-item dropdown no-arrow mt-3 d-none d-sm-block">
             <p class="small">
                 Halo Selamat datang kembali, {{ Auth()->User()->name }}
             </p>
         </li>
     </ul>

     <!-- Topbar Navbar -->
     <ul class="navbar-nav ml-auto">
         <!-- Nav Item - Messages -->
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                 <i class="fa-solid fa-circle-chevron-down me-2"></i>
                 <span class="mr-2 text-gray-600 small">{{ Auth()->User()->name }}</span>
                 @if (Auth()->user()->gambar == null)
                     @if (Auth()->user()->gender == 'Laki-Laki')
                         <img src="/asset/icons/profile-men.svg" class="img-profile rounded-circle me-2" alt="">
                     @else
                         <img src="/asset/icons/profile-women.svg" class="img-profile rounded-circle me-2"
                             alt="">
                     @endif
                 @else
                     <img class="img-profile rounded-circle me-2"
                         src="{{ url('asset/img/user-images/' . Auth()->user()->gambar) }}">
                 @endif
             </a>
             <!-- Dropdown - User Information -->
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="#" aria-expanded="false" data-toggle="modal"
                     data-target="#logoutModal">
                     <span class=" text-danger"><i class="fa-solid mr-2 fa-right-from-bracket"></i>
                         Logout</span>
                 </a>
             </div>
         </li>

     </ul>

 </nav>
