<!-- Begin Page Content ( isi halaman) -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <form action="<?= base_url('competition/bukarankingcode'); ?>" method="post">
                <div class="form-group">

                    <select name="competition" id="competition" class="form-control" required>
                        <option value="">Select Competition</option>
                        <?php foreach ($competition as $a) : ?>
                            <option value="<?= $a['id']; ?>"><?= $a['code_competition']; ?></option>
                        <?php endforeach; ?>

                    </select>
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