<?php

namespace App\Console\Commands;

use App\Models\Institution;
use App\Services\MenuService;
use App\Services\TillypadService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
     */
    public function handle(): void
    {
        $institutions = [
            Institution::query()->where('type', '=', 'Кулинария')->first(),
            Institution::query()->where('name', '=', 'КАМЕЛОТ')->first()
        ];

        try {
            foreach ($institutions as $institution) {
                $menuCollection = $this->tillypadService->getMenu($institution);

                if ($menuCollection) {
                    $this->menuService->updateOrCreateFromApi($menuCollection, $institution);
                }
            }
        } catch (\Throwable $e) {
            $apiKey = config('telegram.api_key');

            Http::post("https://api.telegram.org/bot{$apiKey}/sendMessage", [
                'chat_id' => '-4281880650',
                'text' => 'Ошибка при интеграции меню из tillypad: ' . Str::limit($e->getMessage(), 30),
            ]);
        }
    }
}
