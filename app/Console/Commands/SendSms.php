<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AfricasTalkingGateway;
use App\domain\PaymentSchedule;
use Carbon\Carbon;

class SendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks due date and send sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $gateway;
    public function __construct(AfricasTalkingGateway $gateway)
    {
        parent::__construct();
        $this->gateway=$gateway;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $paymentSchedules=PaymentSchedule::where('due_date',$tomorrow)
        ->where('lifeline_status','active')
        ->where('status','open')
        ->get();
        //dd($paymentSchedules);
        foreach($paymentSchedules as $paymentSchedule){
            $message="Your insurance payment is due tommorror";
            $this->gateway->sendMessage($paymentSchedule->policy->vehicle->customer->contact, $message);
        }
    }
}
