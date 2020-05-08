<?php

namespace App\Http\Controllers;

use App\Channel;
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
        $selected = "active";
        $filter = $request->query('filter');
        if ($filter != null) {
            if ($filter == "active") {
                $channels = Channel::where('suspended_at', null);
            } else {
                $channels = Channel::where('suspended_at', '<>', null);
            }
            $selected = $filter;
        } else {
            $channels = Channel::where('suspended_at', null);
        }

        $channelArray = array();
        foreach ($channels->get() as $channel) {
            $channel->followers = $channel->followers->count();
            $channel->videos = $channel->videos->count();
            array_push($channelArray, $channel);
        }

        return view('channel.index', ['channels' => $channelArray, 'selected' => $selected, 'parent' => 'playmi', 'menu' => 'channel']);
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
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $channel = Channel::find($id);
        $createdAt = Carbon::parse($channel->created_at);

        return view('channel.show', ['channel' => $channel, 'createdAt' => $createdAt, 'parent' => 'playmi', 'menu' => 'channel']);
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
            'thumbnail' => 'required|max:1024',
        ]);

        if ($validate->fails()) return back()->withErrors($validate)->withInput($request->all());

        if (Storage::disk('public')->exists($channel->thumbnail)) {
            Storage::disk('public')->delete($channel->thumbnail);
        }

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
