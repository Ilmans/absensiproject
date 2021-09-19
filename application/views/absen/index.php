<div class="content-body">
    <!-- row -->
    <?php


    ?>
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Absen</a></li>
                <!-- <li class="breadcrumb-item active"><a href="javascript:void(0)">Data User</a></li> -->
            </ol>
        </div>
        <?php if ($this->session->flashdata('flash')) : ?>
            <div class="alert alert-<?= $this->session->flashdata('flash')['alert'] ?> alert-dismissible alert-alt fade show my-4 mx-5">
                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                </button>
                <strong><?= $this->session->flashdata('flash')['alert'] ?>!</strong> <?= $this->session->flashdata('flash')['message']; ?>.
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">
                        <h4>Cari absen</h4>
                    </div>
                    <div class="card-body">


                        <form action="" method="get" class="form-horizontal">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">NIS</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="nis" />
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="control-label">Kelas </label>
                                    <div class="controls">
                                        <select name="kelas" id="kelas" class="form-control" required>
                                            <option value="0" disabled aria-required="">Pilih kelas..</option>
                                            <?php foreach ($kelas as $k) : ?>
                                                <option value="<?= $k['id_kelas']; ?>"><?= $k['kelas']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Bulan</label>
                                    <div class="controls">
                                        <select name="bulan" id="kelas" class="form-control" required>
                                            <option value="0" disabled>Pilih bulan..</option>
                                            <option value="01">Januari</option>
                                            <option value="02">Februari</option>
                                            <option value="03">Maret</option>
                                            <option value="04">April</option>
                                            <option value="05">Mei</option>
                                            <option value="06">Juni</option>
                                            <option value="07">Juli</option>
                                            <option value="08">Agustus</option>
                                            <option value="09">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Tahun</label>
                                    <div class="controls">
                                        <select name="tahun" id="kelas" class="form-control" required>
                                            <option value="0" disabled>Pilih Tahun</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-actions">
                                <button type="submit" name="cariabsen" value="isset" class="btn btn-success">Cari</button>

                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Absen <?= $desc ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <form action="<?= base_url() ?>absen/input" method="POST">
                                <table class="table table-bordered table-striped with-check">

                                    <thead>
                                        <tr>
                                            <th rowspan="2"><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox"></th>
                                            <th rowspan=" 2">Nomor induk siswa</th>
                                            <th rowspan=" 2">Nama</th>
                                            <th rowspan="2">L/P</th>
                                            <?php for ($tanggal_table = 1; $tanggal_table <= 31; $tanggal_table++) {
                                                echo "<th rowspan='2'>$tanggal_table</th>";
                                            } ?>
                                            <th colspan="4">jumlah</th>
                                        </tr>
                                        <tr>
                                            <th>A</th>
                                            <th>I</th>
                                            <th>S</th>
                                            <th>T</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($siswa as $d) :  ?>
                                            <tr>
                                                <td><input type="checkbox" name="nis[]" value="<?PHP echo $d['nis']; ?>" /></td>
                                                <td><?= $d['nis']; ?></td>
                                                <td><?= $d['nama_siswa']; ?></td>
                                                <td><?= $d['jenis_kelamin']; ?></td>
                                                <?php

                                                //mengabil tanggal 
                                                $nomor2 = 1;
                                                $keterangan_alpha = 0;
                                                $keterangan_izin = 0;
                                                $keterangan_sakit = 0;
                                                $keterangan_terlambat = 0;
                                                foreach ($dataabsen as $da) {
                                                    if ($da['nis'] == $d['nis']) {
                                                        $ambil_tanggal = explode("-", $da['tanggal_absen']);

                                                        //merubah menjadi tanggal jadi integer
                                                        $ambil_tanggal[2] = $ambil_tanggal[2];

                                                        //perulangan kehadiran sesuai tanggal
                                                        for ($nomor = $nomor2; $nomor <= $ambil_tanggal[2]; $nomor++) {
                                                            if ($nomor == $ambil_tanggal[2]) {
                                                                if ($da['keterangan'] == 'h') {
                                                                    echo '<td> <i class="fa fa-check"></i></td>';
                                                                } else {
                                                                    echo "<td><b>" . strtoupper($da['keterangan']) . "</b></td>";
                                                                }
                                                            } else {
                                                                echo "<td></td>";
                                                            }
                                                        }
                                                        // rekap bulanan
                                                        if ($da['keterangan'] == 'a') {
                                                            $keterangan_alpha++;
                                                        } else if ($da['keterangan'] == 'i') {
                                                            $keterangan_izin++;
                                                        } else if ($da['keterangan'] == 's') {
                                                            $keterangan_sakit++;
                                                        } else if ($da['keterangan'] == 't') {
                                                            $keterangan_alpha++;
                                                        }
                                                        $nomor2 = $ambil_tanggal[2] + 1;
                                                        $sisa_td = 31 - $nomor2;
                                                    }
                                                }


                                                if (isset($sisa_td) != true) {
                                                    $sisa_td = 30;
                                                }
                                                for ($td = 0; $td <= $sisa_td; $td++) {
                                                    echo "<td></td>";
                                                }
                                                //tampilan rekap absen
                                                echo "<td>$keterangan_alpha</td>
                                            <td>$keterangan_izin</td>
                                            <td>$keterangan_sakit</td>
                                            <td>$keterangan_terlambat</td>";
                                                $keterangan_alpha = 0;
                                                $keterangan_sakit = 0;
                                                $keterangan_izin = 0;
                                                $keterangan_terlambat = 0;
                                                ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pengabsenan</h4>
                    </div>
                    <div class="card-body">


                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash() ?>" />
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <select name="keterangan" id="" class="form-control" required>
                                <option value="h">Hadir</option>
                                <option value="a">Alpha</option>
                                <option value="i">izin</option>
                                <option value="t">Terlambat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="date" name="tgltahun" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Aksi</label>
                            <select name="aksi" class="form-control" id="" required>
                                <option value="baru">Baru</option>
                                <option value="edit">Edit</option>
                                <option value="hapus">Hapus</option>
                            </select>
                        </div>
                        <div class="form-actions">
                            <button type="submit" name="klikabsen" class="btn btn-success">Absen</button>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>