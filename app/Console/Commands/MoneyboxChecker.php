<?php

namespace App\Console\Commands;

use App\Entities\User;
use App\Repositories\MoneyboxRepository;
use Faker\Provider\lv_LV\Person;
use Illuminate\Console\Command;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MoneyboxChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moneybox:checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the moneybox deadline';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Docs:
     *  - https://www.digitalocean.com/community/tutorials/how-to-use-cron-to-automate-tasks-on-a-vps
     *
     *  - Crontab
     *     1. sudo crontab -e
     *     2. Add line * * * * * /var/www/coperacha artisan moneybox:checker
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Start Checking...");
        $mb = DB::select("
                SELECT *
                  FROM moneyboxes
                WHERE DATE(DATE_ADD(now(), INTERVAL 3 DAY))=DATE(end_date)");

        $ids = [];
        foreach ($mb as $i => $m) {

            $user = User::byPerson($m->person_id)->first();

            if ($user instanceof User) {
                $person = $user->person;
                $data = ['name' => $person->name];

                Mail::send('emails.deadline', $data, function ($message) use ($user) {
                    $message->from('info@coperacha.com.mx', 'Coperacha');
                    $message->to($user->email, $user->username);
                    $message->bcc('perezatanaciod@gmail.com', 'Daniel');
                    $message->bcc('sanchezz985@gmail.com', 'Emmanuel');
                    $message->subject('Deadline');
                });

                $ids[] = sprintf("(%s:%s)", $user->id, $m->id);
            }
        }

        $this->info("Completed");
        $message = sprintf("Registros actualizados: %s [%s]", ($i + 1), implode(',', $ids));

        // Write info
        Log::info($message);
    }
}
