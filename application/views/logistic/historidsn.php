<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Table untuk mengelola menu -->
    <div class="row">
        <div class="col-lg-10">


            <!-- Menampilkan pesan sweeetalert sesuai tombol aksi
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div> -->

            <!-- menu searching -->
            <div class="row">
                <div class="col-md-5">
                    <form action="<?= base_url('logistic/historidsn'); ?>" method="post">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search Serial Number Device..." name="keyword" autocomplete="off" value="<?php echo set_value('keyword'); ?>" autofocus>
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" name="submit" value="Search">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- tampil total data 
            <h5>Results : <?= $total_rows; ?></h5> -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">SN Device</th>
                        <th scope="col">Service Point</th>
                        <th scope="col">Activity</th>
                        <th scope="col">Date</th>
                        <th scope="col">Remark</th>


                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($device as $sm) : ?>
                        <tr>
                            <th scope="row"><?= ++$start; ?></th>
                            <td><?= $sm['sndevice']; ?></td>
                            <td><?= $sm['servicepoint']; ?></td>
                            <td><?= $sm['action']; ?></td>
                            <td><?= date('d F Y', $sm['tanggal']); ?></td>
                            <td><?= $sm['keterangan']; ?></td>


                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- page pagination -->
            <?= $this->pagination->create_links(); ?>
        </div>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->