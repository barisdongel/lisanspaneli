<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <ul class="sidebar-menu">
      <li class="dropdown active" style="display: block;">
        <div class="sidebar-profile">
          <div class="siderbar-profile-pic">
            <img src="<?= site ?>/assets/img/users/avatar.png" class="profile-img-circle box-center" alt="User Image">
          </div>
          <div class="siderbar-profile-details">
            <div class="siderbar-profile-name">HOŞGELDİN</div>
            <div class="siderbar-profile-name text-warning">Admin </div>
          </div>
      </li>
      <li class="menu-header">Admin Menü</li>
      <li><a class="nav-link" href="index.php"><i class="fas fa-home"></i><span>Admin Paneli Anasayfa</span></a></li>

      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i><span>Ürünler</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?= site . '/process.php?process=productlist' ?>">Ürün Listesi</a></li>
          <li><a class="nav-link" href="<?= site . '/process.php?process=newproduct' ?>">Yeni Ürün Ekle</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-key"></i><span>Lisanslar</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?= site . '/process.php?process=licenselist' ?>">Lisanslar</a></li>
          <li><a class="nav-link" href="<?= site . '/process.php?process=newlicense' ?>">Lisans Listesi</a></li>
        </ul>
      </li>

      <li><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Çıkış Yap</span></a></li>
    </ul>
  </aside>
</div>