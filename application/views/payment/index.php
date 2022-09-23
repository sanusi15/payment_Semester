<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing">

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <h6 class="mb-4">Semester</h6>
                                <tr>
                                    <select class="form-control " style="font-size:12px; font-family:'Poppins', sans-serif" id="semester">
                                        <option selected="selected" value="1">Satu</option>
                                        <option value="2">Dua</option>
                                        <option value="3">Tiga</option>
                                        <option value="4">Empat</option>
                                        <option value="5">Lima</option>
                                        <option value="6">Enam</option>
                                    </select>
                                </tr>
                                <tr class="text-center">
                                    <button class="btn btn-primary w-50 mt-3" onclick="lihatData()">
                                        Proses
                                    </button>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing detailBayar">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <form id="payment-form" method="post" action="<?= site_url() ?>snap/finish">
                            <input type="hidden" name="result_type" id="result-type" value="">
                            <input type="hidden" name="result_data" id="result-data" value="">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light  " style="font-size: 12px;">
                                        <tr class="text-center">
                                            <td>Nama</td>
                                            <td>NIM</td>
                                            <td>Jurusan</td>
                                            <td>Semester</td>
                                            <td>Jumlah Tagihan</td>
                                            <td>Cicilan 1</td>
                                            <td>Cicilan 2</td>
                                            <td>Total Bayar</td>
                                            <td>Keterangan</td>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <input type="hidden" value="" class="jml_tagihan" name="tagihan">
                                        <input type="hidden" value="" class="semester" name="semester">
                                        <td class="text-center" id="nama"></td>
                                        <td class="text-center" id="nim"></td>
                                        <td class="text-center" id="jurusan"></td>
                                        <td class="text-center" id="smstr"></td>
                                        <td id="jml_tagihan"></td>
                                        <td id="cicilan1"></td>
                                        <td id="cicilan2"></td>
                                        <td id="total_bayar"></td>
                                        <td class="text-center" id="keterangan"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <select class="form-control basic2" aria-label="Default select example" style="font-size:11px; font-family:'Poppins', sans-serif;" id="jenisBayar">
                                                <option selected disabled>Jenis Pembayaran</option>
                                                <option value="2" id="bayarfull">Bayar Full</option>
                                                <option value="1">Bayar 1/2</option>
                                            </select>
                                        </td>
                                        <td colspan="5" class="text-center">
                                            <button id="pay-button" class="btn btn-primary  w-50" style="font-size:13px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart mr-2">
                                                    <circle cx="9" cy="21" r="1"></circle>
                                                    <circle cx="20" cy="21" r="1"></circle>
                                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                                </svg>
                                                Bayar
                                            </button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="alert alert-warning text-center peringatan" role="alert">
                    Silahkan cek terlebih dahulu total biaya yang akan anda bayar, Jika tidak sesuai silahkan hubungi admin <br> Dan jangan lupa simpan (screenshoot) bukti pembayaran anda.
                </div>
            </div>
        </div>

        <div class="row layout-top-spacing">
            <div class="col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" style="font-size: 14px;">
                                <tr class="text-center">
                                    <td>No</td>
                                    <td>Waktu</td>
                                    <td>Bayar Semester</td>
                                    <td>Order Id</td>
                                    <td>Kode Pembayaran</td>
                                    <td>Total Bayar</td>
                                    <td>Jenis Pembayaran</td>
                                    <td>Status</td>
                                    <td>Aksi</td>
                                </tr>
                                <?php $i = 1;
                                foreach ($pending as $p) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++; ?></td>
                                        <td class="text-center"><?= $p['waktu']; ?></td>
                                        <td class="text-center"><?= $p['semester']; ?></td>
                                        <td><?= $p['order_id']; ?></td>
                                        <td><?= $p['kode_pembayaran']; ?></td>
                                        <td>Rp. <?= $p['total_bayar']; ?></td>
                                        <td class="text-center"><?= $p['method']; ?></td>
                                        <td class="text-center">
                                            <?php if ($p['status'] == '201') : ?>
                                                <span class="btn btn-warning w-100" style="font-size: 11px; margin:0; padding:4px;">Pending</span>
                                            <?php elseif ($p['status'] == '200') : ?>
                                                <span class="btn btn-success w-100" style="font-size: 11px; margin:0; padding:4px;">

                                                    Success</span>
                                            <?php else : ?>
                                                <span class="btn btn-danger w-100" style="font-size: 11px; margin:0; padding:4px;">Failed</span>
                                            <?php endif; ?>

                                        </td>
                                        <td class="text-center">
                                            <?php if ($p['method'] === 'gopay') : ?>
                                                -
                                            <?php else : ?>
                                                <a href="<?= $p['aksi']; ?>" style="font-size: 11px; margin:0; padding:4px;" class="btn btn-primary" target="_blank">Intruksi</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<!-- sweatAlert2 -->
<script src="<?= base_url('asset/js/sweatAlert2.js'); ?>"></script>

<script src="<?= base_url('asset/js/payment.js'); ?>"></script>