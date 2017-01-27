<?php

namespace App\Console\Commands;

use App\Entities\Invitation;
use App\Models\Mailer;
use App\Utilities\PLConstants;
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
     * @var Mailer
     */
    private $_mailer;

    /**
     * Create a new command instance.
     * @param Mailer $mailer
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
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function handle()
    {
        \Log::info("Start Checking Invitations ...");
        $invitations = Invitation::where(function ($q) {
            $q->where('status', '=', 0);
            $q->where('count', '<=', 3);
        })->get();

        \Log::info(count($invitations).' invitations');
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

                    $options = array(
                        'to' => [$invitation->email => 'Invitado ' . $invitation->email],
                        'bcc' => explode(',', PLConstants::EMAIL_BCC),
                        'title' => 'Recordatorio para participar en ' . $invitation->moneybox->name
                    );

                    $invitation->count = $invitation->count + 1;
                    $invitation->save();

                    if (true == self::PRODUCTION)
                        $this->_mailer->send(PLConstants::EMAIL_PENDING_INVITATION, $data, $options);
                }
            }
        }
        \Log::info("Completed");
    }
}
