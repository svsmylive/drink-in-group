<?php

namespace App\Console\Commands;

use App\Models\Institution;
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
        $institutions = [
            Institution::query()->where('type', '=', 'Кулинария')->first(),
            Institution::query()->where('name', '=', 'КАМЕЛОТ')->first()
        ];

        foreach ($institutions as $institution) {
            $menuCollection = $this->tillypadService->getMenu($institution);

            if ($menuCollection) {
                $this->menuService->updateOrCreateFromApi($menuCollection, $institution);
            }
        }
    }
}
