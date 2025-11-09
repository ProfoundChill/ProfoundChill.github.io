<?php
// PHP Script: Part 2 - Handles the quiz submission, calculates score, and displays results.

// 1. Scoring Logic: Define results and ranges (Max score is 9)
$results = [
    // 0-3 points
    'SHY' => ['min' => 0, 'max' => 3, 'message' => "You are reserved, thoughtful, and value quiet time."],
    // 4-6 points
    'CHILL' => ['min' => 4, 'max' => 6, 'message' => "You are easy-going, balanced, and a reliable friend."],
    // 7-9 points
    'COOL' => ['min' => 7, 'max' => 10, 'message' => "You are energetic, social, and the life of the party!"],
];

$score = 0;
// Default to 'Guest' if userName is not set, and sanitize it for display (security best practice)
$userName = isset($_GET['userName']) ? htmlspecialchars($_GET['userName']) : 'Guest'; 
$error = "";

// 2. Improved Server-Side Validation: Check if all required fields are set and non-empty
// Check for all seven required fields: userName, userEmail, q1_dessert, q2_color, q4_activity, q4_dream, q5_pet
if (isset($_GET['userName'], $_GET['userEmail'], $_GET['q1_dessert'], $_GET['q2_color'], $_GET['q4_activity'], $_GET['q4_dream'], $_GET['q5_pet'])) {
    
    // Check for empty string submission on text/textarea fields (which 'isset' would pass)
    if (empty($_GET['userName']) || empty($_GET['userEmail']) || empty($_GET['q4_dream'])) {
        $error = "One or more required fields (Name, Email, or Dream Description) were submitted empty. Please go back and complete the form.";
    } else {
        // Validation Passed, proceed with scoring
        
        // Scoring map: Maps answer value (a, b, red, blue, etc.) to points
        $score_map = [
            'q1_dessert' => ['a' => 2, 'b' => 1, 'c' => 0], // e.g., Ice Cream (2 pts)
            'q2_color' => ['red' => 2, 'blue' => 1, 'green' => 0],
            'q4_activity' => ['a' => 2, 'b' => 0, 'c' => 1],
            'q5_pet' => ['lion' => 3, 'eagle' => 2, 'dolphin' => 1, 'cat' => 0],
        ];

        // 3. Score Calculation (using submitted keys to look up points)
        if (isset($score_map['q1_dessert'][$_GET['q1_dessert']])) {
            $score += $score_map['q1_dessert'][$_GET['q1_dessert']];
        }

        if (isset($score_map['q2_color'][$_GET['q2_color']])) {
            $score += $score_map['q2_color'][$_GET['q2_color']];
        }

        if (isset($score_map['q4_activity'][$_GET['q4_activity']])) {
            $score += $score_map['q4_activity'][$_GET['q4_activity']];
        }

        if (isset($score_map['q5_pet'][$_GET['q5_pet']])) {
            $score += $score_map['q5_pet'][$_GET['q5_pet']];
        }
        
        // 4. Determine User Type
        $user_type = 'SHY'; // Default to lowest
        $result_message = $results['SHY']['message'];
        
        foreach ($results as $type => $data) {
            if ($score >= $data['min'] && $score <= $data['max']) {
                $user_type = $type;
                $result_message = $data['message'];
                break;
            }
        }
    }
} else {
    // Error for when the form was not submitted correctly (e.g., user navigated here directly)
    $error = "The quiz form was not submitted correctly. Please go back and complete the form.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial="1.0">
    <title>Quiz Results</title>
    <link rel="stylesheet" href="my_style.css"> 
    <style>
        /* Highlight style for the result */
        .highlight {
            font-size: 1.5em;
            color: #9A031E; /* A strong color for emphasis */
            font-weight: bold;
            padding: 10px 20px;
            border: 3px solid #FFD700;
            display: inline-block;
            margin-top: 15px;
            background-color: #fff;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="body_wrapper">

        <?php require_once 'nav.php'; ?>

        <h1 class="form-title">Your Quiz Results, <?php echo $userName; ?>!</h1>

        <div class="form-content">
            
            <?php if (!empty($error)): ?>
                <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
            <?php else: ?>
                <h2>Based on your answers, your Personality Type is...</h2>
                
                <p class="highlight"><?php echo $user_type; ?></p>

                <p><?php echo $result_message; ?></p>
                
                <p>Your total score was: **<?php echo $score; ?>** points.</p>
                <hr>
                
                <h3>All Possible Results:</h3>
                <ul>
                    <?php foreach ($results as $type => $data): ?>
                        <li style="font-weight: <?php echo ($type === $user_type) ? 'bold; color: #9A031E;' : 'normal;'; ?>">
                            <?php echo $type; ?> (Score Range: <?php echo $data['min']; ?>-<?php echo $data['max']; ?>): <?php echo $data['message']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
    </div>
    <?php require_once 'footer.php'; ?>