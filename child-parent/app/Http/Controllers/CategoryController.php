<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
//        $categories = Category::whereNull('parent_id')->with('allChildren')->get();
////        return  $categories;
//        return view('categories.index', compact('categories'));


        $user = Category::first();
//        return $user;
        $childUsers = $this->getChildUsers($user);
        return $childUsers;

        $categoriesHierarchy = $this->getCategoriesHierarchy();
        return $categoriesHierarchy;
        return view('categories.index', compact('categoriesHierarchy'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    function getCategoriesHierarchy()
    {
        // Fetch all categories with their children
        $categories = Category::with('children')->get();
        return $categories;

        // Convert the collection to an associative array keyed by id
        $categoriesById = $categories->keyBy('id')->all();

        // Initialize an array to hold the top-level categories
        $hierarchy = [];

        // Loop through each category and assign children to their parent
        foreach ($categoriesById as $id => $category) {
            if ($category->parent_id === null) {
                $hierarchy[] = $this->formatCategory($category, $categoriesById);
            }
        }

        return $hierarchy;
    }

    function formatCategory($category, $categoriesById)
    {
        $formattedCategory = [
            'id' => $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id,
            'children' => [],
        ];

        $allChildren = $category->getChildren();
        foreach ($allChildren as $child) {
            $formattedCategory['children'][] = [
                'id' => $child->id,
                'name' => $child->name,
                'parent_id' => $child->parent_id,
                'children' => [],
            ];
        }

        return $formattedCategory;
    }


    private function getChildUsers($user)
    {
        $users = collect();
        foreach ($user->children as $child) {
            $users->push($child);
            $users = $users->merge($this->getChildUsers($child));
        }
        return $users;
    }
}
