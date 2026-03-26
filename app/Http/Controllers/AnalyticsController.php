<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Stats
        $stats = [
            'total_cards' => $user->businessCards()->count(),
            'total_contacts' => $user->savedCards()->count(),
            'total_views' => (int) $user->businessCards()->sum('view_count'),
            'total_pipeline_value' => (float) $user->deals()->open()->sum('deal_value'),
        ];

        // Card Performance — bar chart (card name → view count)
        $viewsByCard = $user->businessCards()
            ->select('card_name', 'view_count')
            ->orderByDesc('view_count')
            ->limit(10)
            ->get();

        // Interactions by Day — last 30 days line chart
        $interactionsByDay = $user->interactions()
            ->where('interaction_date', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(interaction_date) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Interaction Types — doughnut
        $interactionTypes = $user->interactions()
            ->select('interaction_type', DB::raw('COUNT(*) as count'))
            ->groupBy('interaction_type')
            ->get();

        // Deals by Stage — horizontal bar
        $dealsByStage = $user->deals()
            ->select('stage', DB::raw('SUM(deal_value) as total'))
            ->groupBy('stage')
            ->get();

        // Relationship Health — doughnut (bucketed)
        $savedCards = $user->savedCards()->get();
        $healthBuckets = ['Good' => 0, 'Fair' => 0, 'Needs Attention' => 0];
        foreach ($savedCards as $card) {
            $score = $card->relationshipHealthScore();
            if ($score >= 70) {
                $healthBuckets['Good']++;
            } elseif ($score >= 40) {
                $healthBuckets['Fair']++;
            } else {
                $healthBuckets['Needs Attention']++;
            }
        }

        // Top Contacts by Activity — horizontal bar (top 5)
        $topContacts = $user->savedCards()
            ->withCount('interactions')
            ->orderByDesc('interactions_count')
            ->limit(5)
            ->get()
            ->map(fn ($c) => [
                'name' => $c->getFullName() ?: 'Unnamed',
                'count' => $c->interactions_count,
            ]);

        return view('analytics.index', compact(
            'stats',
            'viewsByCard',
            'interactionsByDay',
            'interactionTypes',
            'dealsByStage',
            'healthBuckets',
            'topContacts',
        ));
    }
}
