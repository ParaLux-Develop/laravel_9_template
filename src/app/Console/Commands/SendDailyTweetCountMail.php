<?php

namespace App\Console\Commands;

use App\Mail\DailyTweetCount;
use App\Models\User;
use App\Services\TweetService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;

class SendDailyTweetCountMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send-daily-tweet-count-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '前日のつぶやきを集計してつぶやきを促すメールを送ります。';

    private TweetService $tweetService;
    private Mailer $mailer;

    /**
     * Create a new command.
     *
     * @return void
     */
    public function __construct(TweetService $tweetService, Mailer $mailer)
    {
        parent::__construct();
        $this->tweetService = $tweetService;
        $this->mailer = $mailer;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::debug('前日のつぶやきを集計してつぶやきを促すメールを送ります。');
        $tweetCount = $this->tweetService->countYesterdayTweets();

        $users = User::get();

        foreach ($users as $user) {
            Log::debug($user->email.'に対して送ります。');

            $this->mailer->to($user->email)
            ->send(new DailyTweetCount($user, $tweetCount));
        }

        Log::debug('前日のつぶやきを集計してつぶやきを促すメールを送り終わりました。');
        return 0;
    }
}
