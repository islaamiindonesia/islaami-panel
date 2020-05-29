<?php

namespace App\Http\Controllers;

use App\Category;
use App\Channel;
use App\Subcategory;
use App\Video;
use App\VideoLabel;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $isPublished = "true"; // column to sort
        $sortBy = "created_at"; // column to sort
        $query = null; // search query

        if ($request->has('isPublished')) $isPublished = $request->query('isPublished');
        if ($request->has('sortBy')) $sortBy = $request->query('sortBy');
        if ($request->has('query')) $query = $request->query('query');

        $now = Carbon::now()->toDateTimeString();

        $result = Video::search($query, $isPublished)->withCount('views as views')->orderBy($sortBy, 'desc')->paginate(10);

        return view('video.index', [
            'now' => $now,
            'videos' => $result,
            'isPublished' => $isPublished,
            'sortBy' => $sortBy,
            'query' => $query,
            'parent' => 'playmi',
            'menu' => 'video'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $channels = Channel::all();
        $categories = Category::all();

        return view('video.create', ['channels' => $channels, 'categories' => $categories, 'parent' => 'playmi', 'menu' => 'video']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $videoID = $this->getVideoID($request->url);
        $thumbnail = "https://img.youtube.com/vi/" . $videoID . "/hqdefault.jpg";

        $video = new Video();

        if ($request->action == 'publish') {
            $video->is_published = true;
        } else {
            $video->is_published = false;
        }

        if ($request->publishNow != "off") {
            $video->is_published_now = true;
            $video->published_at = Carbon::now()->format('Y-m-d H:i');
        } else {
            $video->is_published_now = false;
            $video->published_at = Carbon::createFromFormat('d/m/Y H:i', $request->publishedAt);
        }

        $video->title = $request->title;
        $video->video_id = $videoID;
        $video->url = $request->url;
        $video->description = $request->description;
        $video->thumbnail = $thumbnail;
        $video->channel_id = $request->channel;
        $video->category_id = $request->category;
        $video->subcategory_id = $request->subcategory;
        $video->save();
        $video->labels()->attach($request->labels);

        /*Notification::send(
            $video->channel->followers()->get(),
            new NewVideo(
                $video->channel->name,
                $video->title,
                $video->id
            )
        );*/

        return redirect()->route('admin.videos.all');
    }

    private function getVideoID($url)
    {
        /**
         * Pattern matches
         * http://youtu.be/ID
         * http://www.youtube.com/embed/ID
         * http://www.youtube.com/watch?v=ID
         * http://www.youtube.com/?v=ID
         * http://www.youtube.com/v/ID
         * http://www.youtube.com/e/ID
         * http://www.youtube.com/user/username#p/u/11/ID
         * http://www.youtube.com/leogopal#p/c/playlistID/0/ID
         * http://www.youtube.com/watch?feature=player_embedded&v=ID
         * http://www.youtube.com/?feature=player_embedded&v=ID
         */
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

        // Checks if it matches a pattern and returns the value
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }

        // if no match return empty string.
        return "";
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $video = Video::find($id);

        return view('video.show', ['video' => $video, 'parent' => 'playmi', 'menu' => 'video']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $video = Video::find($id);
        $channels = Channel::all();
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $video->category->id)->get();

        return view('video.edit', [
            'video' => $video,
            'channels' => $channels,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'parent' => 'playmi',
            'menu' => 'video'
        ]);
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
        $videoID = $this->getVideoID($request->url);
        $thumbnail = "https://img.youtube.com/vi/" . $videoID . "/hqdefault.jpg";

        $video = Video::find($id);

        if ($request->action == 'publish') {
            $video->is_published = true;
        } else {
            $video->is_published = false;
        }

        if ($request->publishNow != "off") {
            $video->is_published_now = true;
            $video->published_at = Carbon::now()->format('Y-m-d H:i');
        } else {
            $video->is_published_now = false;
            if ($request->publishedAt != null) {
                $video->published_at = Carbon::createFromFormat('d/m/Y H:i', $request->publishedAt);
            }
        }

        $video->title = $request->title;
        $video->url = $request->url;
        $video->thumbnail = $thumbnail;
        $video->description = $request->description;
        $video->channel_id = $request->channel;
        $video->category_id = $request->category;
        $video->subcategory_id = $request->subcategory;
        $video->save();
        $video->labels()->sync($request->labels);

        return redirect()->route('admin.videos.all');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function upload($id)
    {
        $video = Video::find($id);
        $video->is_published = true;

        $video->save();

        return redirect()->route('admin.videos.all');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function draft($id)
    {
        $video = Video::find($id);
        $video->is_published = false;

        $video->save();

        return redirect()->route('admin.videos.all');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $video = Video::find($id);
        $video->labels()->detach();

        Video::destroy($id);
        VideoLabel::where('video_id', $id)->delete();
        return redirect()->route('admin.videos.all');
    }
}
