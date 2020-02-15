<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <!-- Menampilkan pesan alert jika SN EDC sudah ada di database mencegah dobel -->
    <?= form_error(
        'nama',
        '<div id="notifikasi" class="alert alert-danger" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>',

        '</div>'
    ); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            <a href="" class="btn btn-primary mb-1" data-toggle="modal" data-target="#newSAEModal"><i class="fas fa-fw fa-plus"></i>Add</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Competition</th>
                            <th>MIP</th>
                            <th>Name</th>
                            <th>Productivity</th>
                            <th>Absent</th>
                            <th>PM</th>
                            <th>SLA</th>
                            <th>Reward</th>
                            <th>Pinalty</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($participant as $sm) : ?>
                            <tr>
                                <td><?= $sm['code_competition']; ?></td>
                                <td><?= $sm['mip']; ?></td>
                                <td><?= $sm['nama']; ?></td>
                                <td><?= $sm['bobot_productivity']; ?></td>
                                <td><?= $sm['bobot_absen']; ?></td>
                                <td><?= $sm['bobot_pm']; ?></td>
                                <td><?= $sm['mis_sla']; ?></td>
                                <td><?= $sm['reward']; ?></td>
                                <td><?= $sm['pinalty']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/pesertahapus/<?= $sm['mip']; ?>" class="badge badge-danger tombol-takeout" data-popup="tooltip" title="Delete Participant" data-id="<?= $sm['mip']; ?>">Delete</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="<?= base_url(''); ?>competition/tutuppersertacode" class="badge badge-primary" data-popup="tooltip" title="Back to scheduled"><i class="fas fa-fw fa-share"></i>Back to scheduled</a>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Modal untuk tombol add participant-->

<div class="modal fade" id="newSAEModal" tabindex="-1" role="dialog" aria-labelledby="newSAEModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSAEModalLabel1">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php ?>
            <div class="modal-body">
                <form action="<?= base_url('competition/peserta'); ?>" method="post">

                    <!-- list tabel sae -->
                    <div class="form-group">
                        <select name="nama" id="nama" class="form-control" required>
                            <option value="">Select SAE</option>
                            <?php foreach ($sae as $a) : ?>
                                <option value="<?= $a['mip']; ?>"><?= $a['nama']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>