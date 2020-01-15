<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;

use App\Models\Employees\LeaveAllotment;
use App\Models\Master\LeaveMast;

class UpdateLeaveBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update leave balance of an employee after every month and after taking leave.';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $leaves = LeaveMast::all();

        foreach($leaves as $data){

            LeaveAllotment::where('leave_mast_id', $data->id)
                ->increment('initial_bal', $data->generate_days);
      }


    }
}
