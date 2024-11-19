<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Categories', description: 'APIs for managing categories')]
#[QueryParam('page', 'int', 'The page number.', 'Example: 1')]
class CategoryController extends Controller
{
    /**
     * Get all categories
     *
     * Getting the list of categories
     */
    public function index()
    {
        abort_if(!auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::collection(Category::all());
    }

    #[Endpoint('show category',description: 'Get a category by id')]
    public function show(Category $category)
    {
        abort_if(!auth()->user()->tokenCan('categories-show'), 403);
        return new CategoryResource($category);
    }

    public function list()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Create a new category
     *
     * Creating a new category
     *
     * @bodyParam name string required The name of the category. Example: Electronics
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo'); // get the file, con todos los datos y metadatos
            $name = Str::uuid() . '.' . $file->extension(); // get the name of the file
            $file->storeAs('categories', $name, 'public'); // save the file in the storage
            $data['photo'] = $name; // set the name of the file in the database
        }

        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

}
