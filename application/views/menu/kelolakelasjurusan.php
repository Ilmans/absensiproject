<div class="content-body">
    <!-- row -->



    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Vertical Nav Pill</h4>
            </div>


            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="alert alert-success alert-dismissible alert-alt fade show">
                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                    </button>
                    <strong>Success!</strong> <?= $this->session->flashdata('success'); ?>.
                </div>
            <?php endif; ?>

            <div class="card-body">
                <div class="row">
                    <div class="col-xl-2">
                        <div class="nav flex-column nav-pills mb-3">
                            <a href="#v-pills-kelas" data-toggle="pill" class="nav-link active show">Kelas</a>
                            <a href="#v-pills-profile" data-toggle="pill" class="nav-link">Jurusan</a>

                        </div>
                    </div>
                    <div class="col-xl-10">
                        <div class="tab-content">
                            <div id="v-pills-kelas" class="tab-pane fade active show">
                                <div class="col-12">
                                    <div class="card">
                                        <a class="btn btn-success col-2 offset-8 tambahkelas">tambah</a>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="example3" class="display min-w750">
                                                    <thead>
                                                        <tr>

                                                            <th>Nama Kelas</th>
                                                            <th>Kelas</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($kelas as $k) :
                                                        ?>
                                                            <tr>

                                                                <td><?= $k['nama_kelas'] ?></td>
                                                                <td><?= $k['kelas'] ?></td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a class="editkelas btn btn-primary shadow btn-xs sharp mr-1" idkelas="<?= $k['id_kelas']; ?>"><i class="fa fa-pencil"></i></a>
                                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="v-pills-profile" class="tab-pane fade">
                                <p>Culpa dolor voluptate do laboris laboris irure reprehenderit id incididunt duis pariatur mollit aute magna pariatur consectetur. Eu veniam duis non ut dolor deserunt commodo et minim in quis laboris ipsum
                                    velit id veniam. Quis ut consectetur adipisicing officia excepteur non sit. Ut et elit aliquip labore Lorem enim eu. Ullamco mollit occaecat dolore ipsum id officia mollit qui esse anim eiusmod do sint
                                    minim consectetur qui.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal edit & tambah kelas -->
<?php
$csrf = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
);
?>
<div class="modal fade" id="modalkelas">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="formkelas" method="POST">
                    <div class="form-row">
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <input type="hidden" name="idkelas" class="id_kelas" id="">
                        <div class="form-group col-md-12">
                            <label>Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="namakelas" placeholder="nama kelas" class="form-control" autofocus required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control kelas" placeholder="kelas">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary buttonsubmit"></button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    //tambah kelas
    $('.tambahkelas').click(function() {
        $('.modal-title').html('Tambah Kelas')
        $('.buttonsubmit').html('Tambah')
        $('.formkelas').attr('action', '<?= base_url(); ?>menu/tambahkelas')
        $('#modalkelas').modal();
    })
    // edit kelas
    $('.editkelas').click(function() {
        const idkelas = $(this).attr("idkelas");
        $('.modal-title').html('Edit Kelas')
        $('.buttonsubmit').html('Perbarui')
        $('.formkelas').attr('action', '<?= base_url(); ?>menu/perbaruikelas')

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url(); ?>/menu/ambilkelas",
            data: {
                <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>',
                idkelas: idkelas,
            },
            dataType: 'json',
            success: function(data) {
                $('.id_kelas').val(data[0].id_kelas);
                $('#namakelas').val(data[0].nama_kelas);
                $('.kelas').val(data[0].kelas);
                $('#modalkelas').modal();
            },
            error: function() {
                $('.modal-body').html('Kesalahan system')
            }
        });
    })
</script>