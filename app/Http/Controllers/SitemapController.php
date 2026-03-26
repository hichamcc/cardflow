<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $cards = BusinessCard::where('is_active', true)
            ->select('slug', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->get();

        $content = view('sitemap', compact('cards'))->render();

        return response($content)
            ->header('Content-Type', 'application/xml');
    }
}
