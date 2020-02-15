<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Table untuk mengelola menu -->
    <div class="row">
        <div class="col-lg-6">


            <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

            <!-- toggle add data -->
            <a href="" class="btn btn-primary mb-3 tampilCustomerTambah" data-toggle="modal" data-target="#newCustomerModal">Add Customer</a>

            <!-- menu searching -->
            <div class="row">
                <div class="col-md">
                    <form action="<?= base_url('master/customer'); ?>" method="post">

                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search Keyword..." name="keyword" autocomplete="off" autofocus>
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" name="submit" value="Search">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <!-- tampil total data -->
            <h5>Results : <?= $total_rows; ?></h5>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Action</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($customer as $sm) : ?>
                        <tr>
                            <th scope="row"><?= ++$start; ?></th>
                            <td><?= $sm['customer']; ?></td>
                            <td>
                                <a href="<?= base_url(''); ?>master/customerubah/<?= $sm['id']; ?>" class="badge badge-success tampilCustomerUbah" data-toggle="modal" data-target="#newCustomerModal" data-id="<?= $sm['id']; ?>">Edit</a> |
                                <a href="<?= base_url(''); ?>master/customerhapus/<?= $sm['id']; ?>" class="badge badge-danger tombol-hapus">Delete</a>
                            </td>

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


<!-- Modal untuk tombol add menu-->
<div class="modal fade" id="newCustomerModal" tabindex="-1" role="dialog" aria-labelledby="newCustomerModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('master/customer'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="customer" name="customer" placeholder="Customer Name" required>
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