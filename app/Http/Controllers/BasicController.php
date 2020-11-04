<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BasicController
{

    protected $class;

    public function list()
    {
    	return $this->class::get();
    }

    public function get(int $id)
    {
        $resource = $this->class::find($id);
        if (is_null($resource)) {
            return response()->json('', 204);
        }
    	return response()->json($resource);
    }

    public function create(Request $request)
    {
    	return response()->json($this->class::create($request->all()), 201);
    }

    public function edit(Request $request)
    {
        $resource = $this->class::find($request->id);
        if (is_null($resource)) {
            return response()->json(['error' => 'Recurso não encontrado'], 404);
        }
    	$resource->update($request->all());

    	return $resource;
    }

    public function delete(int $id)
    {
        if ($this->class::destroy($id) === 0) {
            return response()->json(['error' => 'Recurso não encontrado'], 404);
        }

        return response()->json('', 204);
    }

}
