 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-desktop"></i>
         </div>
         <div class="sidebar-brand-text mx-3">Access Computer Admin
         </div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.home') }}">
             <i class="fas fa-fw fa-tachometer-alt"></i>
             <span>Dashboard</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Services
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#perangkat"
             aria-expanded="true" aria-controls="perangkat">
             <i class="fas fa-laptop"></i>
             <span>Perangkat</span>
         </a>
         <div id="perangkat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('admin.brand') }}">Merk</a>
                 <a class="collapse-item" href="{{ route('admin.laptop') }}">Perangkat</a>
             </div>
         </div>
     </li>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.service') }}">
             <i class="fas fa-tools"></i>
             <span>Layanan</span></a>
     </li>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.repair') }}">
             <i class="fas fa-wrench"></i>
             <span>Log Reparasi</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Heading -->
     <div class="sidebar-heading">
         Inventaris
     </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
             aria-expanded="true" aria-controls="collapsePages">
             <i class="fas fa-clipboard-list"></i>
             <span>Log Barang</span>
         </a>
         <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('admin.goodins.index') }}">Barang Masuk</a>
                 <a class="collapse-item" href="{{ route('admin.goodouts.index') }}">Barang Keluar</a>
             </div>
         </div>
     </li>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageBarang"
             aria-expanded="true" aria-controls="manageBarang">
             <i class="fas fa-boxes"></i>
             <span>Manage Barang</span>
         </a>
         <div id="manageBarang" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="{{ route('admin.goods') }}">Barang</a>
                 <a class="collapse-item" href="{{ route('admin.categories') }}">Kategori</a>
             </div>
         </div>
     </li>



     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">


     <!-- Heading -->
     <div class="sidebar-heading">
         Lainnya
     </div>

     <!-- Nav Item - Charts -->
     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.user') }}">
             <i class="fas fa-users"></i>
             <span>Pengguna</span></a>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="{{ route('admin.chat') }}">
             <i class="fas fa-comments"></i>
             <span>Live Chat</span>
             <span class="badge badge-danger badge-counter" id="chat-unread-badge" style="display: none;"></span>
         </a>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="{{ route('general.home') }}">
             <i class="fas fa-home"></i>
             <span>Halaman Utama</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">



     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>

 </ul>
 <!-- End of Sidebar -->
