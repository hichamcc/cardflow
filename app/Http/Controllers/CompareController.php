<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CompareController extends Controller
{
    private array $competitors = [
        'hihello' => [
            'name' => 'HiHello',
            'slug' => 'hihello',
            'tagline' => 'A popular digital business card app focused on sharing contact info.',
            'meta_description' => 'BsnCard vs HiHello — Compare digital business card features, pricing, and built-in CRM. See why BsnCard is the better alternative for professionals.',
            'color' => '#6366f1',
            'pros' => ['Polished mobile app', 'Virtual backgrounds', 'Team management'],
            'cons' => ['No built-in CRM or follow-up system', 'Limited free plan', 'Contact management requires premium', 'No deal or pipeline tracking'],
            'why_switch' => 'HiHello is great for sharing contact info, but stops there. BsnCard adds a full networking CRM — log interactions, set follow-up reminders, track deals, and manage your network without switching apps.',
            'faqs' => [
                ['q' => 'Does HiHello have a CRM?', 'a' => 'No. HiHello lets you collect contacts but offers no follow-up reminders, interaction logs, or deal tracking. BsnCard includes all of this.'],
                ['q' => 'Is BsnCard free like HiHello?', 'a' => 'Yes. BsnCard\'s free plan includes unlimited cards, QR sharing, and core CRM features — no credit card needed.'],
                ['q' => 'Can I import my HiHello contacts into BsnCard?', 'a' => 'Yes. Export your contacts as a CSV or vCard from HiHello and import them directly into BsnCard.'],
            ],
        ],
        'linktree' => [
            'name' => 'Linktree',
            'slug' => 'linktree',
            'tagline' => 'A link-in-bio tool that lets you share multiple links from one page.',
            'meta_description' => 'BsnCard vs Linktree — BsnCard is built for professionals who need more than a link list. Compare features for networking, QR cards, and contact management.',
            'color' => '#39e09b',
            'pros' => ['Simple link-in-bio page', 'Social media integration', 'Analytics on link clicks'],
            'cons' => ['Not a business card — no contact info card', 'No vCard / contact download', 'No CRM or networking features', 'Not designed for B2B networking'],
            'why_switch' => 'Linktree is a link aggregator, not a business card. BsnCard gives visitors a proper contact card they can save to their phone, while also giving you a CRM to manage everyone you meet.',
            'faqs' => [
                ['q' => 'Is BsnCard a Linktree alternative?', 'a' => 'BsnCard serves a different purpose — it\'s a digital business card with a built-in CRM. If you need to share contact info and manage your network, BsnCard is the better fit.'],
                ['q' => 'Can BsnCard replace Linktree?', 'a' => 'For professionals and B2B networking, yes. BsnCard includes social links and all your contact info on one card, plus visitors can download your vCard directly.'],
                ['q' => 'Does Linktree let people save your contact info?', 'a' => 'No. Linktree doesn\'t offer a vCard download or contact card. BsnCard does both.'],
            ],
        ],
        'blinq' => [
            'name' => 'Blinq',
            'slug' => 'blinq',
            'tagline' => 'A digital business card app popular in Australia and growing globally.',
            'meta_description' => 'BsnCard vs Blinq — Compare digital business card apps. BsnCard adds a full networking CRM that Blinq doesn\'t offer.',
            'color' => '#f59e0b',
            'pros' => ['Clean card design', 'NFC support', 'Apple Wallet integration'],
            'cons' => ['No CRM or follow-up system', 'Very limited free plan', 'No deal or pipeline tracking', 'No contact interaction history'],
            'why_switch' => 'Blinq is a solid card-sharing app but it\'s purely transactional. BsnCard adds context to every contact — notes, follow-up reminders, interaction logs — turning each card exchange into a lasting professional relationship.',
            'faqs' => [
                ['q' => 'Is Blinq free?', 'a' => 'Blinq has a very limited free tier. BsnCard\'s free plan is more generous and includes CRM features Blinq charges for.'],
                ['q' => 'Does Blinq have a CRM?', 'a' => 'No. Blinq focuses on card sharing. BsnCard includes contact management, notes, follow-ups, and deal tracking.'],
                ['q' => 'Does BsnCard support NFC like Blinq?', 'a' => 'BsnCard works with any NFC card or tag that links to your public card URL — no proprietary hardware required.'],
            ],
        ],
        'popl' => [
            'name' => 'Popl',
            'slug' => 'popl',
            'tagline' => 'An NFC-based digital business card platform that requires physical products.',
            'meta_description' => 'BsnCard vs Popl — See why BsnCard is a better digital business card alternative that works without NFC hardware and includes a free built-in CRM.',
            'color' => '#ec4899',
            'pros' => ['NFC products (cards, bands)', 'Slick mobile app', 'Team dashboard'],
            'cons' => ['Requires buying NFC hardware', 'No built-in CRM', 'Expensive team plans', 'Dependent on proprietary devices'],
            'why_switch' => 'Popl locks you into buying their hardware. BsnCard works instantly via QR code on any device — no physical product needed. And unlike Popl, BsnCard includes a CRM so you can actually manage the contacts you collect.',
            'faqs' => [
                ['q' => 'Do I need to buy a Popl product to use it?', 'a' => 'Yes, Popl\'s core product is NFC hardware. BsnCard requires nothing — just share your QR code or link.'],
                ['q' => 'Does Popl have a CRM?', 'a' => 'Popl has basic lead capture. BsnCard includes a full CRM with notes, follow-up reminders, interaction history, and deal tracking.'],
                ['q' => 'Is BsnCard cheaper than Popl?', 'a' => 'Yes. BsnCard has a free plan with no hardware cost. Popl requires a hardware purchase plus a subscription for team features.'],
            ],
        ],
        'haystack' => [
            'name' => 'Haystack',
            'slug' => 'haystack',
            'tagline' => 'A team-focused digital business card platform for enterprises.',
            'meta_description' => 'BsnCard vs Haystack — Compare digital business card features. BsnCard is the better choice for individuals and small teams who need built-in CRM tools.',
            'color' => '#10b981',
            'pros' => ['Team brand management', 'Admin controls', 'Analytics dashboard'],
            'cons' => ['Built for enterprises, expensive for individuals', 'No personal CRM or follow-up tools', 'Limited free plan', 'Overkill for solopreneurs and freelancers'],
            'why_switch' => 'Haystack is designed for large teams managing brand consistency. BsnCard is built for the individual professional who wants a great card and a CRM to grow their network — without enterprise pricing.',
            'faqs' => [
                ['q' => 'Is Haystack free?', 'a' => 'Haystack has a limited free tier. For full features, pricing is enterprise-focused. BsnCard offers a generous free plan with CRM features included.'],
                ['q' => 'Does Haystack include a CRM?', 'a' => 'No. Haystack focuses on team card management. BsnCard adds personal CRM features — contact notes, follow-ups, interaction logs, and pipeline tracking.'],
                ['q' => 'Is BsnCard good for small teams?', 'a' => 'Yes. BsnCard works great for individuals, freelancers, and small teams who want digital cards with networking tools without enterprise contracts.'],
            ],
        ],
    ];

    private array $featureRows = [
        ['label' => 'Digital business card', 'bsn' => true, 'all' => true],
        ['label' => 'QR code sharing', 'bsn' => true, 'all' => true],
        ['label' => 'vCard / contact download', 'bsn' => true, 'all' => false],
        ['label' => 'Built-in CRM', 'bsn' => true, 'all' => false],
        ['label' => 'Contact interaction log', 'bsn' => true, 'all' => false],
        ['label' => 'Follow-up reminders', 'bsn' => true, 'all' => false],
        ['label' => 'Deal & pipeline tracking', 'bsn' => true, 'all' => false],
        ['label' => 'Generous free plan', 'bsn' => true, 'all' => false],
        ['label' => 'No hardware required', 'bsn' => true, 'all' => false],
        ['label' => 'Custom card design', 'bsn' => true, 'all' => false],
    ];

    public function index(): View
    {
        return view('compare.index', ['competitors' => $this->competitors]);
    }

    public function show(string $slug): View
    {
        abort_unless(isset($this->competitors[$slug]), 404);

        $competitor = $this->competitors[$slug];
        $features = $this->featureRows;

        // Per-competitor feature overrides
        $overrides = [
            'hihello'  => ['vCard / contact download' => true],
            'linktree' => ['QR code sharing' => true, 'vCard / contact download' => false, 'Custom card design' => false],
            'blinq'    => ['vCard / contact download' => true, 'No hardware required' => false],
            'popl'     => ['vCard / contact download' => true, 'No hardware required' => false],
            'haystack' => ['vCard / contact download' => true],
        ];

        foreach ($features as &$row) {
            $row['competitor'] = $overrides[$slug][$row['label']] ?? $row['all'];
        }

        return view('compare.show', compact('competitor', 'features'));
    }
}
