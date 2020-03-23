<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Table untuk mengelola menu -->
    <div class="row">
        <div class="col-lg">
            <label for="formGroupExampleInput"><?= $this->session->userdata('code_competition'); ?></label>
            <!-- set grid system -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col" rowspan="2">#</th>
                                        <th scope="col" rowspan="2">MIP</th>
                                        <th scope="col" rowspan="2">Name</th>
                                        <th scope="col" colspan="2">
                                            <center>Productivity</center>
                                        </th>
                                        <th scope="col" colspan="2">
                                            <center>PM Complete</center>
                                        </th>
                                        <th scope="col" rowspan="2">Absent</th>
                                        <th scope="col" rowspan="2">SLA</th>
                                        <th scope="col" rowspan="2">Reward</th>
                                        <th scope="col" rowspan="2">Pinalty</th>
                                        <th scope="col" rowspan="2">Grand Total</th>
                                    </tr>
                                    <tr class="table-primary">
                                        <th scope="col">Point</th>
                                        <th scope="col">Score</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Score</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($competition as $sm) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $sm['mip']; ?></td>
                                            <td><?= $sm['nama']; ?></td>
                                            <td><?= $sm['productivity']; ?></td>
                                            <td><?= $sm['bobot_productivity']; ?></td>
                                            <td><?= $sm['pm']; ?></td>
                                            <td><?= $sm['bobot_pm']; ?></td>
                                            <td><?= $sm['bobot_absen']; ?></td>
                                            <td><?= $sm['mis_sla']; ?></td>
                                            <td><?= $sm['reward']; ?></td>
                                            <td><?= $sm['pinalty']; ?></td>
                                            <td><?= $sm['total'];; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <!-- tampil gambar pemenang -->
                        <div class="jumbotron jumbotron-fluid">
                            <div class="container text-center">
                                <img src="<?= base_url('assets/img/profile/') . $gambar['image']; ?>" width="100" class="figure-img img-fluid rounded-circle">
                                <p class="lead"><?= $gambar['nama']; ?></p>
                                <h6 class="display-8">Best Performance</h6>
                                <h8 class="display-8"><?= $gambar['code_competition']; ?></h8>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <a href="<?= base_url(''); ?>competition/tutuprankingcode" class="badge badge-primary" data-popup="tooltip" title="Back to scheduled"><i class="fas fa-fw fa-share"></i>Back to dashboard</a>
</div>
<!-- /.container-fluid -->



</div>
<!-- End of Main Content -->