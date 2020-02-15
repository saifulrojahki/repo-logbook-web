<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>

    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Competition</th>
                            <th>Service Point</th>
                            <th>Entry Data</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($competition as $sm) : ?>
                            <tr>
                                <td><?= $sm['code_competition']; ?></td>
                                <td><?= $sm['servicepoint']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/bukaproductivitycode/<?= $sm['id']; ?>" class="badge badge-primary" data-popup="tooltip" title="Productivity" data-id="<?= $sm['id']; ?>"><i class="fas fa-user-clock"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/bukaabsencode/<?= $sm['id']; ?>" class="badge badge-secondary" data-popup="tooltip" title="Absent"><i class="far fa-clipboard" data-id="<?= $sm['id']; ?>"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/bukapmcode/<?= $sm['id']; ?>" class="badge badge-warning" data-popup="tooltip" title="PM Completion Date" data-id="<?= $sm['id']; ?>"><i class="fas fa-tasks"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/bukaslacode/<?= $sm['id']; ?>" class="badge badge-danger" data-popup="tooltip" title="Mis SLA" data-id="<?= $sm['id']; ?>"><i class="fas fa-bullseye"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/bukarewardcode/<?= $sm['id']; ?>" class="badge badge-success" data-popup="tooltip" title="Reward and Punisment" data-id="<?= $sm['id']; ?>"><i class="fas fa-dollar-sign"></i></a>
                                </td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/bukapesertacode/<?= $sm['id']; ?>" class="badge badge-success" data-popup="tooltip" title="Add Participant" data-id="<?= $sm['id']; ?>">Participant</a> |
                                    <a href="<?= base_url(''); ?>competition/competitionhapus/<?= $sm['id']; ?>" class="badge badge-danger tombol-takeout" data-popup="tooltip" title="Delete Competition">Delete</a> |
                                    <a href="<?= base_url(''); ?>competition/closed/<?= $sm['id']; ?>" class="badge badge-secondary tombol-takeout" data-popup="tooltip" title="Closed Competition" data-id="<?= $sm['id']; ?>">Closed</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->