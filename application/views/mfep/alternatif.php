<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg">
            <?= form_error('alternatif', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Alternatif</a>
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Alternatif</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($alternatif as $m) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $m['alternatif']; ?></td>
                            <td>
                                <a href="" class="badge badge-success editAlternatif" data-id="<?= $m['id']; ?>" data-toggle="modal" data-target="#editAlternatifModal">edit</a>
                                <a href="<?= base_url('mfep/delete_alternatif/' . $m['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this item?');">delete</a>
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
                <h5 class="modal-title" id="newMenuModalLabel">Add New Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('mfep/alternatif'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="alternatif" name="alternatif" placeholder="Alternatif">
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

<!-- Edit Alternatif Modal -->
<div class="modal fade" id="editAlternatifModal" tabindex="-1" role="dialog" aria-labelledby="editAlternatifModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlternatifModalLabel">Edit Alternatif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('mfep/update_alternatif'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="edit_alternatif" name="alternatif" placeholder="Alternatif">
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
    $('.editAlternatif').on('click', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: '<?= base_url('mfep/get_alternatif_by_id'); ?>',
            data: {id: id},
            method: 'post',
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $('#edit_id').val(data.id);
                $('#edit_alternatif').val(data.alternatif);
            }
        });
    });
});
</script>
