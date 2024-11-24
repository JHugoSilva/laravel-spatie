<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResouce;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function index() {
        $categories = Category::all();

        return $this->sendResponse(CategoryResouce::collection($categories), 'Get Category Success');
    }
}
