<script>
    function pbuton() {
        var data = $("#pform").serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: "<?= site ?>/inc/newproductdata.php",
            success: function(result) {
                if ($.trim(result) == "empty") {
                    Swal.fire(
                        'Uyarı!',
                        'Boş alan bırakmayınız',
                        'warning'
                    )
                } else if ($.trim(result) == "error") {
                    Swal.fire(
                        'Hata!',
                        'Bir sorun oluştu',
                        'danger'
                    )
                } else if ($.trim(result) == "already") {
                    Swal.fire(
                        'Hata!',
                        'Ürün kodu zaten kayıtlı',
                        'warning'
                    )
                } else if ($.trim(result) == "ok") {
                    Swal.fire(
                        'Başarılı',
                        'Ürün başarıyla eklendi',
                        'success'
                    );
                    setTimeout(function() {
                        window.location = "<?= site ?>/process.php?process=productlist"
                    }, 2000);
                }
            }
        })
    }

    function lbuton() {
        var data = $("#lform").serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: "<?= site ?>/inc/newlicensedata.php",
            success: function(result) {
                if ($.trim(result) == "empty") {
                    Swal.fire(
                        'Uyarı!',
                        'Boş alan bırakmayınız',
                        'warning'
                    )
                } else if ($.trim(result) == "error") {
                    Swal.fire(
                        'Hata!',
                        'Bir sorun oluştu',
                        'danger'
                    )
                } else if ($.trim(result) == "already") {
                    Swal.fire(
                        'Hata!',
                        'Lisans kodu zaten kayıtlı',
                        'warning'
                    )
                } else if ($.trim(result) == "ok") {
                    Swal.fire(
                        'Başarılı',
                        'Lisans başarıyla eklendi',
                        'success'
                    );
                    setTimeout(function() {
                        window.location = "<?= site ?>/process.php?process=licenselist"
                    }, 2000);
                }
            }
        })
    }

    function pupbuton() {
        var data = $("#pupform").serialize();
        $.ajax({
            type: "POST",
            data: data,
            url: "<?= site ?>/inc/producteditdata.php",
            success: function(result) {
                if ($.trim(result) == "empty") {
                    Swal.fire(
                        'Uyarı!',
                        'Boş alan bırakmayınız',
                        'warning'
                    )
                } else if ($.trim(result) == "error") {
                    Swal.fire(
                        'Hata!',
                        'Bir sorun oluştu',
                        'danger'
                    )
                } else if ($.trim(result) == "already") {
                    Swal.fire(
                        'Hata!',
                        'Ürün kodu zaten kayıtlı',
                        'warning'
                    )
                } else if ($.trim(result) == "ok") {
                    Swal.fire(
                        'Başarılı',
                        'Ürün Güncellendi',
                        'success'
                    );
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }
        })
    }
</script>