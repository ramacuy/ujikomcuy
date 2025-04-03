<nav id="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="index.php?page=home" class="nav-link text-white">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>


        <!-- User Management -->
        <li class="nav-item">
            <a href="index.php?page=supplier" class="nav-link text-white">
                <i class="fas fa-user"></i>supplier
            </a>
        </li>
        <!-- User Management -->
        <li class="nav-item">
            <a href="index.php?page=login" class="nav-link text-white">
                <i class="fas fa-user"></i> Data User
            </a>
        </li>

        <!-- Pengaturan & Lainnya (Dropdown) -->
        <li class="nav-item">
            <a href="#" class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#pengaturan">
                <i class="fas fa-cogs"></i> Pengaturan <i class="fas fa-chevron-down float-end"></i>
            </a>
            <ul id="pengaturan" class="collapse nav flex-column ms-3">
                <li class="nav-item"><a href="index.php?page=setting-profile" class="nav-link text-white">Setting Profile</a></li>
                <li class="nav-item"><a href="index.php?page=history-aktivitas" class="nav-link text-white">History Aktivitas</a></li>
                <li class="nav-item"><a href="index.php?page=import-export" class="nav-link text-white">Import & Export Data</a></li>
            </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a href="logout.php" class="nav-link text-white">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </li>
    </ul>
</nav>