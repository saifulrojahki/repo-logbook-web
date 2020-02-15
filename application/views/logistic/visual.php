<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="container">

        <table border="1" cellpadding="10" cellspacing="0" class="ml-0">
            <!-- set pengulangan baris tabel-->
            <?php for ($i = 1; $i <= 8; $i++) : ?>
                <!-- if untuk genap warna abu dan sebalik nya -->
                <tr>
                    <!-- set pengulangan kolom tabel-->
                    <?php for ($j = 1; $j <= 4; $j++) : ?>

                        <td><?= "$i, $j"; ?></td>

                    <?php endfor; ?>

                </tr>
            <?php endfor; ?>

        </table>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->