<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.index', [
            'moneyboxes' => $this->getMoneyboxesByCreatedDate(),
            'users' => $this->getUsersByGender(),
        ]);
    }

    /**
     * @return mixed
     */
    public function getUsersByGender()
    {
        $data = DB::table('users')
            ->join('persons', 'persons.id','=','users.person_id')
            ->groupBy('persons.gender')
            ->select('persons.gender', DB::raw('count(*) AS total'))
            ->get();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getMoneyboxesByCreatedDate()
    {

        $dateTime = new DateTime();
        $result = DB::select('SELECT DATE(created_at) day, count(*) as qty
                                FROM moneyboxes
                              GROUP BY DATE(created_at)
                              ORDER BY created_at');


        $result = (array)$result;

        $qty = 0;
        foreach ($result as $row) {
            $qty += $row->qty;
        }

        $daily = ceil($qty / count($result));
        $weekly = ceil($qty / 52);
        $response = [
            'Diario' => $daily,
            'Por Semana' => $weekly,
            'Por año' => $qty
        ];

        return $response;
    }
}
