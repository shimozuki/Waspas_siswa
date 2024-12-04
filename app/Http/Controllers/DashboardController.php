<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataFeed;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\Attribute;
use Carbon\Carbon;

    class DashboardController extends Controller
    {

        /**
         * Displays the dashboard screen
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         */
        public function index()
        {
            $dataFeed = new DataFeed();
            $data['mahasiswa'] = Mahasiswa::count();
            $data['jurusan'] = Jurusan::count();
            $data['kriteria'] = Attribute::count();
            return view('pages/dashboard/dashboard', compact('dataFeed', 'data'));
        }
    }
