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
            'users' => $this->getUsersByGender(),
            'moneyboxes' => $this->getMoneyboxesByCreationDate(),
            'averages' => $this->getAverageDurabilityOfMoneybox()
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
            ->select('persons.gender', DB::raw('count(*) AS qty'))
            ->get();

        $total = 0;
        foreach ($data as $row) {
            $total += $row->qty;
        }
        
        return [
            'data' => $data,
            'total' => $total
        ];
    }

    /**
     * @return mixed
     */
    public function getMoneyboxesByCreationDate()
    {
        $sql = 'SELECT DATE(created_at) day, count(*) as qty
                    FROM moneyboxes
                  GROUP BY DATE(created_at)
                  ORDER BY created_at';

        $resultRaw = DB::select($sql);

        $qty = 0;
        foreach ($resultRaw as $row) {
            $qty += $row->qty;
        }

        $daily = ceil($qty / count($resultRaw));
        $weekly = ceil($qty / 52);
        $response = [
            'Diario' => $daily,
            'Por Semana' => $weekly,
            'Por año' => $qty
        ];

        return $response;
    }

    /**
     *
     */
    public function getAverageDurabilityOfMoneybox(){
        //region durability
        $sql = "SELECT id, 
                  DATE(created_at)
                  , end_date
                  , datediff(end_Date, created_at) AS days 
                  FROM moneyboxes 
                ORDER BY created_at";

        $resultRaw = DB::select($sql);
        $durability = 0;

        foreach ($resultRaw as $row) {
            $durability += (int)$row->days;
        }

        $durabilityAvg = $durability / count($resultRaw);
        //endregion

        //region Amount collected
        $sql = "SELECT DATE(created_at) date, AVG(amount) avg
                  FROM payments
                GROUP BY (DATE(created_at))";
        $collectedRaw = DB::select($sql);

        $collected = 0;

        foreach ($collectedRaw as $row) {
            $collected += (int)$row->avg;
        }

        $collectedAvg = $collected / count($collectedRaw);
        //endregion

        //region Coperacha Promedio
        $amountRaw = DB::select("SELECT AVG(collected_amount) AS amount FROM moneyboxes");
        $amount = $amountRaw[0]->amount;
        //endregion


        return [
            'Duración promedio (días)' => floor($durabilityAvg),
            'Monto promedio diario' => '$ ' . floor($collectedAvg),
            'Coperacha promedio' => '$ ' . floor($amount)
        ];
    }
}
