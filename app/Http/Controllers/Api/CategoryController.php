<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

#[Group("Category management", "APIs for managing categories")]
#[Authenticated]
class CategoryController extends Controller
{
    /**
     * List categories
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Create categories
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->all());

        return $this->successResponse(__('category.created'),$category, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Show categories
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * Update categories
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return $this->successResponse(__('category.update'),$category, ResponseAlias::HTTP_OK);
    }

    /**
     * Delete categories
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(Lang::get('category.deleted'), ResponseAlias::HTTP_OK);
    }
}

