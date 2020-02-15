<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading
          <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->


    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <!-- Menampilkan pesan alert jika SN EDC sudah ada di database mencegah dobel -->
    <?= form_error(
        'sndevice',
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
            <a href="" class="btn btn-primary mb-1 tampilDSNTambah" data-toggle="modal" data-target="#newDSNModal"><i class="fas fa-fw fa-plus"></i>Entry</a> |
            <a href="<?= base_url(''); ?>logistic/exportdsn_excel" class="btn btn-primary mb-1 "><i class="fas fa-fw fa-download"></i>Export</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN Device</th>
                            <th>Device Name</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Service Point</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($device as $sm) : ?>
                            <tr>
                                <td><?= $sm['sndevice']; ?></td>
                                <td><?= $sm['nama_device']; ?></td>
                                <td><?= $sm['product']; ?></td>
                                <td><?= $sm['customer']; ?></td>
                                <td><?= $sm['servicepoint']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>logistic/dsnubah/<?= $sm['id_device']; ?>" class="badge badge-success tampilDSNUbah" data-popup="tooltip" title="Edit Device" data-toggle="modal" data-target="#newDSNModal" data-id="<?= $sm['id_device']; ?>"><i class="fa fa-edit"></i></a> |
                                    <a href="<?= base_url(''); ?>logistic/dsnubah/<?= $sm['id_device']; ?>" class="badge badge-danger tampilDSNKeluar" data-popup="tooltip" title="Takeout Device" data-toggle="modal" data-target="#newDSNModalKeluar" data-id="<?= $sm['id_device']; ?>"><i class="fas fa-share"></i></a>

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
<div class="modal fade" id="newDSNModal" tabindex="-1" role="dialog" aria-labelledby="newDSNModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDSNModalLabel">Add New Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('logistic/dsn'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="id_device" id="id_device" value="<?= $sm['id_device']; ?>">
                    <input type="hidden" name="sndevice1" id="sndevice1" value="<?= $sm['sndevice']; ?>">
                    <input type="hidden" name="action" id="action" value="Masuk">

                    <div class="form-group">
                        <input type="text" class="form-control" id="sndevice" name="sndevice" placeholder="SN Device" autocomplete="off" autofocus required>

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nama_device" name="nama_device" placeholder="Device Name" autocomplete="off" required>
                    </div>

                    <!-- list tabel product -->
                    <div class="form-group">
                        <select name="product" id="product" class="form-control" required>
                            <option value="">Select Product</option>
                            <?php foreach ($product as $a) : ?>
                                <option value="<?= $a['product']; ?>"><?= $a['product']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- list tabel customer / setting for -->
                    <div class="form-group">
                        <select name="customer" id="customer" class="form-control" required>
                            <option value="">Select Setting For</option>
                            <?php foreach ($customer as $a) : ?>
                                <option value="<?= $a['customer']; ?>"><?= $a['customer']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- tangkap service point -->
                    <input type="hidden" name="sp" id="sp" value="<?= $user['servicepoint']; ?>">

                    <!-- list tabel kondisi  -->
                    <div class="form-group">
                        <select name="kondisi" id="kondisi" class="form-control" required>
                            <option value="">Select Condition</option>
                            <option value="Good">Good</option>
                            <option value="Bad">Bad</option>
                        </select>
                    </div>

                    <!-- list tabel status -->
                    <div class="form-group">
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Asset">Asset</option>
                            <option value="Project">Project</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Remark" autocomplete="off" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success tampilSNDummy">SN Dummy</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk keluar device-->
<div class="modal fade" id="newDSNModalKeluar" tabindex="-1" role="dialog" aria-labelledby="newDSNModalKeluar" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDSNModalLabel1"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php ?>
            <div class="modal-body">
                <form action="<?= base_url('logistic/dsnhapus'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="id_device1" id="id_device1">

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Remark Takeout Device</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3"></textarea>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Takeout</button>
            </div>
            </form>
        </div>
    </div>
</div>