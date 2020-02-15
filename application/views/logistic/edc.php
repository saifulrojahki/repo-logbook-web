<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading
          <h1 class="h3 mb-2 text-gray-800">Tables</h1> -->

    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('message1'); ?>"></div>
    <!-- Menampilkan pesan alert jika SN EDC sudah ada di database mencegah dobel -->
    <?= form_error(
        'snedc',
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
            <a href="" class="btn btn-primary mb-1 tampilEDCTambah" data-toggle="modal" data-target="#newEdcModal"><i class="fas fa-fw fa-plus"></i>Entry</a> |
            <a href="<?= base_url(''); ?>logistic/export_excel" class="btn btn-primary mb-1 "><i class="fas fa-fw fa-download"></i>Export</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-data" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SN EDC</th>
                            <th>Product</th>
                            <th>Setting For</th>
                            <th>Owner</th>
                            <th>Merchant</th>
                            <th>Service Point</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($edc as $sm) : ?>
                            <tr>
                                <td><?= $sm['snedc']; ?></td>
                                <td><?= $sm['product']; ?></td>
                                <td><?= $sm['customer']; ?></td>
                                <td><?= $sm['owner']; ?></td>
                                <td><?= $sm['merchant']; ?></td>
                                <td><?= $sm['servicepoint']; ?></td>
                                <td><?= $sm['pesan']; ?></td>
                                <td>
                                    <a href="<?= base_url(''); ?>logistic/edcubah/<?= $sm['nobox']; ?>/<?= $sm['snedc']; ?>" class="badge badge-success tampilEDCUbah" data-popup="tooltip" title="Edit Device" data-toggle="modal" data-target="#newEdcModal" data-id="<?= $sm['nobox']; ?>"><i class="fa fa-edit"></i></a> |
                                    <a href="<?= base_url(''); ?>logistic/edchapus/<?= $sm['nobox']; ?>" class="badge badge-danger tombol-takeout" data-popup="tooltip" title="Take out EDC"><i class="fas fa-share"></i></a>

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
<div class="modal fade" id="newEdcModal" tabindex="-1" role="dialog" aria-labelledby="newEdcModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEdcModalLabel">Free Location : <?= $box['pesan']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('logistic/edc'); ?>" method="post">
                    <!-- input tipe hidden untuk kirim post data -->
                    <input type="hidden" name="nobox" id="nobox" value="<?= $box['nobox']; ?>">
                    <input type="hidden" name="snedc1" id="snedc1" value="<?= $sm['snedc']; ?>">
                    <input type="hidden" name="action" id="action" value="Masuk">

                    <div class="form-group">
                        <input type="text" class="form-control" id="snedc" name="snedc" placeholder="SN EDC" autocomplete="off" autofocus required>

                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="snsimcard" name="snsimcard" placeholder="SN Simcard" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="snsamcard" name="snsamcard" placeholder="SN Samcard" autocomplete="off" required>
                    </div>
                    <!-- list tabel product -->
                    <div class="form-group">
                        <select name="product" id="product" class="form-control">
                            <option value="">Select Product</option>
                            <?php foreach ($product as $a) : ?>
                                <option value="<?= $a['product']; ?>"><?= $a['product']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="merchant" name="merchant" placeholder="Merchant Name" autocomplete="off" required>
                    </div>
                    <!-- list tabel customer / setting for -->
                    <div class="form-group">
                        <select name="customer" id="customer" class="form-control">
                            <option value="">Select Setting For</option>
                            <?php foreach ($customer as $a) : ?>
                                <option value="<?= $a['customer']; ?>"><?= $a['customer']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <!-- list tabel owner -->
                    <div class="form-group">
                        <select name="owner" id="owner" class="form-control">
                            <option value="">Select Owner</option>
                            <?php foreach ($owner as $a) : ?>
                                <option value="<?= $a['owner']; ?>"><?= $a['owner']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- tangkap service point -->
                    <input type="hidden" name="servicepoint" id="servicepoint" value="<?= $user['servicepoint']; ?>">

                    <!-- list tabel status -->
                    <div class="form-group">
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="Stock">Free SN</option>
                            <option value="Pending">Pending</option>
                            <option value="Withdrawal">Withdrawal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Remark" autocomplete="off" required>
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