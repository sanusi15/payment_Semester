$('.detailBayar').hide();
var url = 'http://localhost:8011/paySemester';
function lihatData() {
    var semester = $('#semester').val();
    $('.semester').val(semester);
    if (semester == null) {
        Swal.fire({
            icon: 'warning',
            title: 'Harap pilih semester',
            text: 'Terima kasih!',
            iconColor: '#f44336',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: '#d33',
            cancelButtonText: 'Oke!',
            timer: 2000
        })
    } else {
        console.log(semester);
        $.ajax({
            url: url + '/Payment/lihatData',
            type: 'POST',
            data: {
                semester: semester
            },
            success: function (data) {
                loading()
                var data = JSON.parse(data);
                console.log(data);
                $('#nama').html(data.nama);
                $('#nim').html(data.nim);
                $('#jurusan').html(data.jurusan);
                $('#smstr').html(data.semester);
                $('#jml_tagihan').html(formatRupiah(data.jml_tagihan, 'Rp. '));
                $('.jml_tagihan').val(data.jml_tagihan);
                $('#cicilan1').html(formatRupiah(data.cicilan1, 'Rp. '));
                $('#cicilan2').html(formatRupiah(data.cicilan2, 'Rp. '));
                $('#total_bayar').html(formatRupiah(data.total_bayar, 'Rp. '));
                $('#keterangan').html(data.keterangan);
                $('.detailBayar').show();            
                
                // menghilangkan pilihan bayar saat udah bayar cicilan
                var total_bayar = parseInt(data.total_bayar);
                var total_tagihan = parseInt(data.jml_tagihan);
                if (total_bayar < total_tagihan) {
                    $('#bayarfull').hide();
                } else {
                    $('#bayarfull').show();
                }

                // dissable tombol bayar jika sudah lunas                
                if (data.keterangan == 'LUNAS') {
                    $('#pay-button').hide();
                } else {
                    $('#pay-button').show();
                }
            }            
        });
    }
}

/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

// Fungsi loading
function loading() {
    let timerInterval
    Swal.fire({
        title: 'Please wait',
        html: 'is retrieving data from <b></b>',
        timer: 1000,
        timerProgressBar: true,
        iconColor: '#f44336',
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
    })
}