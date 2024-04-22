<?php

namespace App\Console\Commands;

use App\Services\MenuService;
use App\Services\TillypadService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class MenuImport extends Command
{
    /**
     * @param TillypadService $tillypadService
     * @param MenuService $menuService
     */
    public function __construct(
        private TillypadService $tillypadService,
        private MenuService $menuService,
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make import menu from tillypad api';

    /**
     * @throws GuzzleException
     */
    public function handle()
    {
        $menuCollection = $this->tillypadService->getMenu();

        if ($menuCollection) {
            $this->menuService->updateOrCreateFromApi($menuCollection);
        }
    }
}
