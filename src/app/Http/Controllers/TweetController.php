<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
// ディレクトリはAppからはじまる
use App\Models\Tweet;
use App\Services\TweetService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweetService = new TweetService();
        // インスタンスを作成
        $tweets = $tweetService->getTweets();
        // つぶやき一覧取得　
        // $tweets = Tweet::all();
        // dd($tweets);
        return view('tweet.index')
            ->with('tweets', $tweets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $tweet = new Tweet;
        $tweet->user_id = $request->userId();
        //ここでUSEID保存している
        $tweet->content = $request->tweet();
        $tweet->save();

        // return to_route('tweet.')->with('success', '投稿できました。');

        return redirect()->route('tweet.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        // dd($tweet);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, TweetService $tweetService)
    {
    
        $tweetId = (int) $request->route('tweetId');
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }
        $tweet = Tweet::where('id', $tweetId)->firstOrFail();
    
        return view('tweet.update')->with('tweet',$tweet);
    
        // if (is_null($tweet)) {
        //     throw new NotfoundHttpException('存在しないつぶやきです');
        // }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateRequest $request, TweetService $tweetService)
    {
        if (!$tweetService->checkOwnTweet($request->user()->id, $request->id())) {
            throw new AccessDeniedHttpException();
        }

        $tweet = Tweet::where('id', $request->id())->FirstOrFail();
        $tweet->content = $request->tweet();
        $tweet->save();

        return to_route('tweet.edit', ['tweetId' => $tweet->id])->with('feedback.success', "つぶやきを編集しました");
        // return redirect()
        //     ->route('tweet.update.index', ['tweetId' => $tweet->id])
        //     ->with('feedback.success', "つぶやきを編集しました");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TweetService $tweetService)
    {
        $tweetId = (int) $request->route('tweetId');
        if (!$tweetService->checkOwnTweet($request->user()->id, $tweetId)) {
            throw new AccessDeniedHttpException();
        }
        $tweet   = Tweet::where('id', $tweetId)->FirstOrFail();
        $tweet->delete();

        return to_route('tweet.index')->with('feedback.success', "つぶやきを削除しました");
    }
}
