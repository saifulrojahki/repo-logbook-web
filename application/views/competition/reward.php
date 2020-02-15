<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $title; ?></h1>
    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
            <a href="" class="btn btn-primary mb-1 tampilRewardTambah" data-toggle="modal" data-target="#newRewardModal"><i class="fas fa-fw fa-plus"></i>Entry</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Competition</th>
                            <th>MIP</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($participant as $sm) : ?>

                            <tr>
                                <td><?= $sm['code_competition']; ?></td>
                                <td><?= $sm['mip']; ?></td>
                                <td><?= $sm['nama']; ?></td>
                                <td><?= $sm['kategori']; ?></td>
                                <td><?= $sm['keterangan']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>competition/rewardhapus/<?= $sm['id_reward']; ?>" class="badge badge-danger tombol-takeout" data-popup="tooltip" title="Delete Reward or pinalty">Delete</a>

                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="<?= base_url(''); ?>competition/tutuprewardcode" class="badge badge-primary" data-popup="tooltip" title="Back to scheduled"><i class="fas fa-fw fa-share"></i>Back to scheduled</a>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Modal untuk tombol add absen-->

<div class="modal fade" id="newRewardModal" tabindex="-1" role="dialog" aria-labelledby="newRewardModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSLARewardLabel1">Add Reward or Pinalty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php ?>
            <div class="modal-body">
                <form action="<?= base_url('competition/reward'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="id_reward" id="id_reward">

                    <!-- list tabel sae -->
                    <div class="form-group">
                        <select name="nama" id="nama" class="form-control" required>
                            <option value="">Select SAE</option>
                            <?php foreach ($sae as $a) : ?>
                                <option value="<?= $a['mip']; ?>"><?= $a['nama']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- list kategori-->
                    <div class="form-group">
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="REWARD">Reward</option>
                            <option value="PINALTY">Pinalty</option>
                        </select>
                    </div>

                    <!-- list tabel sae -->
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Remark Reward or Pinalty</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
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