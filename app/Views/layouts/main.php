<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Monitor BBM & Oli</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { primary: "#3B82F6", secondary: "#10B981" },
            borderRadius: {
              none: "0px",
              sm: "4px",
              DEFAULT: "8px",
              md: "12px",
              lg: "16px",
              xl: "20px",
              "2xl": "24px",
              "3xl": "32px",
              full: "9999px",
              button: "8px",
            },
          },
        },
      };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <style>
      :where([class^="ri-"])::before {
          content: "\f3c2";
      }
    </style>
  </head>
  <body class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto bg-white min-h-screen shadow-lg">
      <header class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
              <i class="ri-car-line text-white text-xl"></i>
            </div>
            <div>
              <h1 class="text-xl font-bold text-gray-900">Monitor BBM & Oli</h1>
              <p class="text-sm text-gray-500">Manajemen BBM & Oli</p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="bg-yellow-100 px-3 py-1 rounded-full">
              <span class="text-sm font-medium text-yellow-800"><?= $headerOliStatus ?></span>
            </div>
            <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100">
              <i class="ri-notification-line text-gray-600"></i>
            </button>
          </div>
        </div>
      </header>
      <main class="flex-1">
        <div class="flex h-full">
          <aside class="w-64 bg-gray-50 border-r border-gray-200">
            <nav class="p-4">
              <ul class="space-y-2">
                <li>
                  <a href="<?= site_url('dashboard') ?>" class="nav-item w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-left hover:bg-gray-100 <?= ($active_nav == 'dashboard') ? 'bg-primary text-white' : 'text-gray-700' ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                      <i class="ri-add-line"></i>
                    </div>
                    <span>Input Data</span>
                  </a>
                </li>
                <li>
                  <a href="<?= site_url('dashboard/history') ?>" class="nav-item w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-left hover:bg-gray-100 <?= ($active_nav == 'history') ? 'bg-primary text-white' : 'text-gray-700' ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                      <i class="ri-history-line"></i>
                    </div>
                    <span>Riwayat</span>
                  </a>
                </li>
                <li>
                  <a href="<?= site_url('dashboard/statistics') ?>" class="nav-item w-full flex items-center space-x-3 px-3 py-2 rounded-lg text-left hover:bg-gray-100 <?= ($active_nav == 'statistics') ? 'bg-primary text-white' : 'text-gray-700' ?>">
                    <div class="w-5 h-5 flex items-center justify-center">
                      <i class="ri-bar-chart-line"></i>
                    </div>
                    <span>Statistik</span>
                  </a>
                </li>
              </ul>
            </nav>
          </aside>
          <div class="flex-1">
            <?= $this->renderSection('content') ?>
          </div>
        </div>
      </main>
    </div>
    <?= $this->renderSection('scripts') ?>
  </body>
</html>
