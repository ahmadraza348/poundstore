<?php
namespace App\Services\Admin;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class  CategoryService
{
    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('images/categories', 'public');
            }

            $category = Category::create($data);

           
            return $category;
        });
    }

    public function update(Category $category, array $data): Category
    {
        return DB::transaction(function () use ($category, $data) {

            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('images/categories', 'public');
            }

            $category->update($data);
        

            return $category;
        });
    }

    public function delete(Category $category): void
    {
        DB::transaction(function () use ($category) {
            $category->delete();
        });
    }

    public function bulkDelete(array $categoryIds): void
    {
        DB::transaction(function () use ($categoryIds) {


            Category::whereIn('id', $categoryIds)->delete();
        });
    }
  
}
