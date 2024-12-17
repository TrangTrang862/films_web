<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SimilarityController extends Controller
{
    public function calculateAllSimilarities()
    {
        $preferences = [
            'User1' => ['Movie1', 'Movie2', 'Movie3'],
            'User2' => ['Movie2', 'Movie3', 'Movie4'],
            'User3' => ['Movie1', 'Movie4'],
            'User4' => ['Movie1', 'Movie2', 'Movie4', 'Movie5'],
            'User5' => ['Movie1', 'Movie5'],
        ];

        // Function to calculate similarity
        function similarity($user1, $user2)
        {
            $common = array_intersect($user1, $user2);
            $union = array_unique(array_merge($user1, $user2));

            return count($common) / count($union);
        }

        // Recommend items
        function recommend($user, $preferences)
        {
            $userItems = $preferences[$user];
            $scores = [];

            foreach ($preferences as $otherUser => $otherItems) {
                if ($user === $otherUser) continue;

                $similarity = similarity($userItems, $otherItems);
                foreach ($otherItems as $item) {
                    if (!in_array($item, $userItems)) {
                        if (!isset($scores[$item])) {
                            $scores[$item] = 0;
                        }
                        $scores[$item] += $similarity;
                    }
                }
            }

            arsort($scores); // Sort by score descending
            return array_keys($scores);
        }

        // Get recommendations for User3
        $recommendations = recommend('User3', $preferences);

        return ($recommendations);
    }
}
