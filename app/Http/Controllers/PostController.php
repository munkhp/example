<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Website;
use Exception;

class PostController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'domain' => 'required|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ])->validate();

        try {
            $website = Website::where('domain', $data['domain'])->firstOrFail();
            Post::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'website_id' => $website->id
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->error('Website not found', $e, 404);
        } catch (Exception $e) {
            return $this->error('Something went wrong', $e, 500);
        }

        return $this->success(null, 'Post created successfully!', 200);
    }
}
