<?php
require_once 'inc/header.php';
require_once 'inc/sidebar.php';

if (isset($_GET['process'])) {
	if (get('process') == "productlist") {
		$title = "Ürün Listesi";
	} else if (get('process') == "licenselist") {
		$title = "Lisans Listesi";
	} else if (get('process') == "newproduct") {
		$title = "Yeni Ürün Ekleme";
	} else if (get('process') == "newlicense") {
		$title = "Yeni Lisans Ekleme";
	} else if (get('process') == "productedit") {
		$title = "Ürün Düzenleme";
	} else {
		$title = "Lisans paneli";
	}
}
?>
<!-- Main Content -->
<div class="main-content">
	<div class="col-12 col-md-12 col-lg-12">
		<h4 class="text-muted"><?= $title ?></h4>
		<div class="card">

			<?php
			$process = get('process');
			if (!$process) {
				go(site);
			}

			switch ($process) {

				case 'productedit':
					$pkey = get('key');

					if (!$pkey) {
						go(site);
					}

					$query = $db->prepare("SELECT * FROM urun_tbl WHERE urun_key=:k");
					$query->execute([':k' => $pkey]);
					if ($query->rowCount()) {
						$row = $query->fetch(PDO::FETCH_OBJ);
			?>
						<form action="" method="POST" id="pupform" onsubmit="return false;">
							<input type="hidden" name="pid" value="<?= $row->urun_id ?>">
							<div class="card-body">
								<div class="form-group">
									<label><i class="fa fa-heading text-primary"></i> Ürün Adı</label>
									<input type="text" name="pname" class="form-control" value="<?= $row->urun_ad ?>">
								</div>
								<div class="form-group">
									<label><i class="fa fa-key text-primary"></i> Ürün Durum</label>
									<select class="form-select" name="pstatus">
										<option value="1" <?= $row->urun_durum == 1 ? 'selected' : '' ?>>Aktif</option>
										<option value="0" <?= $row->urun_durum == 0 ? 'selected' : '' ?>>Pasif</option>
									</select>
								</div>
								<div class="form-group">
									<label><i class="fa fa-key text-primary"></i> Ürün Anahtarı</label>
									<div class="alert alert-warning p-2 w-50">Ürün anahtarını değiştirmeniz durumunda, lisans kodunu ilgili siteye girmezseniz lisans çalışmayacaktır !</div>
									<input type="text" name="pcode" id="pkey" class="form-control" value="<?= $row->urun_key ?>">
									<a onclick="randomString('12','pkey'); return false;" class="btn btn-outline-primary my-3"><i class="fa fa-pencil-alt"></i> Anahtar üret</a>
								</div>
							</div>
							<div class="col-md-12 text-left mb-3">
								<button class="btn btn-info" onclick="pupbuton();" id="pbutton" type="submit"><i class="fa fa-plus"></i> Güncelle</button>
								<a class="btn btn-warning" href="process.php?process=productlist"><i class="fa fa-long-arrow-alt-left"></i> Geri Dön</a>
							</div>
						</form>
					<?php
					} else {
						go(site);
					}

					break;

				case 'deletelicense':
					$pkey = get('key');

					if (!$pkey) {
						go(site);
					}
					$query = $db->prepare("SELECT lisans_key FROM lisans_tbl WHERE lisans_key=:k");
					$query->execute([':k' => $pkey]);
					if ($query->rowCount()) {
						$up = $db->prepare("UPDATE lisans_tbl SET lisans_durum=:d WHERE lisans_key=:k");
						$up->execute([':d' => 0, ':k' => $pkey]);
						if ($up) {
							$upp = $db->prepare("UPDATE lisans_tbl SET lisans_durum=:d WHERE lisans_urun=:u");
							$upp->execute([':d' => 0, ':u' => $pkey]);
							alert("success", "Lisans silinmiştir.");
							go(site . '/process.php?process=licenselist', 2);
						} else {
							alert('danger', 'Hata!');
						}
					} else {
						alert('danger', 'Hata!');
					}
					break;

				case 'deleteproduct':
					$pkey = get('key');

					if (!$pkey) {
						go(site);
					}
					$query = $db->prepare("SELECT urun_key FROM urun_tbl WHERE urun_key=:k");
					$query->execute([':k' => $pkey]);
					if ($query->rowCount()) {
						$up = $db->prepare("UPDATE urun_tbl SET urun_durum=:d WHERE urun_key=:k");
						$up->execute([':d' => 0, ':k' => $pkey]);
						if ($up) {
							$upp = $db->prepare("UPDATE lisans_tbl SET lisans_durum=:d WHERE lisans_urun=:u");
							$upp->execute([':d' => 0, ':u' => $pkey]);
							alert("success", "Ürün ve ürüne ait lisanslar silinmiştir.");
							go(site . '/process.php?process=productlist', 2);
						} else {
							alert('danger', 'Hata!');
						}
					} else {
						alert('danger', 'Hata!');
					}
					break;


				case 'newlicense':
					?>
					<form action="" method="POST" id="lform" onsubmit="return false;">
						<div class="card-body">
							<div class="form-group">
								<label><i class="fa fa-heading text-primary"></i> Lisans Domain</label>
								<input type="text" name="ldomain" class="form-control" placeholder="http:// veya https:// şeklinde giriniz.">
							</div>
							<div class="form-group">
								<label><i class="fa fa-clock text-primary"></i> Lisans Bitiş Tarihi</label>
								<input type="datetime-local" name="ltime" class="form-control">
							</div>
							<div class="form-group">
								<label><i class="fa fa-box text-primary"></i> Ürün Adı</label>
								<select class="form-select" name="pname">
									<option value="0">Ürün Seçiniz</option>
									<?php
									$plist = $db->prepare("SELECT * FROM urun_tbl WHERE urun_durum=:d");
									$plist->execute([':d' => 1]);
									if ($plist->rowCount()) {
										foreach ($plist as $row) {
											echo '<option value="' . $row["urun_key"] . '">' . $row['urun_ad'] . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label><i class="fa fa-key text-primary"></i> Lisans Anahtarı</label>
								<input type="text" name="lcode" id="pkey" class="form-control">
								<a onclick="randomString('32','pkey'); return false;" class="btn btn-outline-primary my-3"><i class="fa fa-pencil-alt"></i> Anahtar üret</a>
							</div>
						</div>
						<div class="col-md-12 text-left mb-3">
							<button class="btn btn-info" onclick="lbuton();" id="pbutton" type="submit"><i class="fa fa-plus"></i> Ekle</button>
							<a class="btn btn-warning" href="index.php"><i class="fa fa-long-arrow-alt-left"></i> Geri Dön</a>
						</div>
					</form>
				<?php
					break;

				case 'newproduct':
				?>
					<form action="" method="POST" id="pform" onsubmit="return false;">
						<div class="card-body">
							<div class="form-group">
								<label><i class="fa fa-heading text-primary"></i> Ürün Adı</label>
								<input type="text" name="pname" class="form-control">
							</div>
							<div class="form-group">
								<label><i class="fa fa-key text-primary"></i> Ürün Anahtarı</label>
								<input type="text" name="pcode" id="pkey" class="form-control">
								<a onclick="randomString('12','pkey'); return false;" class="btn btn-outline-primary my-3"><i class="fa fa-pencil-alt"></i> Anahtar üret</a>
							</div>
						</div>
						<div class="col-md-12 text-left mb-3">
							<button class="btn btn-info" onclick="pbuton();" id="pbutton" type="submit"><i class="fa fa-plus"></i> Ekle</button>
							<a class="btn btn-warning" href="index.php"><i class="fa fa-long-arrow-alt-left"></i> Geri Dön</a>
						</div>
					</form>
					<?php
					break;

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
							<input type="text" class="form-control rounded-0" name="pname" placeholder="Ürün adı giriniz">
						</form>
						<a href="<?= site ?>/process.php?process=newproduct" class="btn btn-success rounded-0"><i class="fa fa-plus"></i> Yeni Ekle</a>
						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Ürün Adı</th>
										<th>Ürün Kodu</th>
										<th>Tarih</th>
										<th>Durum</th>
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
											<td><?= $row['urun_durum'] == 1 ? '<span class="alert alert-success p-2 text-center mt-3">Aktif</span>' : '<span class="alert alert-danger p-2 text-center mt-3">Pasif</span>' ?></td>

											<td>
												<a href="<?= site . "/process.php?process=productedit&key=" . $row['urun_key'] ?>" class="btn btn-outline-info fw-bold"><i class="fa fa-edit"></i> Düzenle</a>
												<a onclick="return confirm('Silmek istediğinizden emin misiniz ?')" href="<?= site . "/process.php?process=deleteproduct&key=" . $row['urun_key'] ?>" class="btn btn-outline-primary fw-bold <?php echo $row['urun_durum'] == 1 ? '' : 'd-none' ?>"><i class="fa fa-trash"></i> Sil</a>
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
										<th>Lisans Key</th>
										<th>Eklenme Tarihi</th>
										<th>Bitiş Tarihi</th>
										<th>Kalan Gün Sayısı</th>
										<th>Durum</th>
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
											<td><?= $row['lisans_key'] ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['lisans_eklenme'])) ?></td>
											<td><?= date('d.m.y H:i:s', strtotime($row['lisans_bitis'])) ?></td>
											<td><?= $interval->format('%a gün kaldı.') ?></td>
											<td><?= $row['lisans_durum'] == 1 ? '<span class="alert alert-success p-2 text-center mt-3">Aktif</span>' : '<span class="alert alert-danger p-2 text-center mt-3">Pasif</span>' ?></td>
											<td>
												<a href="#" class="btn btn-outline-info fw-bold"><i class="fa fa-edit"></i> Düzenle</a>
												<a onclick="return confirm('Silmek istediğinizden emin misiniz ?')" href="<?= site . '/process.php?process=deletelicense&key=' . $row['lisans_key'] ?>" class="btn btn-outline-primary fw-bold <?php echo $row['lisans_durum'] == 1 ? '' : 'd-none' ?>""><i class=" fa fa-trash"></i> Sil</a>
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
<?php require_once 'inc/footer.php' ?>