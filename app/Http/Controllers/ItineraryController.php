<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Itinerary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();
    //     $itineraries = $user->itineraries()->with('destinations')->get();
    //     return response()->json([
    //         'status' => 'success',
    //         'itineraries' => $itineraries,
    //     ]);
    // }
    public function index()
    {
        $user = auth()->user(); // Get the authenticated user
        $itineraries = $user->itineraries()->with('destinations')->get();
        return response()->json([
            'status' => 'success',
            'itineraries' => $itineraries,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/indexAll",
     *     summary="Retrieve all itineraries with destinations",
     *     tags={"Itineraries"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved itineraries with destinations",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="itineraries",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Itinerary ID"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Itinerary title"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         description="Itinerary category"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Itinerary image URL"
     *                     ),
     *                     @OA\Property(
     *                         property="departure",
     *                         type="string",
     *                         format="date",
     *                         description="Itinerary departure date"
     *                     ),
     *                     @OA\Property(
     *                         property="arrival",
     *                         type="string",
     *                         format="date",
     *                         description="Itinerary arrival date"
     *                     ),
     *                     @OA\Property(
     *                         property="duration",
     *                         type="string",
     *                         description="Itinerary duration"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         format="int64",
     *                         description="User ID associated with the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="destinations",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(
     *                                 property="id",
     *                                 type="integer",
     *                                 format="int64",
     *                                 description="Destination ID"
     *                             ),
     *                             @OA\Property(
     *                                 property="name",
     *                                 type="string",
     *                                 description="Destination name"
     *                             ),
     *                             @OA\Property(
     *                                 property="housing",
     *                                 type="string",
     *                                 description="Destination housing"
     *                             ),
     *                             @OA\Property(
     *                                 property="list",
     *                                 type="string",
     *                                 description="Destination list"
     *                             ),
     *                             @OA\Property(
     *                                 property="itinerary_id",
     *                                 type="integer",
     *                                 format="int64",
     *                                 description="Itinerary ID associated with the destination"
     *                             )
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function indexAll()
    {
        $itineraries = Itinerary::with('destinations')->get();

        return response()->json([
            'status' => 'success',
            'itineraries' => $itineraries,
        ]);
    }


    /**
     * @OA\Post(
     *     path="/api/itineraries",
     *     summary="Create a new itinerary with destinations",
     *     tags={"Itineraries"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Itinerary details",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"title", "category", "image", "departure", "arrival", "duration", "destinations"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Category of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="Image URL of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     type="string",
     *                     format="date",
     *                     description="Departure date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     type="string",
     *                     format="date",
     *                     description="Arrival date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="string",
     *                     description="Duration of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="destinations",
     *                     type="array",
     *                     description="List of destinations",
     *                     @OA\Items(
     *                         required={"name", "housing", "list"},
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Name of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="housing",
     *                             type="string",
     *                             description="Housing details of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="list",
     *                             type="string",
     *                             description="List details of the destination"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itinerary created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Route with its destinations successfully created",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="itinerary",
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Category of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="Image URL of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     type="string",
     *                     format="date",
     *                     description="Departure date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     type="string",
     *                     format="date",
     *                     description="Arrival date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="string",
     *                     description="Duration of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="destinations",
     *                     type="array",
     *                     description="List of destinations",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Name of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="housing",
     *                             type="string",
     *                             description="Housing details of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="list",
     *                             type="string",
     *                             description="List details of the destination"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="An error occurred",
     *                 description="Error message"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Error details",
     *                 description="Error details"
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/itineraries/search",
     *     summary="Search itineraries by title",
     *     tags={"Itineraries"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Search parameters",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"title"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title to search for"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itineraries found successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="itineraries",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Itinerary ID"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Title of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         description="Category of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Image URL of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="departure",
     *                         type="string",
     *                         format="date",
     *                         description="Departure date of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="arrival",
     *                         type="string",
     *                         format="date",
     *                         description="Arrival date of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="duration",
     *                         type="string",
     *                         description="Duration of the itinerary"
     *                     )
     *                 ),
     *                 description="List of itineraries matching the search criteria"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 example={
     *                     "title": {"The title field is required."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/itineraries/filter",
     *     summary="Filter itineraries by category and/or duration",
     *     tags={"Itineraries"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Filter parameters",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Category to filter by"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="string",
     *                     description="Duration to filter by"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itineraries filtered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="itineraries",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Itinerary ID"
     *                     ),
     *                     @OA\Property(
     *                         property="title",
     *                         type="string",
     *                         description="Title of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="category",
     *                         type="string",
     *                         description="Category of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="image",
     *                         type="string",
     *                         description="Image URL of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="departure",
     *                         type="string",
     *                         format="date",
     *                         description="Departure date of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="arrival",
     *                         type="string",
     *                         format="date",
     *                         description="Arrival date of the itinerary"
     *                     ),
     *                     @OA\Property(
     *                         property="duration",
     *                         type="string",
     *                         description="Duration of the itinerary"
     *                     )
     *                 ),
     *                 description="List of filtered itineraries"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 example={
     *                     "category": {"The category must be a string."},
     *                     "duration": {"The duration must be a string."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/itineraries/{id}",
     *     summary="Delete an itinerary",
     *     tags={"Itineraries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the itinerary to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itinerary deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Itinerary deleted successfully",
     *                 description="Success message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="You are not authorized to delete this itinerary.",
     *                 description="Error message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Itinerary not found.",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Put(
     *     path="/api/itineraries/update/{id}",
     *     summary="Update an itinerary",
     *     tags={"Itineraries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the itinerary to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Itinerary data to update",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"title", "category", "image", "departure", "arrival", "duration", "destinations"},
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Category of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="Image URL of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     type="string",
     *                     format="date",
     *                     description="Departure date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     type="string",
     *                     format="date",
     *                     description="Arrival date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="string",
     *                     description="Duration of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="destinations",
     *                     type="array",
     *                     description="List of destinations",
     *                     @OA\Items(
     *                         type="object",
     *                         required={"name", "housing", "list"},
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Name of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="housing",
     *                             type="string",
     *                             description="Housing information of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="list",
     *                             type="string",
     *                             description="List of attractions in the destination"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Itinerary updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="success",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Itinerary with its destinations updated successfully",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="itinerary",
     *                 type="object",
     *                 description="Updated itinerary object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     format="int64",
     *                     description="Itinerary ID"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     description="Title of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="category",
     *                     type="string",
     *                     description="Category of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="string",
     *                     description="Image URL of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="departure",
     *                     type="string",
     *                     format="date",
     *                     description="Departure date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="arrival",
     *                     type="string",
     *                     format="date",
     *                     description="Arrival date of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="duration",
     *                     type="string",
     *                     description="Duration of the itinerary"
     *                 ),
     *                 @OA\Property(
     *                     property="destinations",
     *                     type="array",
     *                     description="List of destinations",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             format="int64",
     *                             description="Destination ID"
     *                         ),
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Name of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="housing",
     *                             type="string",
     *                             description="Housing information of the destination"
     *                         ),
     *                         @OA\Property(
     *                             property="list",
     *                             type="string",
     *                             description="List of attractions in the destination"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="You are not authorized to modify this itinerary.",
     *                 description="Error message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *                 description="Status of the response"
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Itinerary not found.",
     *                 description="Error message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 description="Validation errors",
     *                 example={
     *                     "title": {"The title field is required."},
     *                     "category": {"The category field is required."},
     *                     "image": {"The image field is required."},
     *                     "departure": {"The departure field is required."},
     *                     "arrival": {"The arrival field is required."},
     *                     "duration": {"The duration field is required."},
     *                     "destinations": {"The destinations field is required."},
     *                     "destinations.*.name": {"The name field is required."},
     *                     "destinations.*.housing": {"The housing field is required."},
     *                     "destinations.*.list": {"The list field is required."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */

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

    public function StoreListeAvisiter($itineraryId)
    {
        try {
            $user = Auth::user();

            $itinerary = Itinerary::find($itineraryId);
            if (!$itinerary) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Itinéraire non trouvé.',
                ], 404);
            }

            $user->itinerary()->attach($itineraryId, ['created_at' => now(), 'updated_at' => now()]);

            return response()->json([
                'status' => 'success',
                'message' => 'Itinéraire ajouté à la liste à visualiser avec succès.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de l\'ajout de l\'itinéraire à la liste à visualiser.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function DisplaylisteAVisiter()
    {
        try {
            $user = Auth::user();

            $itineraries = $user->itinerary()->with('destinations')->get();

            return response()->json([
                'status' => 'success',
                'itineraries' => $itineraries,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la récupération de la liste des itinéraires à visiter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
