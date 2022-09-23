</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

<script src="<?= base_url('templates/') ?>bootstrap/js/popper.min.js"></script>
<script src="<?= base_url('templates/') ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url('templates/') ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= base_url('templates/') ?>assets/js/app.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?= base_url('templates/') ?>plugins/highlight/highlight.pack.js"></script>
<script src="<?= base_url('templates/') ?>assets/js/custom.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?= base_url('templates/') ?>plugins/apex/apexcharts.min.js"></script>
<script src="<?= base_url('templates/') ?>assets/js/dashboard/dash_1.js"></script>
<script src="<?= base_url('templates/') ?>plugins/font-icons/feather/feather.min.js"></script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<!-- SELECT2 -->
<script src="<?= base_url('templates/') ?>assets/js/scrollspyNav.js"></script>
<script src="<?= base_url('templates/') ?>plugins/select2/select2.min.js"></script>
<script src="<?= base_url('templates/') ?>plugins/select2/custom-select2.js"></script>
<script>
    var ss = $(".basic").select2({
        tags: false,
    });
</script>
<!-- END SELECT2 -->



<!-- midtrans -->
<script type="text/javascript">
    $('#pay-button').click(function(event) {
        // alert('ok')
        event.preventDefault();
        // $(this).attr("disabled", "disabled");

        var nim = $('#nim').html();
        var semester = $('#smstr').html();
        var jmlTagihan = $('.jml_tagihan').val();
        console.log(nim, semester, jmlTagihan);
        // konvert jadi int
        var convTagihan = parseInt(jmlTagihan);
        var jenisBayar = $('#jenisBayar').val();
        if (jenisBayar == 1) {
            var jmlBayar = convTagihan / 2;
        } else if (jenisBayar == null) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih jenis pembayaran terlebih dahulu',
                text: 'Terima kasih!',
                iconColor: '#f44336',
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Oke!',
                timer: 2000
            })
        } else {
            var jmlBayar = convTagihan;
        }

        $.ajax({
            url: '<?= site_url() ?>snap/token',
            data: {
                nim: nim,
                semester: semester,
                jmlBayar: jmlBayar,
            },
            method: 'POST',
            cache: false,
            success: function(data) {
                //location = data;

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function(result) {
                        changeResult('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        $("#payment-form").submit();
                    },
                    onPending: function(result) {
                        changeResult('pending', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    },
                    onError: function(result) {
                        changeResult('error', result);
                        console.log(result.status_message);
                        $("#payment-form").submit();
                    }
                });
            }
        });
    });
</script>


</body>

<!-- Mirrored from designreset.com/cork/ltr/demo2/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Jul 2022 03:49:47 GMT -->

</html>