<?php

namespace Api\Controllers;

use HRis\Dog;
use HRis\Http\Requests;
use Illuminate\Http\Request;
use Api\Requests\DogRequest;
use Api\Transformers\DogTransformer;

/**
 * @Resource('Dogs', uri='/dogs')
 */
class DogsController extends BaseController
{

    public function __construct() 
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Show all dogs
     *
     * Get a JSON representation of all the dogs
     * 
     * @Get('/')
     */
    public function index()
    {
        return $this->collection(Dog::all(), new DogTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DogRequest $request)
    {
        return Dog::create($request->only(['name', 'age']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->item(Dog::findOrFail($id), new DogTransformer);
    }

    /**
     * Update the dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DogRequest $request, $id)
    {
        $dog = Dog::findOrFail($id);
        $dog->update($request->only(['name', 'age']));
        return $dog;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Dog::destroy($id);
    }
}
