<?php

namespace App\Services;

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
     * @return void
     * @throws GuzzleException
     */
    public function updateOrCreateFromApi(Collection $menuCollection): void
    {
        foreach (collect($menuCollection['MenuItems'])->groupBy('mitm_mgrp_ID')->chunk(300) as $menu) {
            foreach ($menu as $categoryGuid => $dishes) {
                $category = $this->tillypadService->getCategory($categoryGuid);

                if (!$category) {
                    continue;
                }

                if (stristr($category['mgrp_Name'], '*')) {
                    $category['mgrp_Name'] = trim(str_replace(['*', 'PV', 'V'], '', $category['mgrp_Name']));
                    $category = $this->categoryRepository->updateOrCreate($categoryGuid, $category);

                    if (isset($category['MenuGroupNotes'])) {
                        foreach ($category['MenuGroupNotes'] as $groupNote) {
                            if ($groupNote['type_ID'] == config('tillypad.notes_id.group_note_id')) {
                                $this->categoryRepository->update($category, $groupNote['value']);
                            }
                        }
                    }
                }

                foreach ($dishes as $dishItem) {
                    if (stristr($dishItem['mitm_Name'], '*')) {
                        $dishItem['mitm_Name'] = trim(str_replace(['*', 'PV', 'V'], '', $dishItem['mitm_Name']));
                        $dish = $this->dishRepository->updateOrCreate($categoryGuid, $dishItem);
                        if (!$dish) {
                            continue;
                        }
                        if (!isset($dishItem['MenuItemNotes'])) {
                            $this->dishRepository->update($dish, false);
                        } else {
                            if (count(
                                    $dishItem['MenuItemNotes']
                                ) < 2 && $dishItem['MenuItemNotes'][0]['type_ID'] != config(
                                    'tillypad.notes_id.menu_note_id'
                                )) {
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
    }

}
