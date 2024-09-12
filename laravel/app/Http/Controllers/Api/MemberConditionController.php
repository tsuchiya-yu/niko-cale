<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberCondition\DeleteRequest;
use App\Http\Requests\MemberCondition\StoreRequest;
use App\Http\Resources\MemberConditionResource;
use App\Models\MemberCondition;
use Illuminate\Support\Facades\Response;

class MemberConditionController extends Controller
{
    public function update(StoreRequest $request): MemberConditionResource
    {
        $this->authorize('create', MemberCondition::class);

        // MemberConditionを作成または更新
        $validated = $request->validated();
        $condition = MemberCondition::updateOrCreate(
            [
                'calendar_member_id' => $validated['calendar_member_id'],
                'date' => $validated['date'],
            ],
            [
                'condition' => $validated['condition'],
            ]
        );

        return new MemberConditionResource($condition);
    }

    public function destroy(DeleteRequest $request)
    {
        $validated = $request->validated();
        $condition = MemberCondition::where('calendar_member_id', $validated['calendar_member_id'])
            ->where('date', $validated['date'])
            ->firstOrFail();

        $this->authorize('delete', $condition);
        $condition->delete();

        return Response::json(['success' => true]);
    }
}
