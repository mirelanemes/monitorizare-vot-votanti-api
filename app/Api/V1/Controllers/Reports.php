<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;

use App\Api\V1\Transformers\CountiesWithIncidentsTransformer;

use App\County;
use App\Incident;

class Reports extends Controller
{

    use Helpers;

    public static function totalIncidents()
    {
        return Incident::count();
    }

    public static function countiesWithIncidents()
    {
        $counties = County::orderBy('name')->get();
        $countyTransformer = new CountiesWithIncidentsTransformer();
        return $countyTransformer->transformCollection($counties->all());
    }

    public static function totalIncidentsByType()
    {
        $groupedIncidents = Incident::select(DB::raw('count(*) as count, incident_type_id'))
            ->groupBy('incident_type_id')
            ->with('type')
            ->get();
        return $groupedIncidents;
    }
}
