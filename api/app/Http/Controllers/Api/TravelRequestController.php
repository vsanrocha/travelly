<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TravelRequestStatusChanged;

class TravelRequestController extends Controller
{
	public function index(Request $request)
	{
		$query = TravelRequest::where('user_id', Auth::id());

		if ($request->has('status')) {
			$query->where('status', $request->status);
		}

		if ($request->has(['start_date', 'end_date'])) {
			$query->whereBetween('departure_date', [$request->start_date, $request->end_date]);
		}

		if ($request->has('destination')) {
			$query->where('destination', 'like', "%{$request->destination}%");
		}

		return $query->orderBy('created_at', 'desc')->get();
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'destination' => 'required|string',
			'departure_date' => 'required|date|after_or_equal:today',
			'return_date' => 'required|date|after_or_equal:departure_date',
		]);

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

	public function updateStatus(Request $request, TravelRequest $travelRequest)
	{
		$this->authorize('update', $travelRequest);

		$request->validate(['status' => 'required|in:approved,cancelled']);

		if ($travelRequest->status === 'cancelled') {
			return response()->json(['error' => 'Pedido já cancelado'], 400);
		}

		if (
			$travelRequest->status === 'approved' &&
			$request->status === 'cancelled' &&
			now()->greaterThan($travelRequest->departure_date)
		) {
			return response()->json(['error' => 'Não é possível cancelar após a data de ida'], 400);
		}

		$travelRequest->status = $request->status;
		$travelRequest->save();

		return $travelRequest;
	}
}
