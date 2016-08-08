<?php

use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $persons = \App\Entities\Person::all();
        $moneyboxes = \App\Entities\Moneybox::all();


        foreach ($moneyboxes as $moneybox) {

            foreach ($persons as $person) {
                $payment = new \App\Entities\Payment();
                $payment->person_id = $person->id;
                $payment->moneybox_id = $moneybox->id;
                $payment->amount = random_int(500, 1000);
                $payment->uid = uniqid('Payment-');
                $payment->created_at = \Carbon\Carbon::tomorrow();
                $payment->save();
            }
        }
    }
}
