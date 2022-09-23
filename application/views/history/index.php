    <div class="container">
        <div class="card">
            <div class="row p-3">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <td>No</td>
                            <td>Bayar Semester</td>
                            <td>Order Id</td>
                            <td>Total Bayar</td>
                            <td>Jenis Pembayaran</td>
                            <td>Status</td>
                        </tr>
                        <?php $i = 1;
                        foreach ($sukses as $d) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center"><?= $d['semester']; ?></td>
                                <td><?= $d['order_id']; ?></td>
                                <td><?= $d['total_bayar']; ?></td>
                                <td><?= $d['method']; ?></td>
                                <td class="text-center">
                                    <span class="btn btn-success w-100" style="font-size: 11px; margin:0; padding:4px;">

                                        Success</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>