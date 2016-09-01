<?php

namespace App\Console\Commands;

use App\Entities\Invitation;
use App\Entities\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvitationChecker extends Command
{
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
        $invitations = Invitation::where('status', 0)->get();

        if (!$invitations) {
            throw new EntityNotFoundException('No existe la alcancía');
        }

        $attends = [];

        foreach ($invitations as $invitation) {
            if (!isset($attends[$invitation->email])) {

                $attends[$invitation->email] = $invitation->id;
                $data = [
                    'invitation' => $invitation,
                    'moneybox' => $invitation->moneybox
                ];

                $invitation->count = $invitation->count + 1;
                $invitation->save();

                Mail::send('emails.pendinginvitation', $data, function ($message) use ($invitation) {
                    $message->from('contacto@coperacha.com.mx', 'Coperacha');
                    $message->to($invitation->email, 'Invitado');
                    $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com']);
                    $message->subject('Recordatorio de Invitación a ' . $invitation->moneybox->name);
                });
            }
        }
        $this->info("Completed");
        // $message = sprintf("Registros actualizados: %s [%s]", ($i + 1), implode(',', $ids));

        // Write info
        //Log::info($message);
    }
}
