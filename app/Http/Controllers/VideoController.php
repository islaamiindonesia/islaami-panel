<?php

namespace App\Http\Controllers;

use App\Category;
use App\Channel;
use App\Label;
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
        $selected = "published";
        $filter = $request->query('filter');
        $now = Carbon::now()->toDateTimeString();

        if ($filter != null) {
            if ($filter == "draft") {
                $videos = Video::where('published_at', null);
            } else {
                $videos = Video::where('published_at', '<>', null);
            }
            $selected = $filter;
        } else {
            $videos = Video::where('published_at', '<>', null);
        }

        $videoArray = array();
        foreach ($videos->get() as $video) {
            $video->views = $video->views->count();
            array_push($videoArray, $video);
        }

        return view('video.index', ['now' => $now, 'videos' => $videos->get(), 'selected' => $selected, 'parent' => 'playmi', 'menu' => 'video']);
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

        if ($request->upload == "on") {
            $publishedAt = Carbon::now()->toDateString();
        } else {
            $publishedAt = Carbon::parse($request->published);
        }

        $video = new Video();
        $video->title = $request->title;
        $video->video_id = $videoID;
        $video->url = $request->url;
        $video->description = $request->description;
        $video->thumbnail = $thumbnail;
        $video->published_at = $publishedAt;
        $video->channel_id = $request->channel;
        $video->category_id = $request->category;
        $video->subcategory_id = $request->subcategory;
        $video->save();
        $video->labels()->attach($request->labels);

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
        $labels = Label::where('subcategory_id', $video->subcategory->id)->get();

        $selectedLabels = $video->labels;
        $publishedAt = Carbon::parse($video->published_at);

        return view('video.edit',
            [
                'video' => $video,
                'channels' => $channels,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'labels' => $labels,
                'selectedLabels' => $selectedLabels,
                'publishedAt' => $publishedAt,
                'parent' => 'playmi',
                'menu' => 'video'
            ]
        );
    }

    /* CUSTOM METHODS */

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

        $video = Video::updateOrCreate(
            ['id' => $id],
            [
                'title' => $request->title,
                'url' => $request->url,
                'thumbnail' => $thumbnail,
                'description' => $request->description,
                'channel_id' => $request->channel,
                'category_id' => $request->category,
                'subcategory_id' => $request->subcategory,
            ]
        );

        VideoLabel::where('video_id', $video->id)->delete();
        foreach ($request->labels as $label) {
            VideoLabel::updateOrCreate(
                ['video_id' => $video->id, 'label_id' => $label]
            );
        }

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
