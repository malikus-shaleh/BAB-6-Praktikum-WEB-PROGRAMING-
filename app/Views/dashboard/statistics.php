<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-8">
  <h2 class="text-2xl font-bold text-gray-900 mb-2">Statistik Penggunaan</h2>
  <p class="text-gray-600 mb-6">Lihat analisis efisiensi BBM dan pengeluaran Anda.</p>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white border rounded-xl p-6 flex flex-col justify-between">
      <div>
        <div class="text-xs text-gray-500 mb-1">Rata-rata Efisiensi BBM</div>
        <div class="text-3xl font-bold text-primary"><?= $avgEff ?> km/L</div>
      </div>
    </div>
    <div class="bg-white border rounded-xl p-6 flex flex-col justify-between">
      <div class="text-xs text-gray-500 mb-1">Biaya BBM Bulanan</div>
      <div class="text-3xl font-bold text-gray-900">Rp<?= number_format($monthCost, 0, ',', '.') ?></div>
    </div>
    <div class="bg-white border rounded-xl p-6 flex flex-col justify-between">
      <div class="text-xs text-gray-500 mb-1">Status Ganti Oli</div>
      <div class="text-3xl font-bold <?= ($nextOli > $lastKm) ? 'text-yellow-600' : 'text-red-600' ?>">
        <?= ($nextOli > $lastKm) ? $kmToNextOli . ' km' : 'Terlambat!' ?>
      </div>
      <div class="text-xs text-gray-500 mt-1">
        <?php 
        if ($nextOli > 0) {
            if ($nextOli > $lastKm) {
                echo "Sampai ganti oli berikutnya";
            } else {
                echo "Sudah melewati jadwal " . $kmToNextOli . " km";
            }
        } else {
            echo "Belum ada data ganti oli";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white border rounded-xl p-6">
      <div class="flex items-center justify-between mb-2">
        <div class="text-lg font-semibold">Tren Efisiensi BBM</div>
        <div class="text-xs text-gray-500">Grafik garis mingguan/bulanan</div>
      </div>
      <div id="effChart" style="height:260px;"></div>
    </div>
    <div class="bg-white border rounded-xl p-6">
      <div class="flex items-center justify-between mb-2">
        <div class="text-lg font-semibold">Pengeluaran Bulanan</div>
        <div class="text-xs text-gray-500">Grafik batang Januari - bulan sekarang</div>
      </div>
      <div id="expChart" style="height:260px;"></div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Fuel Efficiency Trend Chart
    var effChart = echarts.init(document.getElementById('effChart'));
    var effOption = {
      tooltip: { trigger: 'axis' },
      xAxis: {
        type: 'category',
        data: <?= json_encode(array_column($trendData, 'tanggal')); ?>,
        axisLabel: { color: '#888', rotate: 30 }
      },
      yAxis: {
        type: 'value',
        name: 'Km/L',
        axisLabel: { color: '#888' }
      },
      series: [{
        data: <?= json_encode(array_map('floatval', array_column($trendData, 'eff'))); ?>,
        type: 'line',
        smooth: true,
        lineStyle: { color: '#3B82F6', width: 3 },
        areaStyle: { color: 'rgba(59,130,246,0.12)' },
        symbol: 'circle',
        symbolSize: 8
      }],
      grid: { left: 40, right: 20, top: 30, bottom: 40 }
    };
    effChart.setOption(effOption);

    // Monthly Expenses Chart
    var expChart = echarts.init(document.getElementById('expChart'));
    var expOption = {
      tooltip: { 
        trigger: 'axis',
        formatter: function(params) {
          var value = params[0].value;
          return params[0].name + '<br/>Rp' + value.toLocaleString('id-ID');
        }
      },
      xAxis: {
        type: 'category',
        data: <?= json_encode(array_column($expData, 'bulan')); ?>,
        axisLabel: { color: '#888', rotate: 30 }
      },
      yAxis: {
        type: 'value',
        name: 'Rupiah',
        axisLabel: { 
          color: '#888',
          formatter: function(value) {
            return 'Rp' + (value/1000) + 'K';
          }
        }
      },
      series: [{
        data: <?= json_encode(array_map('floatval', array_column($expData, 'total'))); ?>,
        type: 'bar',
        itemStyle: { color: '#10B981', borderRadius: [8,8,0,0] },
        barWidth: 32
      }],
      grid: { left: 60, right: 20, top: 30, bottom: 40 }
    };
    expChart.setOption(expOption);

    window.addEventListener('resize', function () { 
      effChart.resize(); 
      expChart.resize();
    });
  });
</script>
<?= $this->endSection() ?>
