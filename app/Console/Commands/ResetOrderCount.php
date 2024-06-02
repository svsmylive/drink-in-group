<?php

namespace App\Console\Commands;

use App\Models\OrderCount;
use Illuminate\Console\Command;

class ResetOrderCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order-count:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @return void
     */
    public function handle(): void
    {
        OrderCount::query()->update(['count' => 1]);
    }
}
