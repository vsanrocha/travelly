<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelRequest;
use Illuminate\Http\Request;
use App\Http\Requests\IndexTravelRequest;
use App\Http\Requests\StoreTravelRequest;
use App\Http\Requests\UpdateTravelRequestStatus;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TravelRequestStatusChanged;

class TravelRequestController extends Controller
{
	public function index(IndexTravelRequest $request)
    {
        $query = TravelRequest::where('user_id', Auth::id());
        $data = $request->validated();

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (isset($data['start_date']) && isset($data['end_date'])) {
            $query->whereBetween('departure_date', [$data['start_date'], $data['end_date']]);
        }

        if (isset($data['destination'])) {
            $query->where('destination', 'like', "%{$data['destination']}%");
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function store(StoreTravelRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['requester_name'] = Auth::user()->name;
        $data['status'] = 'requested';

        return TravelRequest::create($data);
    }

	public function show(TravelRequest $travelRequest)
	{
		$this->authorize('view', $travelRequest);
		return $travelRequest;
	}

    public function updateStatus(UpdateTravelRequestStatus $request, TravelRequest $travelRequest)
    {
        $this->authorize('update', $travelRequest);

        $status = $request->validated()['status'];

        if ($travelRequest->status === 'cancelled') {
            return response()->json(['error' => 'Pedido já cancelado'], 400);
        }

        if (
            $travelRequest->status === 'approved' &&
            $status === 'cancelled' &&
            now()->greaterThan($travelRequest->departure_date)
        ) {
            return response()->json(['error' => 'Não é possível cancelar após a data de ida'], 400);
        }

        $travelRequest->status = $status;
        $travelRequest->save();

        return $travelRequest;
    }
}
