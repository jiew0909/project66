<?php 
    function isActive ($data) {
        $array = explode('/', $_SERVER['REQUEST_URI']);
        $key = array_search("pages", $array);
        $name = $array[$key + 1];
        return $name === $data ? 'active' : '' ;
    }
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto ">
        <li class="nav-item d-md-none d-block">
            <a href="../dashboard/">
                <img src="../../assets/images/AdminLogo.png" 
                    alt="Admin Logo" 
                    width="50px"
                    class="img-circle elevation-3">
                <span class="font-weight-light pl-1"></span>
            </a>
        </li>
        <!-- <li class="nav-item d-md-block d-none">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['AD_LOGIN'] ?>  </a>
        </li> -->
    </ul>
</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../dashboard/" class="brand-link">
        <img src="../../assets/images/123.png" 
             alt="Admin Logo" 
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">โพนทองสแตนเลส</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../assets/images/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="../employee/" class="d-block"> <?php echo $_SESSION['AD_NAME']?> </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../orders/" class="nav-link <?php echo isActive('orders') ?>">
                        <i class='fas fa-truck'></i>
                        <p>นัดติดตั้ง</p>
                    </a>
                <li class="nav-header">บัญชีของเรา</li>
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

