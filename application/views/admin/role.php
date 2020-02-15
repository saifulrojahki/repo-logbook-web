<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Table untuk mengelola menu -->
    <div class="row">
        <div class="col-lg-6">


            <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>


            <a href="" class="btn btn-primary mb-3 tampilRoleTambah" data-toggle="modal" data-target="#newRoleModal">Add Role Menu</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($role as $r) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $r['role']; ?></td>
                            <td>
                                <a href="<?= base_url('admin/roleAccess/') . $r['id']; ?>" class="badge badge-warning">Acces</a> |
                                <a href="<?= base_url('admin/roleubah/') . $r['id']; ?>" class="badge badge-success tampilRolelUbah" data-toggle="modal" data-target="#newRoleModal" data-id="<?= $r['id']; ?>">Edit</a> |
                                <a href="<?= base_url('admin/rolehapus/') . $r['id']; ?>" class="badge badge-danger tombol-hapus">Delete</a>
                            </td>

                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<!-- Modal untuk tombol add menu-->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/role'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role Name" required>
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