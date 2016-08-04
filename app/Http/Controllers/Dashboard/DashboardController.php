<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        return view('dashboard.index', ['users' => $this->getUsersByGender()]);
    }

    /**
     * @return mixed
     */
    public function getUsersByGender()
    {
        $data = DB::table('users')
            ->join('persons', 'persons.id','=','users.person_id')
            ->groupBy('persons.gender')
            ->select('persons.gender', DB::raw('count(*) as total'))
            ->get();

        return $data;
    }
}
