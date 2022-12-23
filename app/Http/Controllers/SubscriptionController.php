<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    use ApiResponser;

    public function subscribe(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'email' => 'required|string|email|max:255',
            'domain' => 'required|string'
        ])->validate();

        try {
            $website = Website::where('domain', $data['domain'])->firstOrFail();
            Subscription::create([
                'email' => $data['email'],
                'website_id' => $website->id
            ]);
        } catch (ModelNotFoundException $e) {
            return $this->error('Website not found', $e, 404);
        } catch (Exception $e) {
            return $this->error('Something went wrong', $e, 500);
        }

        return $this->success(null, 'Successfully subscribed!', 200);
    }
}
