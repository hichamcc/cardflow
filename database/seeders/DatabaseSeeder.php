<?php

namespace Database\Seeders;

use App\Models\BusinessCard;
use App\Models\CardSocialLink;
use App\Models\CardTag;
use App\Models\ContactSubmission;
use App\Models\Deal;
use App\Models\Event;
use App\Models\Folder;
use App\Models\FollowUp;
use App\Models\Interaction;
use App\Models\Note;
use App\Models\SavedCard;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create main demo user
        $demoUser = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@bsncard.app',
            'subscription_tier' => 'pro',
        ]);

        // Create demo user's business cards
        $workCard = BusinessCard::factory()->create([
            'user_id' => $demoUser->id,
            'card_name' => 'Work',
            'full_name' => $demoUser->name,
            'job_title' => 'Product Manager',
            'company_name' => 'TechCorp',
            'email' => 'demo@techcorp.com',
            'phone' => '+1 (555) 123-4567',
            'website' => 'https://techcorp.com',
            'bio' => 'Building the future of digital networking. Passionate about product design and user experience.',
            'theme_color' => '#3B82F6',
            'view_count' => 127,
        ]);

        CardSocialLink::factory()->create(['business_card_id' => $workCard->id, 'platform' => 'linkedin', 'url' => 'https://linkedin.com/in/demouser', 'display_order' => 0]);
        CardSocialLink::factory()->create(['business_card_id' => $workCard->id, 'platform' => 'twitter', 'url' => 'https://twitter.com/demouser', 'display_order' => 1]);
        CardSocialLink::factory()->create(['business_card_id' => $workCard->id, 'platform' => 'github', 'url' => 'https://github.com/demouser', 'display_order' => 2]);

        $freelanceCard = BusinessCard::factory()->create([
            'user_id' => $demoUser->id,
            'card_name' => 'Freelance',
            'full_name' => $demoUser->name,
            'job_title' => 'UX Consultant',
            'company_name' => null,
            'email' => 'hello@demouser.dev',
            'theme_color' => '#8B5CF6',
            'view_count' => 43,
        ]);

        // Create folders for demo user
        $clientsFolder = Folder::factory()->create(['user_id' => $demoUser->id, 'name' => 'Clients', 'color' => '#10B981']);
        $prospectsFolder = Folder::factory()->create(['user_id' => $demoUser->id, 'name' => 'Prospects', 'color' => '#F59E0B']);
        $networkingFolder = Folder::factory()->create(['user_id' => $demoUser->id, 'name' => 'Networking', 'color' => '#3B82F6']);

        // Create tags for demo user
        $vipTag = CardTag::factory()->create(['user_id' => $demoUser->id, 'name' => 'VIP', 'color' => '#EF4444']);
        $hotLeadTag = CardTag::factory()->create(['user_id' => $demoUser->id, 'name' => 'Hot Lead', 'color' => '#F59E0B']);
        $referralTag = CardTag::factory()->create(['user_id' => $demoUser->id, 'name' => 'Referral', 'color' => '#8B5CF6']);
        $speakerTag = CardTag::factory()->create(['user_id' => $demoUser->id, 'name' => 'Speaker', 'color' => '#3B82F6']);

        // Create other users with cards
        $otherUsers = User::factory(15)->create();
        $savedCards = collect();

        foreach ($otherUsers as $otherUser) {
            $card = BusinessCard::factory()->create(['user_id' => $otherUser->id, 'full_name' => $otherUser->name]);

            CardSocialLink::factory()->count(rand(1, 3))->create(['business_card_id' => $card->id]);

            // Some users save demo user's card
            if (rand(0, 1)) {
                SavedCard::factory()->create([
                    'user_id' => $otherUser->id,
                    'business_card_id' => $workCard->id,
                    'saved_from_user_id' => $demoUser->id,
                ]);
            }

            // Demo user saves some cards
            if (rand(0, 2) > 0) {
                $savedCard = SavedCard::factory()->create([
                    'user_id' => $demoUser->id,
                    'business_card_id' => $card->id,
                    'saved_from_user_id' => $otherUser->id,
                    'folder_id' => fake()->randomElement([$clientsFolder->id, $prospectsFolder->id, $networkingFolder->id, null]),
                ]);
                $savedCards->push($savedCard);

                // Attach random tags
                $tagIds = collect([$vipTag->id, $hotLeadTag->id, $referralTag->id, $speakerTag->id])
                    ->random(rand(0, 2))
                    ->toArray();
                $savedCard->tags()->attach($tagIds);

                // Create interactions for some saved cards
                if (rand(0, 1)) {
                    Interaction::factory()->count(rand(1, 4))->create([
                        'user_id' => $demoUser->id,
                        'saved_card_id' => $savedCard->id,
                    ]);
                }

                // Create follow-ups for some
                if (rand(0, 2) === 0) {
                    FollowUp::factory()->create([
                        'user_id' => $demoUser->id,
                        'saved_card_id' => $savedCard->id,
                    ]);
                }

                // Create deals for some (business tier feature)
                if (rand(0, 3) === 0) {
                    Deal::factory()->create([
                        'user_id' => $demoUser->id,
                        'saved_card_id' => $savedCard->id,
                    ]);
                }
            }
        }

        // --- Manual Clients ---
        $manualClients = collect();
        $manualNames = ['Sarah Johnson', 'Mike Chen', 'Emily Rodriguez', 'James Park', 'Lisa Thompson'];
        foreach ($manualNames as $i => $name) {
            $mc = SavedCard::factory()->manualClient()->create([
                'user_id' => $demoUser->id,
                'full_name' => $name,
                'folder_id' => fake()->randomElement([$clientsFolder->id, $prospectsFolder->id, null]),
            ]);
            $mc->tags()->attach(collect([$vipTag->id, $hotLeadTag->id, $referralTag->id])->random(rand(0, 2))->toArray());
            $manualClients->push($mc);
        }

        $allContacts = $savedCards->merge($manualClients);

        // --- Notes ---
        // Standalone notes
        Note::factory()->count(4)->create([
            'user_id' => $demoUser->id,
        ]);
        // Pinned standalone note
        Note::factory()->pinned()->create([
            'user_id' => $demoUser->id,
            'title' => 'Q1 Goals',
            'content' => "1. Close 5 new deals\n2. Reach out to 20 prospects\n3. Attend 3 networking events\n4. Update all business cards",
            'category' => 'todo',
        ]);
        // Attached notes
        $noteContacts = $allContacts->random(min(5, $allContacts->count()));
        foreach ($noteContacts as $contact) {
            Note::factory()->create([
                'user_id' => $demoUser->id,
                'saved_card_id' => $contact->id,
            ]);
        }

        // --- Events ---
        // Past events
        Event::factory()->past()->count(3)->create([
            'user_id' => $demoUser->id,
            'saved_card_id' => $allContacts->random()->id,
        ]);

        // Today's events
        Event::factory()->today()->create([
            'user_id' => $demoUser->id,
            'title' => 'Team standup',
            'type' => 'meeting',
            'color' => '#3B82F6',
        ]);
        Event::factory()->today()->create([
            'user_id' => $demoUser->id,
            'title' => 'Client call - Project update',
            'type' => 'call',
            'color' => '#10B981',
            'saved_card_id' => $allContacts->random()->id,
        ]);
        Event::factory()->today()->create([
            'user_id' => $demoUser->id,
            'title' => 'Review proposals',
            'type' => 'task',
            'color' => '#8B5CF6',
        ]);

        // Upcoming events
        Event::factory()->upcoming()->count(5)->create([
            'user_id' => $demoUser->id,
        ]);
        Event::factory()->upcoming()->count(4)->create([
            'user_id' => $demoUser->id,
            'saved_card_id' => $allContacts->random()->id,
        ]);

        // --- Admin User ---
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@bsncard.app',
            'subscription_tier' => 'business',
            'is_admin' => true,
            'status' => 'active',
        ]);

        // --- Sample Support Tickets ---
        // Resolved ticket with messages
        $resolvedTicket = SupportTicket::create([
            'user_id' => $demoUser->id,
            'subject' => 'Cannot upload profile photo',
            'status' => 'resolved',
            'priority' => 'medium',
            'category' => 'bug',
        ]);
        TicketMessage::create([
            'support_ticket_id' => $resolvedTicket->id,
            'user_id' => $demoUser->id,
            'message' => 'I keep getting an error when trying to upload a profile photo to my business card. The file is a PNG under 2MB.',
            'is_admin_reply' => false,
        ]);
        TicketMessage::create([
            'support_ticket_id' => $resolvedTicket->id,
            'user_id' => $adminUser->id,
            'message' => 'Thanks for reporting this! We identified the issue and deployed a fix. Please try uploading again and let us know if it works.',
            'is_admin_reply' => true,
        ]);
        TicketMessage::create([
            'support_ticket_id' => $resolvedTicket->id,
            'user_id' => $demoUser->id,
            'message' => 'Works perfectly now. Thank you!',
            'is_admin_reply' => false,
        ]);

        // Open ticket
        $openTicket = SupportTicket::create([
            'user_id' => $demoUser->id,
            'subject' => 'How do I upgrade to Pro plan?',
            'status' => 'open',
            'priority' => 'low',
            'category' => 'billing',
        ]);
        TicketMessage::create([
            'support_ticket_id' => $openTicket->id,
            'user_id' => $demoUser->id,
            'message' => 'I would like to upgrade my account to the Pro plan. Can you walk me through the process?',
            'is_admin_reply' => false,
        ]);

        // --- Sample Contact Submissions ---
        ContactSubmission::create([
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'subject' => 'Partnership Inquiry',
            'message' => 'Hi, I represent a tech conference and would love to discuss a potential partnership with BsnCard for our upcoming event. We have 500+ attendees and think digital business cards would be a great fit.',
            'is_read' => true,
        ]);
        ContactSubmission::create([
            'name' => 'Maria Garcia',
            'email' => 'maria.g@example.com',
            'subject' => 'Enterprise pricing question',
            'message' => 'Hello, we are a company of 50 employees and are interested in your Business plan. Do you offer any volume discounts for larger teams?',
            'is_read' => false,
        ]);
    }
}
