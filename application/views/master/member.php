<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading
          <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->

    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('message1'); ?>"></div>

    <!-- Menampilkan pesan alert jika MIP sudah ada di database mencegah dobel -->
    <?= form_error(
        'mip',
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
            <a href="" class="btn btn-primary mb-1 tampilMemberTambah" data-toggle="modal" data-target="#newMemberModal"><i class="fas fa-fw fa-plus"></i>Entry</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>MIP</th>
                            <th>Name</th>
                            <th>Service Point</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($member as $sm) : ?>
                            <tr>
                                <td><?= $sm['mip']; ?></td>
                                <td><?= $sm['nama']; ?></td>
                                <td><?= $sm['servicepoint']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>master/memberUbah/<?= $sm['id_sae']; ?>" class="badge badge-success tampilMemberUbah" data-popup="tooltip" title="Edit Member" data-toggle="modal" data-target="#newMemberModal" data-id="<?= $sm['id_sae']; ?>"><i class="fa fa-edit"></i></a> |
                                    <a href="<?= base_url(''); ?>master/memberhapus/<?= $sm['id_sae']; ?>" class="badge badge-danger tombol-takeout" data-popup="tooltip" title="Delete Member"><i class="fas fa-share"></i></a>

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
<div class="modal fade" id="newMemberModal" tabindex="-1" role="dialog" aria-labelledby="newMemberModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMemberModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('master/member'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="id_sae" id="id_sae" value="<?= $sm['id_sae']; ?>">

                    <div class="form-group">
                        <input type="text" class="form-control onlyNumber" id="mip" name="mip" placeholder="MIP Number" autocomplete="off" autofocus required>

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Name Member" autocomplete="off" required>
                    </div>

                    <!-- list tabel service point -->
                    <div class="form-group">
                        <select name="servicepoint" id="servicepoint" class="form-control">
                            <option value="">Select Service Point</option>
                            <?php foreach ($sp as $a) : ?>
                                <option value="<?= $a['servicepoint']; ?>"><?= $a['servicepoint']; ?></option>
                            <?php endforeach; ?>

                        </select>
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