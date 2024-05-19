<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
          <table class="table table-bordered" id="dataTable">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Alternatif</th>
                      <th scope="col">Bobot Evaluasi C1</th>
                      <th scope="col">Bobot Evaluasi C2</th>
                      <th scope="col">Bobot Evaluasi C3</th>
                      <th scope="col">Bobot Evaluasi C4</th>
                      <th scope="col">Bobot Evaluasi C5</th>
                      <th scope="col">Total</th>
                  </tr>
              </thead>
              <?php
                // Step 1: Calculate total scores and store them along with the original data
                $alternatifWithScores = [];
                foreach ($alternatif as $m) {
                    $total = ($m['c1'] * $c1['bobot_c1']) + ($m['c2'] * $c2['bobot_c2']) + ($m['c3'] * $c3['bobot_c3']) + ($m['c4'] * $c4['bobot_c4']) + ($m['c5'] * $c5['bobot_c5']);
                    $alternatifWithScores[] = array_merge($m, ['total' => $total]);
                }

                // Step 2: Sort the array based on total scores
                usort($alternatifWithScores, function($a, $b) {
                    return $b['total'] <=> $a['total'];
                });
              ?>
              <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($alternatifWithScores as $m) : ?>
                      <tr>
                          <th scope="row"><?= $i; ?></th>
                          <td><?= $m['alternatif']; ?></td>
                          <td><?= $m['c1'] * $c1['bobot_c1']; ?></td>
                          <td><?= $m['c2'] * $c2['bobot_c2']; ?></td>
                          <td><?= $m['c3'] * $c3['bobot_c3']; ?></td>
                          <td><?= $m['c4'] * $c4['bobot_c4']; ?></td>
                          <td><?= $m['c5'] * $c5['bobot_c5']; ?></td>
                          <td><?= $m['total']; ?></td>
                      </tr>
                      <?php $i++; ?>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>
    </div>
    <hr>
    <div class="row">
    <div class="col-lg-4">
        <h5>Penilaian</h5>
        <table class="table table-bordered" id="dataTable3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($penilaian as $m) : ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $m['nilai']; ?></td>
                        <td><?= $m['keterangan']; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
      </div>
      <div class="col-lg-4">
          <h5>Faktor</h5>
          <table class="table table-bordered" id="dataTable1">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Kode Faktor</th>
                      <th scope="col">Deskripsi</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($faktor as $m) : ?>
                      <tr>
                          <th scope="row"><?= $i; ?></th>
                          <td><?= $m['kode_faktor']; ?></td>
                          <td><?= $m['keterangan_faktor']; ?></td>
                      </tr>
                      <?php $i++; ?>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>
      <div class="col-lg-4">
        <h5>Bobot Faktor</h5>
        <table class="table table-bordered" id="dataTable2">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Kode Faktor</th>
                      <th scope="col">Bobot</th>
                  </tr>
              </thead>
              <tbody>
                  <?php $i = 1; ?>
                  <?php foreach ($bobot as $m) : ?>
                      <tr>
                          <th scope="row"><?= $i; ?></th>
                          <td><?= $m['kode_faktor']; ?></td>
                          <td><?= $m['bobot']; ?></td>
                      </tr>
                      <?php $i++; ?>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-3">
            <h5>Alternatif</h5>
            <table class="table table-bordered" id="dataTable4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Alternatif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($alternatif_original as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['alternatif']; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-9">
            <h5>Evaluasi</h5>
            <table class="table table-bordered" id="dataTable5">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Alternatif</th>
                        <th scope="col">C1</th>
                        <th scope="col">C2</th>
                        <th scope="col">C3</th>
                        <th scope="col">C4</th>
                        <th scope="col">C5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($evaluasi as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['alternatif']; ?></td>
                            <td><?= $m['c1']; ?></td>
                            <td><?= $m['c2']; ?></td>
                            <td><?= $m['c3']; ?></td>
                            <td><?= $m['c4']; ?></td>
                            <td><?= $m['c5']; ?></td>
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