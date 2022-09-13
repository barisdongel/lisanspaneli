<?php
//Sayıları Göstermek için sorgular
$lisanssayisi = $db->prepare("SELECT COUNT(*) FROM lisans_tbl");
$lisanssayisi->execute();
$lisanssay = $lisanssayisi->fetchColumn();

$urunsayisi = $db->prepare("SELECT COUNT(*) FROM urun_tbl");
$urunsayisi->execute();
$urunsay = $urunsayisi->fetchColumn();
?>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon-square card-icon-bg-green">
        <i class="fas fa-key"></i>
      </div>
      <div class="card-wrap">
        <div class="padding-20">
          <div class="text-right">
            <h3 class="font-light mb-0">
              <i class="ti-arrow-up text-success"></i><?= $lisanssay ?>
            </h3>
            <span class="text-muted">Lisans</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon-square card-icon-bg-purple">
        <i class="fas fa-box"></i>
      </div>
      <div class="card-wrap">
        <div class="padding-20">
          <div class="text-right">
            <h3 class="font-light mb-0">
              <i class="ti-arrow-up text-success"></i><?= $urunsay ?>
            </h3>
            <span class="text-muted">Ürün</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>