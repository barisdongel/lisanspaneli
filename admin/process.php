<?php
require_once 'inc/header.php';
require_once 'inc/sidebar.php';

if (isset($_GET['process'])) {
	if (get('process') == "productlist") {
		$title = "Ürün Listesi";
	} else if (get('process') == "licencelist") {
		$title = "Lisans Listesi";
	}
}
?>
<!-- Main Content -->
<div class="main-content">
	<div class="col-12 col-md-12 col-lg-12">
		<div class="card">

			<?php
			$process = get('process');
			if (!$process) {
				go(site);
			}

			switch ($process) {
				case 'productlist':
					$s = @intval(get('s'));
					if (!$s) {
						$s = 1;
					}

					$query = $db->prepare("SELECT * FROM urun_tbl ORDER BY urun_id DESC");
					$query->execute();
					$total = $query->rowCount();
					$lim = 20;
					$show = $s * $lim - $lim;

					$query = $db->prepare("SELECT * FROM urun_tbl ORDER BY urun_id DESC LIMIT :show, :lim");
					$query->bindValue(":show", (int) $show, PDO::PARAM_INT);
					$query->bindValue(":lim", (int) $lim, PDO::PARAM_INT);
					$query->execute();

					if ($s > ceil($total / $lim)) {
						$s = 1;
					}

					if ($query->rowCount()) {
			?>
						<form action="" method="POST">
							<input type="text" class="form-control" name="pname" placeholder="Ürün adı giriniz">
						</form>
						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Ürün Adı</th>
										<th>Ürün Kodu</th>
										<th>Tarih</th>
										<th>İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($query as $row) : ?>
										<tr>
											<td>#<?= $row['urun_id'] ?></td>
											<td><?= $row['urun_ad'] ?></td>
											<td><?= $row['urun_key'] ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['urun_eklenme'])) ?></td>
											<td>
												<a href="#" class="btn btn-outline-info fw-bold"><i class="fa fa-edit"></i> Düzenle</a>
												<a href="#" class="btn btn-outline-primary fw-bold"><i class="fa fa-trash"></i> Sil</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="pagination">
							<ul>
								<?php
								if ($total > $lim) {
									pagination($s, ceil($total / $lim), 'process.php?process=productlist&s=');
								}
								?>
							</ul>
						</div>
					<?php
					} else {
						alert('danger', 'Kayıt bulunamadı');
					}

					break;

				case 'licenselist':
					$s = @intval(get('s'));
					if (!$s) {
						$s = 1;
					}

					$query = $db->prepare("SELECT * FROM lisans_tbl ORDER BY lisans_id DESC");
					$query->execute();
					$total = $query->rowCount();
					$lim = 20;
					$show = $s * $lim - $lim;

					$query = $db->prepare("SELECT * FROM lisans_tbl ORDER BY lisans_id DESC LIMIT :show, :lim");
					$query->bindValue(":show", (int) $show, PDO::PARAM_INT);
					$query->bindValue(":lim", (int) $lim, PDO::PARAM_INT);
					$query->execute();

					if ($s > ceil($total / $lim)) {
						$s = 1;
					}

					if ($query->rowCount()) {
					?>
						<form action="" method="POST">
							<input type="text" class="form-control" name="pname" placeholder="Alan adı giriniz">
						</form>
						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Alan Adı</th>
										<th>Eklenme Tarihi</th>
										<th>Bitiş Tarihi</th>
										<th>Kalan Gün Sayısı</th>
										<th>İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($query as $row) :
										$edate = new DateTime($row['lisans_eklenme']);
										$bdate = new DateTime($row['lisans_bitis']);
										$interval = $edate->diff($bdate);

									?>
										<tr>
											<td>#<?= $row['lisans_id'] ?></td>
											<td><?= $row['lisans_domain'] ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['lisans_eklenme'])) ?></td>
											<td><?= date('d.m.y H:i:s', strtotime($row['lisans_bitis'])) ?></td>
											<td><?= $interval->format('%a gün kaldı.') ?></td>
											<td>
												<a href="#" class="btn btn-outline-info fw-bold"><i class="fa fa-edit"></i> Düzenle</a>
												<a href="#" class="btn btn-outline-primary fw-bold"><i class="fa fa-trash"></i> Sil</a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="pagination">
							<ul>
								<?php
								if ($total > $lim) {
									pagination($s, ceil($total / $lim), 'process.php?process=licenselist&s=');
								}
								?>
							</ul>
						</div>
			<?php
					} else {
						alert('danger', 'Kayıt bulunamadı');
					}

					break;
			}
			?>
		</div>
	</div>
</div>
</div>
<?php require_once 'inc/footer.php' ?>