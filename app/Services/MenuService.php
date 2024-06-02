<?php

namespace App\Services;

use App\Models\Institution;
use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;

class MenuService
{
    /**
     * @param DishRepository $dishRepository
     * @param CategoryRepository $categoryRepository
     * @param TillypadService $tillypadService
     */
    public function __construct(
        private readonly DishRepository $dishRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly TillypadService $tillypadService,
    ) {
    }

    /**
     * @param Collection $menuCollection
     * @param Institution $institution
     * @return void
     * @throws GuzzleException
     */
    public function updateOrCreateFromApi(Collection $menuCollection, Institution $institution): void
    {
        foreach (collect($menuCollection['MenuItems'])->groupBy('mitm_mgrp_ID')->chunk(300) as $menu) {
            foreach ($menu as $categoryGuid => $dishes) {
                $category = $this->tillypadService->getCategory($categoryGuid);

                if (!$category) {
                    continue;
                }

                $category['mgrp_Name'] = trim(str_replace(['*', 'PV', 'V'], '', $category['mgrp_Name']));
                $category = $this->categoryRepository->updateOrCreate($categoryGuid, $category);

                if (!$category) {
                    continue;
                }

                if (!isset($category['MenuGroupNotes'])) {
                    $this->categoryRepository->update($category, false);
                } else {
                    foreach ($category['MenuGroupNotes'] as $groupNote) {
                        if ($groupNote['type_ID'] == config('tillypad.notes_id.group_note_id')) {
                            $this->categoryRepository->update($category, $groupNote['value'] == 'true');
                        }
                    }
                }

                foreach ($dishes as $dishItem) {
                    $dishItem['mitm_Name'] = trim(str_replace(['*', 'PV', 'V'], '', $dishItem['mitm_Name']));
                    $dish = $this->dishRepository->updateOrCreate($institution, $categoryGuid, $dishItem);

                    if (!$dish) {
                        continue;
                    }

                    if (!isset($dishItem['MenuItemNotes'])) {
                        $this->dishRepository->update($dish, false);
                    } else {
                        foreach ($dishItem['MenuItemNotes'] as $menuNote) {
                            if ($menuNote['type_ID'] == config('tillypad.notes_id.menu_note_id')) {
                                $this->dishRepository->update($dish, $menuNote['value'] == 'true');
                            }
                        }
                    }
                }
            }
        }
    }
}
