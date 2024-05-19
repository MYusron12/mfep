<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <?= form_error('alternatif_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Evaluasi</a>
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Alternatif</th>
                        <th scope="col">C1</th>
                        <th scope="col">C2</th>
                        <th scope="col">C3</th>
                        <th scope="col">C4</th>
                        <th scope="col">C5</th>
                        <th scope="col">Action</th>
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
                            <td>
                                <a href="" class="badge badge-success editEvaluasi" data-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#editEvaluasiModal">edit</a>
                                <a href="<?= base_url('mfep/delete_evaluasi/' . $m['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this item?');">delete</a>
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

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Evaluasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('mfep/evaluasi'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alternatif_id">Pilih Alternatif</label>
                        <select class="form-control" id="alternatif_id" name="alternatif_id">
                            <?php foreach ($alternatif as $f): ?>
                                <option value="<?= $f['id']; ?>"><?= $f['alternatif']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="c1" name="c1">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="c2" name="c2">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="c3" name="c3">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="c4" name="c4">
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" id="c5" name="c5">
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

<!-- Edit Bobot Modal -->
<div class="modal fade" id="editEvaluasiModal" tabindex="-1" role="dialog" aria-labelledby="editEvaluasiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEvaluasiModalLabel">Edit Evaluasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editEvaluasiForm" action="<?= base_url('mfep/update_evaluasi'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="alternatif_id">Pilih Alternatif</label>
                        <select class="form-control" id="edit_alternatif_id" name="alternatif_id">
                            <?php foreach ($alternatif as $f): ?>
                                <option value="<?= $f['id']; ?>"><?= $f['alternatif']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_c1">C1:</label>
                        <input type="text" class="form-control" id="edit_c1" name="c1" placeholder="c1">
                    </div>
                    <div class="form-group">
                        <label for="edit_c2">C2:</label>
                        <input type="text" class="form-control" id="edit_c2" name="c2" placeholder="c2">
                    </div>
                    <div class="form-group">
                        <label for="edit_c3">C3:</label>
                        <input type="text" class="form-control" id="edit_c3" name="c3" placeholder="c3">
                    </div>
                    <div class="form-group">
                        <label for="edit_c4">C4:</label>
                        <input type="text" class="form-control" id="edit_c4" name="c4" placeholder="c4">
                    </div>
                    <div class="form-group">
                        <label for="edit_c5">C5:</label>
                        <input type="text" class="form-control" id="edit_c5" name="c5" placeholder="c5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.editEvaluasi').on('click', function() {
        const id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: '<?= base_url('mfep/get_evaluasi_by_id'); ?>',
            data: {id: id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $('#edit_id').val(data.id);
                $('#edit_alternatif_id').val(data.alternatif_id);
                $('#edit_c1').val(data.c1);
                $('#edit_c2').val(data.c2);
                $('#edit_c3').val(data.c3);
                $('#edit_c4').val(data.c4);
                $('#edit_c5').val(data.c5);
            }
        });
    });

    // Menangkap submit form editEvaluasiForm
    $('#editEvaluasiForm').submit(function(e) {
        e.preventDefault(); // Mencegah form melakukan submit secara default

        // Lakukan AJAX untuk mengirim data form ke controller
        $.ajax({
            url: $(this).attr('action'), // Ambil action URL dari form
            method: $(this).attr('method'), // Ambil method dari form
            data: $(this).serialize(), // Ambil data form yang telah di-serialize
            success: function(response) {
                // Jika berhasil, tampilkan pesan sukses dan tutup modal
                alert('Evaluasi updated successfully');
                $('#editEvaluasiModal').modal('hide');
                // Refresh halaman untuk melihat perubahan
                location.reload();
            },
            error: function(xhr, status, error) {
                // Jika terjadi error, tampilkan pesan error
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>
