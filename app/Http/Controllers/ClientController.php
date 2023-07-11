<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ClientCollection
     */
    public function index()
    {
        return new ClientCollection(Client::paginate());
    }


    public function store(StoreClientRequest $request)
    {
        $attr = $request->validated();

        $client = new Client();
        $client->title = $attr['title'];
        $client->description = $attr['description'];
        $client->user_id = $request->user()->id;
        $client->save();

        return new ClientResource($client);
    }


    public function show($id)
    {
        return new ClientResource(Client::findOrFail($id));
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $attr = $request->validated();

        $client = Client::findOrFail($id);
        $client->title = $attr['title'];
        $client->description = $attr['description'];
        $client->user_id = $request->user()->id;
        $client->save();

        return new ClientResource($client);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        if($client->delete()){
            return response()->json([
                'message' => 'The client was successfully deleted',
            ], 200);
        }

        return response()->json([
            'message' => 'A deletion error occurred',
        ], 200);
    }
}
