<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Video;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $filterBy = "active"; // column to sort
        $sortBy = "created_at"; // column to sort
        $query = null; // search query

        if ($request->has('filterBy')) $filterBy = $request->query('filterBy');
        if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        if ($request->has('query')) $query = $request->query('query');

        $now = Carbon::now()->toDateTimeString();

        $result = Channel::search($query, $filterBy)
            ->withCount('followers as followers')
            ->withCount('videos as videos')
            ->orderBy($sortBy, 'desc')
            ->paginate(10);

        return view('channel.index', ['now' => $now, 'channels' => $result, 'filterBy' => $filterBy, 'sortBy' => $sortBy, 'query' => $query, 'parent' => 'playmi', 'menu' => 'channel']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('channel.create', ['parent' => 'playmi', 'menu' => 'channel']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $channel = new Channel();

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|max:1024',
        ]);

        if ($validate->fails()) return back()->withErrors($validate)->withInput($request->all());

        $path = Storage::disk('public')->putFile('channel_thumbnails', $request->file('thumbnail'));

        if (!Storage::disk('public')->exists($path)) {
            return back()->withErrors('Upload thumbnail failed');
        }

        $channel->name = $request->name;
        $channel->thumbnail = $path;
        $channel->description = $request->description;
        $channel->save();

        return redirect()->route('admin.channels.all');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return Factory|View
     */
    public function show(Request $request, $id)
    {
        $channel = Channel::find($id);
        $createdAt = Carbon::parse($channel->created_at);

        $filterBy = "published_at"; // column to sort
        $sortBy = "created_at"; // column to sort
        $query = null; // search query

        if ($request->has('filterBy')) $filterBy = $request->query('filterBy');
        if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        if ($request->has('query')) $query = $request->query('query');

        $now = Carbon::now()->toDateTimeString();

        $result = Video::search($query, $filterBy)
            ->withCount('views as views')
            ->where('channel_id', $id)
            ->orderBy($sortBy, 'desc')
            ->paginate(10);

        return view('channel.show', [
            'channel' => $channel,
            'videos' => $result,
            'now' => $now,
            'filterBy' => $filterBy,
            'sortBy' => $sortBy,
            'query' => $query,
            'createdAt' => $createdAt,
            'parent' => 'playmi',
            'menu' => 'channel']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $channel = Channel::find($id);

        return view('channel.edit', ["channel" => $channel, 'parent' => 'playmi', 'menu' => 'channel']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $channel = Channel::find($id);

        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'thumbnail' => 'max:1024',
        ]);

        if ($validate->fails()) return back()->withErrors($validate)->withInput($request->all());

        if ($request->thumbnail != null) {
            if (Storage::disk('public')->exists($channel->thumbnail)) {
                Storage::disk('public')->delete($channel->thumbnail);
            }

            $path = Storage::disk('public')->putFile('channel_thumbnails', $request->file('thumbnail'));

            if (!Storage::disk('public')->exists($path)) {
                return back()->withErrors('Upload thumbnail failed');
            }
            $channel->thumbnail = $path;
        }

        $channel->name = $request->name;
        $channel->description = $request->description;
        $channel->save();

        return redirect()->route('admin.channels.all');
    }

    /**
     * Suspend Channel.
     *
     * @param int $id
     * @return bool
     */
    public function suspend($id)
    {
        $channel = Channel::find($id);
        $channel->suspended_at = Carbon::now()->toDateTimeString();
        $channel->save();

        return true;
    }

    /**
     * Reactivate Channel.
     *
     * @param int $id
     * @return bool
     */
    public function activate($id)
    {
        $channel = Channel::find($id);
        $channel->suspended_at = null;
        $channel->save();

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $channel = Channel::find($id);
//        dd(Storage::disk('public')->delete($channel->thumbnail));
        $channel->followers()->detach();
        $channel->videos()->delete();
        $channel->videos()->delete();
        $channel->blacklists()->detach();

        Channel::destroy($id);


        return redirect()->route('admin.channels.all');
    }
}
