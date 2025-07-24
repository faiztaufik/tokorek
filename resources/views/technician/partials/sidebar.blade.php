 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('technician.home') }}">
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
         <a class="nav-link" href="{{ route('technician.home') }}">
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
                 <a class="collapse-item" href="{{ route('technician.brand') }}">Merk</a>
                 <a class="collapse-item" href="{{ route('technician.laptop') }}">Perangkat</a>
             </div>
         </div>
     </li>

     <li class="nav-item">
         <a class="nav-link" href="{{ route('technician.repair') }}">
             <i class="fas fa-wrench"></i>
             <span>Log Reparasi</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block">


     <!-- Heading -->
     <div class="sidebar-heading">
         Lainnya
     </div>

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
