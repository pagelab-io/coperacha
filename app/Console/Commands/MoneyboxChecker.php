<?php

namespace App\Console\Commands;

use App\Entities\User;
use App\Models\Mailer;
use App\Utilities\PLConstants;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
     * @var Mailer
     */
    private $_mailer;

    /**
     * Create a new command instance.
     *
     */
    public function __construct(Mailer $mailer)
    {
        parent::__construct();
        $this->_mailer = $mailer;
    }

    /**
     * Execute the console command.
     * Docs:
     *  - https://www.digitalocean.com/community/tutorials/how-to-use-cron-to-automate-tasks-on-a-vps
     *  - Crontab
     *     1. sudo crontab -e
     *     2. Add line - at 5 minutes of each hour
     *        - 5 * * * * php /var/www/coperacha.pagelab.io/artisan moneybox:checker
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("Start Checking Moneyboxes ...");
        $mb = DB::select("
                SELECT *
                  FROM moneyboxes
                WHERE DATE(DATE_ADD(now(), INTERVAL 3 DAY))=DATE(end_date)");

        \Log::info(count($mb)." moneyboxes ...");
        \Log::info("Sending deadline emails ...");
        foreach ($mb as $i => $m) {
            $user = User::byPerson($m->person_id)->first();
            if ($user instanceof User)
                $this->sendDeadlineEmail($user, $m);
        }
        \Log::info("Completed");
    }

    /**
     * Send the deadline emails
     * @param User $user
     * @param $moneybox
     */
    private function sendDeadlineEmail(User $user, $moneybox)
    {
        $person = $user->person;
        $data = [
            'name' => $person->name,
            'link' => "/moneybox/detail/" . $moneybox->url,
            'moneybox' => $moneybox->name
        ];
        $options = array(
            'to' => [$user->email => $user->username],
            'bcc' => explode(',', PLConstants::EMAIL_BCC),
            'title' => 'Deadline'
        );
        $this->_mailer->send(PLConstants::EMAIL_DEADLINE, $data, $options);
    }
}
