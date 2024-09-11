<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function getViewData($apartmentId)
    {
        $viewsData = [];
        $months = [];

        // Cicla sugli ultimi 12 mesi
        for ($i = 0; $i < 12; $i++) {
            // Ottieni la data del primo giorno del mese
            $date = Carbon::now()->subMonths($i)->startOfMonth();
            $viewCount = View::where('apartment_id', $apartmentId)
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month)
                            ->count();

            // Aggiungi il conteggio delle visualizzazioni e il mese
            $viewsData[] = $viewCount;
            $months[] = $date->format('F Y');
        }

        // Invece di restituire solo JSON, restituiamo una vista con i dati
        return view('admin.visual.view', [
            'apartmentId' => $apartmentId,
            'views' => array_reverse($viewsData),
            'months' => array_reverse($months),
        ]);
    }

}
