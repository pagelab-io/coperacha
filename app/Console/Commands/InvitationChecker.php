<?php

namespace App\Console\Commands;

use App\Entities\Invitation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class InvitationChecker extends Command
{
    const PRODUCTION = true;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitation:checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the invitation deadline';

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
     *  - Crontab
     *     1. sudo crontab -e
     *     2. Add line - at 5 minutes of each hour
     *        - 5 * * * * php /var/www/coperacha.pagelab.io/artisan moneybox:checker
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function handle()
    {
        $this->info("Start Checking...");
        \Log::info("Start Checking...");
        $invitations = Invitation::where(function ($q) {
            $q->where('status', '=', 0);
            $q->where('count', '<=', 3);
        })->get();

        \Log::info('invitaciones');
        \Log::info(count($invitations));
        $attends = [];

        foreach ($invitations as $invitation) {

            $validator = Validator::make(['mail' => $invitation->email], [
                'mail' => 'required|email'
            ]);

            if ($validator->passes()) {

                if (!isset($attends[$invitation->email])) {

                    $attends[$invitation->email] = $invitation->id;
                    $data = [
                        'invitation' => $invitation,
                        'moneybox' => $invitation->moneybox
                    ];

                    $invitation->count = $invitation->count + 1;
                    $invitation->save();

                    if (true == self::PRODUCTION) {
                        Mail::send('emails.pendinginvitation', $data, function ($message) use ($invitation) {
                            $message->from('info@coperacha.com.mx', 'Coperacha');
                            $message->to($invitation->email, 'Invitado ' . $invitation->email);
                            $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com', 'coperachamexico@gmail.com']);
                            $message->subject('Recordatorio para participar en ' . $invitation->moneybox->name);
                        });
                    }
                }
            }
        }
        $this->info("Completed");
        \Log::info("Completed");
        // $message = sprintf("Registros actualizados: %s [%s]", ($i + 1), implode(',', $ids));

        // Write info
        //Log::info($message);
    }
}
