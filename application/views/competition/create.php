<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Menampilkan pesan sweeetalert sesuai tombol aksi-->
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
    <!-- Menampilkan pesan alert jika code competition sudah ada di database mencegah dobel -->
    <?= form_error(
        'code',
        '<div id="notifikasi" class="alert alert-danger" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>',

        '</div>'
    ); ?>

    <div class="row">
        <div class="col-lg-6">

            <form action="<?= base_url('competition/create'); ?>" method="post">
                <div class="form-group">
                    <label>Year</label>
                    <select name="tahun" id="tahun" class="form-control" required>
                        <option value="">Select Year</option>
                        <?php foreach ($tahun as $a) : ?>
                            <option value="<?= $a['tahun']; ?>"><?= $a['tahun']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label>Month</label>
                    <select name="bulan" id="bulan" class="form-control create-code" required>
                        <option value="">Select Month</option>
                        <?php foreach ($bulan as $a) : ?>
                            <option value="<?= $a['bulan']; ?>"><?= $a['bulan']; ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="code">Code Competition</label>
                    <input type="type" class="form-control" id="code" name="code" autocomplete="off">
                </div>

                <div class=" form-grup">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->