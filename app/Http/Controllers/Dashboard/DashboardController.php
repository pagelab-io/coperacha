<?php

namespace App\Http\Controllers\Dashboard;

use App\Entities\Category;
use App\Entities\Moneybox;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\MoneyboxRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    //region Fields

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    //endregion


    public function __construct(UserRepository $userRepository, MoneyboxRepository $moneyboxRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.index', [
            'users' => $this->getUsersByGender(),
            'moneyboxes' => $this->getMoneyboxesByCreationDate(),
            'durability' => $this->getAverageDurabilityOfMoneybox(),
            'payments' => $this->getPaymentsMethodsStats()
        ]);
    }

    public function getUsers()
    {
        $users = User::where('tracking', '!=', '-1')->get();
        return view('dashboard.user.index', [
            'users' => $users
        ]);
    }

    public function getUserByUsername($email){
        $user = $this->_userRepository->byEmail($email);
        $request = new Requests\PLRequest();
        $request->merge(array('person_id' => $user->person->id));
        $moneyboxes = $this->_moneyboxRepository->getAll($request);
        return view('dashboard.user.detail',[
            'user' => $user,
            'my_moneyboxes' => $moneyboxes->data['my_moneyboxes'],
            'moneyboxes_participation' => $moneyboxes->data['moneyboxes_participation']
        ]);
    }

    public function getMoneyboxes()
    {
        $moneyboxes = Moneybox::all();

        return view('dashboard.moneybox.index', [
            'moneyboxes' => $moneyboxes
        ]);
    }


    public function getMoneyboxesByUrl($url) {
        $categories = Category::all();
        $moneybox = Moneybox::byUrl($url)->first();

        return view('dashboard.moneybox.detail', [
            'moneybox' => $moneybox,
            'categories' => $categories
        ]);
    }

    /**
     * Gets statistics of creation of users
     *
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
     * Gets statistics of creation of moneybox
     *
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

        return [
            'Diario' => $daily,
            'Por Semana' => $weekly,
            'Por año' => $qty
        ];
    }

    /**
     * Gets the average durability of moneybox
     *
     */
    public function getAverageDurabilityOfMoneybox(){
        //region durability
        $sql = "SELECT id
                  , DATE(created_at)
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

        $collectedAvg = 0;
        $collected = 0;

        foreach ($collectedRaw as $row) {
            $collected += (int)$row->avg;
        }

        if (count($collectedRaw) > 0) {
             $collectedAvg = $collected / count($collectedRaw);
        }
        //endregion

        //region Coperacha Promedio
        $amountRaw = DB::select("SELECT AVG(collected_amount) AS amount FROM moneyboxes");
        $amountAvg = $amountRaw[0]->amount;
        //endregion

        return [
            'Duración promedio (días)' => floor($durabilityAvg),
            'Monto promedio diario' => number_format($collectedAvg, 2),
            'Coperacha promedio' =>  number_format($amountAvg, 2)
        ];
    }


    /**
     * Gets the statistics of payment for method
     *
     * http://lists.mysql.com/mysql-es/82
     */
    public function getPaymentsMethodsStats() {

        // Calc total rows
        DB::select("SELECT SQL_CALC_FOUND_ROWS * FROM payments LIMIT 0,1;");

        // Execute the query for retrieve the pivotal data
        $resultRaw = DB::select("
                    SELECT
                      CASE method
                        WHEN 'P' THEN 'P'
                        WHEN 'O' THEN 'O'
                        ELSE 'S' END AS method,
                    
                      COUNT(method) AS qty,
                      COUNT(method) / FOUND_ROWS() * 100 AS percent
                    
                    FROM payments
                    GROUP BY payments.method");


        return $resultRaw;
    }
}
