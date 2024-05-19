<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <?= form_error('bobot', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('faktor_id', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Bobot</a>
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Kode Faktor</th>
                        <th scope="col">Bobot</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($bobot as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['kode_faktor']; ?></td>
                            <td><?= $m['bobot']; ?></td>
                            <td>
                                <a href="" class="badge badge-success editBobot" data-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#editBobotModal">edit</a>
                                <a href="<?= base_url('mfep/delete_bobot/' . $m['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this item?');">delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            total Bobot <?= $total_bobot ?>
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
                <h5 class="modal-title" id="newMenuModalLabel">Add New Bobot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('mfep/bobot'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="faktor_id">Pilih Faktor</label>
                        <select class="form-control" id="faktor_id" name="faktor_id">
                            <?php foreach ($faktor as $f): ?>
                                <option value="<?= $f['id']; ?>"><?= $f['kode_faktor'] . ' - ' . $f['keterangan_faktor']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="bobot" name="bobot" placeholder="Bobot">
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
<div class="modal fade" id="editBobotModal" tabindex="-1" role="dialog" aria-labelledby="editBobotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBobotModalLabel">Edit Bobot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBobotForm" action="<?= base_url('mfep/update_bobot'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <label for="edit_faktor_id">Faktor ID:</label>
                        <select class="form-control" id="edit_faktor_id" name="faktor_id">
                            <?php foreach ($faktor as $f): ?>
                                <option value="<?= $f['id']; ?>"><?= $f['kode_faktor'] . ' - ' . $f['keterangan_faktor']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_bobot">Bobot:</label>
                        <input type="text" class="form-control" id="edit_bobot" name="bobot" placeholder="Bobot">
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
    $('.editBobot').on('click', function() {
        const id = $(this).data('id');
        // console.log(id)
        $.ajax({
            url: '<?= base_url('mfep/get_bobot_by_id'); ?>',
            data: {id: id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $('#edit_id').val(data.id);
                $('#edit_faktor_id').val(data.faktor_id);
                $('#edit_bobot').val(data.bobot);
            }
        });
    });

    // Menangkap submit form editBobotForm
    $('#editBobotForm').submit(function(e) {
        e.preventDefault(); // Mencegah form melakukan submit secara default

        // Lakukan AJAX untuk mengirim data form ke controller
        $.ajax({
            url: $(this).attr('action'), // Ambil action URL dari form
            method: $(this).attr('method'), // Ambil method dari form
            data: $(this).serialize(), // Ambil data form yang telah di-serialize
            success: function(response) {
                // Jika berhasil, tampilkan pesan sukses dan tutup modal
                alert('Bobot updated successfully');
                $('#editBobotModal').modal('hide');
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

