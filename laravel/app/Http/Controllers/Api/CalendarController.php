<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller
{
    public function destroy(string $uuid)
    {
        $calendar = Calendar::where('url', $uuid)->firstOrFail();

        $this->authorize('delete', $calendar);
        $calendar->delete();

        return Response::json(['success' => true]);
    }
}
