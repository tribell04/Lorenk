<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon">
            <i class="fas fa-house-user"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Panti Asuhan</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if ($user['role_id'] == 1) : // Sidebar untuk Admin ?>
        
        <!-- Heading -->
        <div class="sidebar-heading">
            Administrator
        </div>

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $title == 'Dashboard' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Admin -->
        <li class="nav-item <?= $title == 'Kelola Admin' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/kelola_admin'); ?>">
                <i class="fas fa-user-cog"></i>
                <span>Kelola Admin</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Donatur -->
        <li class="nav-item <?= $title == 'Data Donatur' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/donatur'); ?>">
                <i class="fas fa-users"></i>
                <span>Donatur</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Donasi -->
        <li class="nav-item <?= $title == 'Kelola Donasi' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/donasi'); ?>">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Kelola Donasi</span>
            </a>
        </li>

        <!-- Nav Item - Kelola Program Donasi -->
        <li class="nav-item <?= $title == 'Kelola Program Donasi' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/program'); ?>">
                <i class="fas fa-clipboard-list"></i>
                <span>Kelola Program Donasi</span>
            </a>
        </li>

        <!-- Nav Item - Laporan Penggalangan -->
        <li class="nav-item <?= $title == 'Laporan Penggalangan Dana' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
                <i class="fas fa-print"></i>
                <span>Laporan Penggalangan</span>
            </a>
        </li>

    <?php else : // Sidebar untuk Donatur ?>
        
        <!-- Heading -->
        <div class="sidebar-heading">
             Donatur
        </div>

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $title == 'Dashboard' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('user'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Donasi -->
        <li class="nav-item <?= $title == 'Donasi' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('user/donasi'); ?>">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Donasi</span>
            </a>
        </li>

        <!-- Nav Item - Riwayat Donasi -->
        <li class="nav-item <?= $title == 'Riwayat Donasi' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('user/riwayat_donasi'); ?>">
                <i class="fas fa-history"></i>
                <span>Riwayat Donasi</span>
            </a>
        </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        User
    </div>

    <!-- Nav Item - My Profile -->
    <li class="nav-item <?= $title == 'My Profile' ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('user/profile'); ?>">
            <i class="fas fa-user"></i>
            <span>My Profile</span>
        </a>
    </li>

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
