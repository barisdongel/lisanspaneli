<?php
require_once 'inc/header.php';
require_once 'inc/sidebar.php';

//urunler
$products = $db->prepare("SELECT * FROM urun_tbl ORDER BY urun_id DESC LIMIT :lim");
$products->bindValue(':lim', (int) 10, PDO::PARAM_INT);
$products->execute();

//lisanslar
$licances = $db->prepare("SELECT * FROM lisans_tbl ORDER BY lisans_id DESC LIMIT :lim");
$licances->bindValue(':lim', (int) 10, PDO::PARAM_INT);
$licances->execute();

//son15gun
$last15day = $db->prepare("SELECT * FROM lisans_tbl WHERE lisans_bitis <= NOW() + INTERVAL 15 day");
$last15day->execute();
?>

<!-- Main Content -->
<div class="main-content">

	<?php include 'istatistikler.php'; ?>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					<h4 class="text-muted">Son 10 Ürün</h4>
				</div>
				<div class="card-body">
					<?php if ($products->rowCount()) { ?>
						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Ürün Adı</th>
										<th>Durum</th>
										<th>Tarih</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($products as $row) : ?>
										<tr>
											<td><?= $row['urun_id'] ?></td>
											<td><?= $row['urun_ad'] ?></td>
											<td><?= $row['urun_durum'] == 1 ? '<span class="alert alert-success p-2 text-center mt-3">Aktif</span>' : '<span class="alert alert-danger p-2 text-center mt-3">Pasif</span>' ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['urun_eklenme'])) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php } else {
						alert('danger', 'Kayıt bulunmuyor.');
					} ?>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">

					<h4 class="text-muted">Son 10 Lisans</h4>
				</div>
				<div class="card-body">
					<?php if ($licances->rowCount()) { ?>
						<div class="table-responsive">
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Alan Adı</th>
										<th>Durum</th>
										<th>Eklenme Tarihi</th>
										<th>Bitiş Tarihi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($licances as $row) : ?>
										<tr>
											<td><?= $row['lisans_id'] ?></td>
											<td><a href="<?= $row['lisans_domain'] ?>" target="_blank"><?= $row['lisans_domain'] ?></a></td>
											<td><?= $row['lisans_durum'] == 1 ? '<span class="alert alert-success p-2 text-center mt-3">Aktif</span>' : '<span class="alert alert-danger p-2 text-center mt-3">Pasif</span>' ?></td>
											<td><?= date('d.m.y H:i', strtotime($row['lisans_eklenme'])) ?></td>
											<td><?= date('d.m.y H:i:s', strtotime($row['lisans_bitis'])) ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php } else {
						alert('danger', 'Kayıt bulunmuyor.');
					} ?>
				</div>
			</div>
		</div>
		<div class="col-md-12 my-3">
			<div class="card">
				<div class="card-header">
					<h4 class="text-muted">Lisans Bitimine 15 Gün Kalan Alan Adları</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<?php if ($last15day->rowCount()) { ?>
							<table class="table table-striped table-hover" style="width:100%">
								<thead>
									<tr>
										<th>ID</th>
										<th>Alan Adı</th>
										<th>Eklenme Tarihi</th>
										<th>Bitiş Tarihi</th>
										<th>Kalan Gün</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($last15day as $row) :
										$edate = new DateTime($row['lisans_eklenme']);
										$bdate = new DateTime($row['lisans_bitis']);
										$interval = $edate->diff($bdate);
									?>
										<tr>
											<td><?= $row['lisans_id'] ?></td>
											<td><a href="<?= $row['lisans_domain'] ?>" target="_blank"><?= $row['lisans_domain'] ?></a></td>
											<td><?= date('d.m.y H:i', strtotime($row['lisans_eklenme'])) ?></td>
											<td><?= date('d.m.y H:i:s', strtotime($row['lisans_bitis'])) ?></td>
											<td><?= $interval->format('%a gün kaldı.') ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php } else {
							alert('danger', 'Kayıt bulunmuyor.');
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php require_once 'inc/footer.php' ?>