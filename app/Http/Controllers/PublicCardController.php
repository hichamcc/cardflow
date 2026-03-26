<?php

namespace App\Http\Controllers;

use App\Models\BusinessCard;
use App\Models\CardSocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicCardController extends Controller
{
    public function show(string $slug): View
    {
        $card = BusinessCard::where('slug', $slug)
            ->where('is_active', true)
            ->with(['socialLinks', 'customFields', 'user'])
            ->firstOrFail();

        $card->incrementViews();

        $qrCode = QrCode::size(200)
            ->format('svg')
            ->generate($card->getPublicUrl());

        return view('public.card', compact('card', 'qrCode'));
    }

    public function trackLink(string $slug, CardSocialLink $link): RedirectResponse
    {
        $card = BusinessCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        abort_unless($link->business_card_id === $card->id, 404);

        $link->incrementClicks();

        return redirect()->away($link->url);
    }

    public function downloadVCard(string $slug): Response
    {
        $card = BusinessCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:{$card->full_name}\r\n";

        if ($card->company_name) {
            $vcard .= "ORG:{$card->company_name}\r\n";
        }
        if ($card->job_title) {
            $vcard .= "TITLE:{$card->job_title}\r\n";
        }
        if ($card->email) {
            $vcard .= "EMAIL:{$card->email}\r\n";
        }
        if ($card->phone) {
            $vcard .= "TEL:{$card->phone}\r\n";
        }
        if ($card->website) {
            $vcard .= "URL:{$card->website}\r\n";
        }

        $vcard .= "URL:{$card->getPublicUrl()}\r\n";
        $vcard .= "END:VCARD\r\n";

        $filename = str_replace(' ', '_', $card->full_name) . '.vcf';

        return response($vcard)
            ->header('Content-Type', 'text/vcard')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    public function downloadQr(string $slug): Response
    {
        $card = BusinessCard::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $qrCode = QrCode::size(400)
            ->format('png')
            ->generate($card->getPublicUrl());

        $filename = str_replace(' ', '_', $card->full_name) . '_qr.png';

        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
