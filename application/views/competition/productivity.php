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
                            <th>MIP</th>
                            <th>Name</th>
                            <th>Productivity</th>
                            <th>Bobot</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($participant as $sm) : ?>
                            <tr>
                                <td><?= $sm['code_competition']; ?></td>
                                <td><?= $sm['mip']; ?></td>
                                <td><?= $sm['nama']; ?></td>
                                <td><?= $sm['productivity']; ?></td>
                                <td><?= $sm['bobot_productivity']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/productivityubah/<?= $sm['mip']; ?>" class="badge badge-success tampilProductivityUbah" data-popup="tooltip" title="Add Productivity" data-id="<?= $sm['mip']; ?>" data-toggle="modal" data-target="#newProductivityModal">Add</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="<?= base_url(''); ?>competition/tutupproductivitycode" class="badge badge-primary" data-popup="tooltip" title="Back to scheduled"><i class="fas fa-fw fa-share"></i>Back to scheduled</a>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Modal untuk tombol add participant-->

<div class="modal fade" id="newProductivityModal" tabindex="-1" role="dialog" aria-labelledby="newProductivityModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newProductivityModalLabel1">Add Productivity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php ?>
            <div class="modal-body">
                <form action="<?= base_url('competition/productivity'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="mip" id="mip">

                    <!-- list tabel sae -->
                    <div class="form-group">
                        <input type="text" class="form-control onlyNumber" id="productivity" name="productivity" placeholder="Productivity" autocomplete="off" required>
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