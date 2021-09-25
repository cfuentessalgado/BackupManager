<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServerRequest;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        return true;
    }

    public function create()
    {
        return true;
    }

    public function store(CreateServerRequest $request)
    {
        Server::create($request->safe()->all());

        return back()->withSuccess('Server created');
    }
}
