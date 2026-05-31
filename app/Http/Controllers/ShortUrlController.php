<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShortUrlRequest;
use App\Models\ShortUrl;
use App\Services\ShortUrlService;

class ShortUrlController extends Controller
{
    public function __construct(private ShortUrlService $shortUrlService)
    {
    }

    public function index()
    {
        $this->authorize('viewAny', ShortUrl::class);
        
        $query = ShortUrl::with(['company', 'user']);

        if (auth()->user()->hasRole('Admin')) {
            $query->where('company_id', '=', auth()->user()->company_id);
        }

        if (auth()->user()->hasRole('Member')) {
            $query->where('user_id', '=', auth()->user()->id);
        }
        $shortUrls = $query->latest()->paginate(15);

        return view('short_urls.index', compact('shortUrls'));
    }

    public function create()
    {
        $this->authorize('create', ShortUrl::class);

        return view('short_urls.create');
    }

    public function store(StoreShortUrlRequest $request)
    {
        $this->authorize('create', ShortUrl::class);

        $this->shortUrlService->createShortUrl($request->user(), $request->original_url);

        return redirect()->route('short-urls.index')
            ->with('success', 'Short URL created successfully.');
    }

    public function destroy(ShortUrl $shortUrl)
    {
        $this->authorize('delete', $shortUrl);

        $shortUrl->delete();

        return redirect()->route('short-urls.index')
            ->with('success', 'Short URL deleted successfully.');
    }
}
