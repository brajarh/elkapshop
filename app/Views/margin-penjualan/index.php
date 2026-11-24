<section class="panel">

    <div class="toolbar">
        <h2>Daftar Margin Penjualan<?= $aktif ? ' Aktif' : '' ?></h2>

        <a class="btn"
           href="<?= e(url('margin-penjualan', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="filters">

        <a class="btn <?= $aktif ? 'secondary' : '' ?>"
           href="<?= e(url('margin-penjualan')) ?>">
            Semua Data
        </a>

        <a class="btn <?= $aktif ? '' : 'secondary' ?>"
           href="<?= e(url('margin-penjualan', 'aktif')) ?>">
            Data Aktif
        </a>

    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Persen</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php $no = 1; ?>

                <?php foreach ($rows as $row): ?>

                    <?php
                    $id = (int) $row['idmargin_penjualan'];
                    $status = (int) $row['status'];
                    ?>

                    <tr>

                        <td><?= $no++ ?></td>

                        <td><?= e($row['persen']) ?>%</td>

                        <td>
                            <?= $status === 1
                                ? 'Aktif'
                                : 'Tidak Aktif' ?>
                        </td>

                        <td>

                            <?php if ($status === 0): ?>

                                <form method="post"
                                      action="<?= e(url(
                                          'margin-penjualan',
                                          'aktifkan',
                                          ['id' => $id]
                                      )) ?>"
                                      style="display:inline"
                                      onsubmit="return confirm('Aktifkan margin ini?')">

                                    <input type="hidden"
                                           name="csrf"
                                           value="<?= e($_SESSION['csrf']) ?>">

                                    <button type="submit">
                                        Aktifkan
                                    </button>

                                </form>

                            <?php endif; ?>

                            <a class="btn secondary"
                               href="<?= e(url(
                                   'margin-penjualan',
                                   'edit',
                                   ['id' => $id]
                               )) ?>">
                                Edit
                            </a>

                            <?php if ($status === 0): ?>

                                <form method="post"
                                      action="<?= e(url(
                                          'margin-penjualan',
                                          'delete',
                                          ['id' => $id]
                                      )) ?>"
                                      style="display:inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">

                                    <input type="hidden"
                                           name="csrf"
                                           value="<?= e($_SESSION['csrf']) ?>">

                                    

                                </form>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if (!$rows): ?>

                    <tr>
                        <td colspan="4">
                            Belum ada data.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>

</section>