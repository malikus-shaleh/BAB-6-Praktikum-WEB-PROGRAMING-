<?php

namespace App\Controllers;

use App\Models\KonsumsiBbmModel;
use App\Models\KonsumsiOliModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $konsumsiOliModel = new KonsumsiOliModel();
        $konsumsiBbmModel = new KonsumsiBbmModel();

        $nextOli = $konsumsiOliModel->select('jadwal_berikutnya as next_oli')->where('jadwal_berikutnya >', 0)->orderBy('jadwal_berikutnya', 'DESC')->first();
        $lastKm = $konsumsiBbmModel->selectMax('km')->first();

        $headerOliStatus = "Belum ada data ganti oli";
        if ($nextOli && $lastKm) {
            if ($nextOli['next_oli'] > $lastKm['km']) {
                $kmToNext = $nextOli['next_oli'] - $lastKm['km'];
                $headerOliStatus = "Masih " . $kmToNext . " km lagi";
            } else {
                $kmOver = $lastKm['km'] - $nextOli['next_oli'];
                $headerOliStatus = "Terlambat " . $kmOver . " km";
            }
        }

        return view('dashboard/index', [
            'headerOliStatus' => $headerOliStatus,
            'active_nav' => 'dashboard'
        ]);
    }

    public function history()
    {
        $konsumsiBbmModel = new KonsumsiBbmModel();
        $konsumsiOliModel = new KonsumsiOliModel();

        $data['bbmData'] = $konsumsiBbmModel->orderBy('tanggal', 'DESC')->findAll();
        $data['oliData'] = $konsumsiOliModel->orderBy('tanggal', 'DESC')->findAll();
        $data['active_nav'] = 'history';

        $konsumsiOliModel = new KonsumsiOliModel();
        $konsumsiBbmModel = new KonsumsiBbmModel();

        $nextOli = $konsumsiOliModel->select('jadwal_berikutnya as next_oli')->where('jadwal_berikutnya >', 0)->orderBy('jadwal_berikutnya', 'DESC')->first();
        $lastKm = $konsumsiBbmModel->selectMax('km')->first();

        $headerOliStatus = "Belum ada data ganti oli";
        if ($nextOli && $lastKm) {
            if ($nextOli['next_oli'] > $lastKm['km']) {
                $kmToNext = $nextOli['next_oli'] - $lastKm['km'];
                $headerOliStatus = "Masih " . $kmToNext . " km lagi";
            } else {
                $kmOver = $lastKm['km'] - $nextOli['next_oli'];
                $headerOliStatus = "Terlambat " . $kmOver . " km";
            }
        }
        $data['headerOliStatus'] = $headerOliStatus;

        return view('dashboard/history', $data);
    }

    public function save()
    {
        $konsumsiBbmModel = new KonsumsiBbmModel();

        $liter = $this->request->getPost('liter');
        $harga = $this->request->getPost('harga');
        $total = $liter * $harga;

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'liter' => $liter,
            'km' => $this->request->getPost('km'),
            'harga' => $harga,
            'total' => $total,
        ];

        $konsumsiBbmModel->save($data);

        return redirect()->to('/dashboard');
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit
    }

    public function update($id)
    {
        // Logika untuk memperbarui data
    }

    public function delete($id)
    {
        $konsumsiBbmModel = new KonsumsiBbmModel();
        $konsumsiBbmModel->delete($id);
        return redirect()->to('/dashboard/history');
    }

    public function delete_oli($id)
    {
        $konsumsiOliModel = new KonsumsiOliModel();
        $konsumsiOliModel->delete($id);
        return redirect()->to('/dashboard/history');
    }

    public function statistics()
    {
        $konsumsiBbmModel = new KonsumsiBbmModel();
        $konsumsiOliModel = new KonsumsiOliModel();

        // Rata-rata efisiensi BBM
        $avgEff = $konsumsiBbmModel->select('AVG(km / liter) as avg_eff')->where('liter >', 0)->first()['avg_eff'];

        // Biaya BBM bulanan
        $month = date('Y-m');
        $monthCost = $konsumsiBbmModel->selectSum('total', 'month_cost')->where('tanggal LIKE', $month . '%')->first()['month_cost'];

        // Status ganti oli
        $nextOli = $konsumsiOliModel->select('jadwal_berikutnya as next_oli')->where('jadwal_berikutnya >', 0)->orderBy('jadwal_berikutnya', 'DESC')->first();
        $lastKm = $konsumsiBbmModel->selectMax('km')->first();
        $kmToNextOli = 0;
        if ($nextOli && $lastKm) {
            if ($nextOli['next_oli'] > $lastKm['km']) {
                $kmToNextOli = $nextOli['next_oli'] - $lastKm['km'];
            } else {
                $kmToNextOli = $lastKm['km'] - $nextOli['next_oli'];
            }
        }

        // Data tren efisiensi BBM
        $trendData = $konsumsiBbmModel->select('tanggal, (km/liter) as eff')->where('liter >', 0)->orderBy('tanggal', 'DESC')->limit(7)->get()->getResultArray();
        $trendData = array_reverse($trendData);

        // Data pengeluaran bulanan
        $expData = $konsumsiBbmModel->select("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(total) as total")->where('total >', 0)->groupBy("DATE_FORMAT(tanggal, '%Y-%m')")->orderBy('bulan', 'DESC')->limit(6)->get()->getResultArray();
        $expData = array_reverse($expData);

        $data = [
            'avgEff' => round($avgEff, 1),
            'monthCost' => $monthCost,
            'nextOli' => $nextOli ? $nextOli['next_oli'] : 0,
            'lastKm' => $lastKm ? $lastKm['km'] : 0,
            'kmToNextOli' => $kmToNextOli,
            'trendData' => $trendData,
            'expData' => $expData,
            'active_nav' => 'statistics'
        ];

        $konsumsiOliModel = new KonsumsiOliModel();
        $konsumsiBbmModel = new KonsumsiBbmModel();

        $nextOli = $konsumsiOliModel->select('jadwal_berikutnya as next_oli')->where('jadwal_berikutnya >', 0)->orderBy('jadwal_berikutnya', 'DESC')->first();
        $lastKm = $konsumsiBbmModel->selectMax('km')->first();

        $headerOliStatus = "Belum ada data ganti oli";
        if ($nextOli && $lastKm) {
            if ($nextOli['next_oli'] > $lastKm['km']) {
                $kmToNext = $nextOli['next_oli'] - $lastKm['km'];
                $headerOliStatus = "Masih " . $kmToNext . " km lagi";
            } else {
                $kmOver = $lastKm['km'] - $nextOli['next_oli'];
                $headerOliStatus = "Terlambat " . $kmOver . " km";
            }
        }
        $data['headerOliStatus'] = $headerOliStatus;

        return view('dashboard/statistics', $data);
    }

    public function input_oli()
    {
        // Logika untuk menampilkan form input oli
    }

    public function save_oli()
    {
        $konsumsiOliModel = new KonsumsiOliModel();

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'km' => $this->request->getPost('km'),
            'jenis_oli' => $this->request->getPost('jenis_oli'),
            'harga_oli' => $this->request->getPost('harga_oli'),
            'jadwal_berikutnya' => $this->request->getPost('jadwal_berikutnya'),
        ];

        $konsumsiOliModel->save($data);

        return redirect()->to('/dashboard');
    }
}
