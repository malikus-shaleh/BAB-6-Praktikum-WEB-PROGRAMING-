<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-8">
  <h2 class="text-2xl font-bold text-gray-900 mb-2">History</h2>
  <div class="mb-6 flex items-center justify-between">
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
      <button id="tabFuel" class="px-4 py-2 rounded-md text-sm font-medium bg-white text-gray-900 shadow-sm">Fuel History</button>
      <button id="tabOil" class="px-4 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900">Oil History</button>
    </div>
    <button id="exportBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium flex items-center"><i class="ri-download-2-line mr-2"></i>Export Data</button>
  </div>
  <div class="mb-4 flex items-center space-x-2">
    <input id="searchInput" type="text" placeholder="Search..." class="border rounded-lg px-3 py-2 text-sm w-64" />
    <button class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium">Filter</button>
  </div>
  <div id="fuelHistorySection">
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Odometer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Liters</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if ($bbmData): ?>
              <?php foreach ($bbmData as $row): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($row['tanggal']) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= number_format($row['km'], 0, ',', '.') ?> km</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($row['liter']) ?> L</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                    <a href="<?= site_url('dashboard/edit/' . $row['id']) ?>" class="edit-btn px-2 py-1 bg-yellow-400 text-white rounded">Edit</a>
                    <a href="<?= site_url('dashboard/delete/' . $row['id']) ?>" class="delete-btn px-2 py-1 bg-red-500 text-white rounded">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" class="text-center py-6 text-gray-400">No data found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div id="oilHistorySection" style="display:none;">
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow mt-8">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Odometer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oil Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Change</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if ($oliData): ?>
              <?php foreach ($oliData as $row): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($row['tanggal']) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= number_format($row['km'], 0, ',', '.') ?> km</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= esc($row['jenis_oli']) ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp<?= number_format($row['harga_oli'], 0, ',', '.') ?></td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= number_format($row['jadwal_berikutnya'], 0, ',', '.') ?> km</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm flex gap-2">
                    <a href="<?= site_url('dashboard/edit_oli/' . $row['id']) ?>" class="edit-btn px-2 py-1 bg-yellow-400 text-white rounded">Edit</a>
                    <a href="<?= site_url('dashboard/delete_oli/' . $row['id']) ?>" class="delete-btn px-2 py-1 bg-red-500 text-white rounded">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center py-6 text-gray-400">No data found</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Tab switching
  const tabFuel = document.getElementById('tabFuel');
  const tabOil = document.getElementById('tabOil');
  const fuelSection = document.getElementById('fuelHistorySection');
  const oilSection = document.getElementById('oilHistorySection');
  tabFuel.onclick = function() {
    tabFuel.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
    tabOil.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
    tabOil.classList.add('text-gray-600');
    fuelSection.style.display = '';
    oilSection.style.display = 'none';
  };
  tabOil.onclick = function() {
    tabOil.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
    tabFuel.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
    tabFuel.classList.add('text-gray-600');
    oilSection.style.display = '';
    fuelSection.style.display = 'none';
  };
  // Filter/search
  document.getElementById('searchInput').addEventListener('input', function(e) {
    const val = e.target.value.toLowerCase();
    [fuelSection, oilSection].forEach(section => {
      section.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
      });
    });
  });
  // Export CSV
  document.getElementById('exportBtn').onclick = function() {
    let activeSection = fuelSection.style.display !== 'none' ? fuelSection : oilSection;
    let rows = Array.from(activeSection.querySelectorAll('table tr'));
    let csv = rows.map(row => Array.from(row.children).map(cell => '"'+cell.innerText.replace(/"/g, '""')+'"').join(',')).join('\n');
    let blob = new Blob([csv], {type: 'text/csv'});
    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = activeSection === fuelSection ? 'fuel_history.csv' : 'oil_history.csv';
    link.click();
  };
</script>
<?= $this->endSection() ?>