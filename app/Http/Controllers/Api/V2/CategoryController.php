<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     tags={"Categories"},
     *     summary="List all categories",
     *     @OA\Response(response="200", description="Successful operation"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden")
     *  )
     */
    public function index()
    {
        abort_if(!auth()->user()->tokenCan('categories-list'), 403);

        return CategoryResource::collection(Cache::rememberForever('categories', function () {
            return Category::all();
        }));
    }

    public function show(Category $category)
    {
       // abort_if(!auth()->user()->tokenCan('categories-show'), 403);
        return new CategoryResource($category);
    }

    public function list()
    {
        return CategoryResource::collection(Category::all());
    }

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
