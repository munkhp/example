<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscription;
use App\Models\Website;
use Exception;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $websites = Website::with('posts')->get();
        foreach ($websites as $website) {
            foreach ($website->posts as $post) {
                if ($post->created_at > $website->last_sent) {
                    $subscriptions = Subscription::where('website_id', $website->id)->get();
                    foreach ($subscriptions as $subscription) {
                        Mail::raw($post->description, function ($message) use ($subscription, $post) {
                            $message->to($subscription->email);
                            $message->subject($post->title);
                        });
                    }
                }
            }
            $website->last_sent = date('Y-m-d H:i:s');
            $website->save();
        }
    }
}
