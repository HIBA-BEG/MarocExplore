<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    public function indexAll()
    {
        $itineraries = Itinerary::with('destinations')->get();

        return response()->json([
            'status' => 'success',
            'itineraries' => $itineraries,
        ]);
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'image' => 'required|string',
                'departure' => 'required',
                'arrival' => 'required',
                'duration' => 'required|string',
                'destinations' => 'required|array|min:2',
                'destinations.*.name' => 'required|string|max:255',
                'destinations.*.housing' => 'required|string|max:255',
                'destinations.*.list' => 'required|string|max:255',
            ]);

            
            $itinerary = Itinerary::create([
                'title' => $request->title,
                'category' => $request->category,
                'image' => $request->image,
                'departure' => $request->departure,
                'arrival' => $request->arrival,
                'duration' => $request->duration,
                'user_id' => auth()->id(),
            ]);

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                $destination = Destination::create([
                    'name' => $destinationData['name'],
                    'housing' => $destinationData['housing'],
                    'list' => $destinationData['list'],
                    'itinerary_id' => $itinerary->id,
                ]);
                $destinations[] = $destination;
            }

            $itinerary['destinations'] = $destinations;

            return response()->json([
                'status' => 'success',
                'message' => 'Route with its destinations successfully created',
                'itinerary' => $itinerary,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $title = $request->input('title');

        $itineraries = Itinerary::where('title', 'like', "%$title%")->get();

        return response()->json([
            'status' => 'success',
            'itineraries' => $itineraries,
        ]);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'category' => 'sometimes|string|max:255',
            'duration' => 'sometimes|string|max:255',
        ]);

        $category = $request->input('category');
        $duration = $request->input('duration');

        $query = Itinerary::query();

        if ($category) {
            $query->where('category', $category);
        }

        if ($duration) {
            $query->where('duration', $duration);
        }

        $itineraries = $query->get();

        return response()->json([
            'status' => 'success',
            'itineraries' => $itineraries,
        ]);
    }

    
    public function destroy($id)
    {
        $itinerary = Itinerary::find($id);

        if (!$itinerary) {
            return response()->json([
                'status' => 'error',
                'message' => 'Itinerary not found.',
            ], 404);
        }

        // dd(auth()->id());
        if ($itinerary->user_id !== auth()->id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to delete this itinerary.',
            ], 403);
        }

        $itinerary->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Itinerary deleted successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'image' => 'required|string',
                'departure' => 'required',
                'arrival' => 'required',
                'duration' => 'required|string',
                'destinations' => 'required|array|min:2',
                'destinations.*.name' => 'required|string|max:255',
                'destinations.*.housing' => 'required|string|max:255',
                'destinations.*.list' => 'required|string|max:255',
            ]);

            $itinerary = Itinerary::find($id);

            if (!$itinerary) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Itinerary not found.',
                ], 404);
            }

            if ($itinerary->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to modify this itinerary.',
                ], 403);
            }

            $itinerary->update([
                'title' => $request->title,
                'category' => $request->category,
                'image' => $request->image,
                'departure' => $request->departure,
                'arrival' => $request->arrival,
                'duration' => $request->duration,
            ]);

            $destinations = [];
            foreach ($request->destinations as $destinationData) {
                if (isset($destinationData['id'])) {

                    $destination = Destination::where('itinerary_id', $itinerary->id)
                        ->where('id', $destinationData['id'])
                        ->first();

                    if ($destination) {
                        $destination->update([
                            'name' => $destinationData['name'],
                            'housing' => $destinationData['housing'],
                            'list' => $destinationData['list'],
                        ]);
                        $destinations[] = $destination;
                    }

                } else {
                    $destination = Destination::create([
                        'name' => $destinationData['name'],
                        'housing' => $destinationData['housing'],
                        'list' => $destinationData['list'],
                        'itinerary_id' => $itinerary->id,
                    ]);
                }
                $destinations[] = $destination;
            }

            $itinerary['destinations'] = $destinations;

            return response()->json([
                'status' => 'success',
                'message' => 'Itinerary with its destinations created successfully.',
                'itinerary' => $itinerary,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
