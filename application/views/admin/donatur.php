<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>

    <input type="text" id="searchDonatur" class="form-control mb-3" placeholder="Cari Donatur..." onkeyup="searchTable()">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Donatur</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center align-middle">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Total Donasi</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donatur) && is_array($donatur)) : ?>
                            <?php $no = 1; foreach ($donatur as $d) : ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($d['name'] ?? 'Tidak ada data', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($d['email'] ?? 'Tidak ada data', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>Rp <?= number_format($d['total_donasi'] ?? 0, 0, ',', '.'); ?></td>
                                
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data donatur</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function searchTable() {
    let input = document.getElementById("searchDonatur").value.toLowerCase();
    let table = document.getElementById("dataTable").getElementsByTagName("tbody")[0];
    let rows = table.getElementsByTagName("tr");

    for (let i = 0; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        let match = false;

        for (let j = 1; j < cells.length - 1; j++) { // Lewati kolom No dan Aksi
            if (cells[j].textContent.toLowerCase().includes(input)) {
                match = true;
                break;
            }
        }

        rows[i].style.display = match ? "" : "none";
    }
}
</script>


