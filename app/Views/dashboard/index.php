<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div id="input-section" class="section-content p-6">
  <div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Input Data</h2>
    <p class="text-gray-600">Tambah data pengisian BBM atau ganti oli</p>
  </div>
  <div class="mb-6">
    <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-fit">
      <button class="tab-button px-4 py-2 rounded-md text-sm font-medium bg-white text-gray-900 shadow-sm" data-tab="fuel">Input BBM</button>
      <button class="tab-button px-4 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900" data-tab="oil">Ganti Oli</button>
    </div>
  </div>
  <div id="fuel-tab" class="tab-content">
    <div class="bg-white border border-gray-200 rounded-xl p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan Pengisian BBM</h3>
      <form id="fuel-form" class="grid grid-cols-1 md:grid-cols-2 gap-6" action="<?= site_url('dashboard/save') ?>" method="post" autocomplete="off">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
          <input type="date" name="tanggal" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Kilometer</label>
          <input type="number" name="km" placeholder="Odometer saat ini" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah BBM (L)</label>
          <input type="number" name="liter" step="0.01" placeholder="Jumlah liter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Liter</label>
          <input type="number" name="harga" step="0.01" placeholder="Harga per liter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" required />
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">Total Biaya</label>
          <input type="number" name="total" step="0.01" placeholder="Otomatis dihitung" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly />
        </div>
        <div class="md:col-span-2">
          <button type="submit" class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-blue-600 font-medium !rounded-button whitespace-nowrap">
            Simpan Data BBM
          </button>
        </div>
      </form>
    </div>
  </div>
  <div id="oil-tab" class="tab-content hidden">
    <div class="bg-white border border-gray-200 rounded-xl p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan Ganti Oli</h3>
      <form id="oil-form" action="<?= site_url('dashboard/save_oli') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
          <input type="date" name="tanggal" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Kilometer Saat Ini</label>
          <input type="number" name="km" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="KM saat ganti oli" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Oli</label>
          <input type="text" name="jenis_oli" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Contoh: Sintetik" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Harga Oli</label>
          <input type="number" name="harga_oli" step="0.01" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Interval Penggantian (km)</label>
          <input type="number" name="interval_penggantian" value="5000" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Default 5000 km" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Jadwal Ganti Berikutnya (km)</label>
          <input type="number" name="jadwal_berikutnya" required class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly placeholder="Otomatis dihitung" />
        </div>
        <div class="md:col-span-2">
          <button type="submit" class="w-full bg-secondary text-white py-3 px-4 rounded-lg hover:bg-green-600 font-medium !rounded-button whitespace-nowrap">Simpan Data Oli</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script id="tab-switching-script">
  document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-button");
    const tabContents = document.querySelectorAll(".tab-content");
    tabButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const targetTab = this.dataset.tab;
        tabButtons.forEach((btn) => {
          btn.classList.remove("bg-white", "text-gray-900", "shadow-sm");
          btn.classList.add("text-gray-600");
        });
        this.classList.add("bg-white", "text-gray-900", "shadow-sm");
        this.classList.remove("text-gray-600");
        tabContents.forEach((content) => {
          content.classList.add("hidden");
        });
        document.getElementById(targetTab + "-tab").classList.remove("hidden");
      });
    });
  });
</script>
<script id="form-handling-script">
  document.addEventListener("DOMContentLoaded", function () {
    const fuelForm = document.getElementById("fuel-form");
    fuelForm.addEventListener("input", function (e) {
      if (
        e.target.name === "liter" ||
        e.target.name === "harga"
      ) {
        const liters = parseFloat(fuelForm.querySelector('input[name="liter"]').value) || 0;
        const pricePerLiter = parseFloat(fuelForm.querySelector('input[name="harga"]').value) || 0;
        const totalCost = liters * pricePerLiter;
        fuelForm.querySelector('input[name="total"]').value = totalCost.toFixed(2);
      }
    });
    const oilForm = document.getElementById("oil-form");
    oilForm.addEventListener("input", function (e) {
      if (e.target.name === "km" || e.target.name === "interval_penggantian") {
        const currentKm = parseFloat(oilForm.querySelector('input[name="km"]').value) || 0;
        const interval = parseFloat(oilForm.querySelector('input[name="interval_penggantian"]').value) || 5000;
        const nextChange = currentKm + interval;
        oilForm.querySelector('input[name="jadwal_berikutnya"]').value = nextChange;
      }
    });
  });
</script>
<?= $this->endSection() ?>
