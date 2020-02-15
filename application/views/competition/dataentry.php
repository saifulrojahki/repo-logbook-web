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
                                    <a href="<?= base_url(''); ?>competition/productivity/<?= $sm['id_sae']; ?>/<?= $bln['bulan']; ?>/<?= $thn['tahun']; ?>" class="badge badge-success" data-popup="tooltip" title="Productivity" data-toggle="modal" data-target="#newPointModal" data-id="<?= $sm['id_sae']; ?>"><i class="fas fa-money-bill-wave"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/absen/<?= $sm['id_sae']; ?>/<?= $bln['bulan']; ?>/<?= $thn['tahun']; ?>" class="badge badge-secondary" data-popup="tooltip" title="Absent" data-id="<?= $sm['id_sae']; ?>"><i class="far fa-clipboard"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/pm/<?= $sm['id_sae']; ?>/<?= $bln['bulan']; ?>/<?= $thn['tahun']; ?>" class="badge badge-warning tampilDSNKeluar" data-popup="tooltip" title="PM Completion Date" data-toggle="modal" data-target="#newPointModal" data-id="<?= $sm['id_sae']; ?>"><i class="fas fa-tasks"></i></a> |
                                    <a href="<?= base_url(''); ?>competition/sla/<?= $sm['id_sae']; ?>/<?= $bln['bulan']; ?>/<?= $thn['tahun']; ?>" class="badge badge-danger" data-popup="tooltip" title="SLA" data-id="<?= $sm['id_sae']; ?>"><i class="fas fa-bullseye"></i></a>
                                </td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/productivity/<?= $sm['id_sae']; ?>/<?= $bln['bulan']; ?>/<?= $thn['tahun']; ?>" class="badge badge-success" data-popup="tooltip" title="Productivity" data-toggle="modal" data-target="#newPointModal" data-id="<?= $sm['id_sae']; ?>">Closed</i></a>
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

<!-- Modal untuk tombol add menu-->
<div class="modal fade" id="newPointModal" tabindex="-1" role="dialog" aria-labelledby="newPointModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPointModalLabel">Productivity This Month</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('competition/dataentry'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="id_sae" id="id_sae" value="<?= $sm['id_sae']; ?>">
                    <input type="hidden" name="bulan" id="bulan" value="<?= $bln['bulan']; ?>">
                    <input type="hidden" name="tahun" id="tahun" value="<?= $thn['tahun']; ?>">

                    <div class="form-group">
                        <input type="text" class="form-control onlyNumber" id="point" name="point" placeholder="Productivity" autocomplete="off" autofocus required>

                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>