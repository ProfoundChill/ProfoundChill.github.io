<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Quiz Form</title>
    <link rel="stylesheet" href="my_style.css">
    <script src="2-form-validation.js"></script> 
</head>
<body>
    <div class="body_wrapper">
        
        <?php require_once 'nav.php'; ?>

        <h1 class="form-title">Which Type Are You?</h1>

        <div class="form-content">
            
            <form id="quiz-form" action="quiz_verification.php" method="GET" onsubmit="return validate(event)"> 
                
                <fieldset>
                    <legend>Which type are you?</legend> 
                    
                    <label for="user-name">What is your name?</label>
                    <input type="text" id="user-name" name="userName" required><br><br>

                    <label for="user-email">What is your email?</label>
                    <input type="email" id="user-email" name="userEmail" required><br><br>

                    <p><strong>Question 1:</strong> If you had to choose a type of dessert that describes you what would it be?</p>
                    <input type="radio" id="q1-a" name="q1_dessert" value="a" required>
                    <label for="q1-a">Ice Cream (Energetic &amp; Fun).</label><br>
                    <input type="radio" id="q1-b" name="q1_dessert" value="b">
                    <label for="q1-b">Cake (Classic &amp; Reliable).</label><br>
                    <input type="radio" id="q1-c" name="q1_dessert" value="c">
                    <label for="q1-c">Donut (Simple &amp; Sweet).</label><br><br>

                    <p><strong>Question 2:</strong> What color are you feeling right now?</p>
                    <input type="radio" id="q2-red" name="q2_color" value="red" required>
                    <label for="q2-red">Red (Passionate &amp; Bold).</label><br>
                    <input type="radio" id="q2-blue" name="q2_color" value="blue">
                    <label for="q2-blue">Blue (Calm &amp; Stable).</label><br>
                    <input type="radio" id="q2-green" name="q2_color" value="green">
                    <label for="q2-green">Green (Relaxed &amp; Grounded).</label><br><br>
                    
                    <label for="q3-genre"><strong>Question 3:</strong> Which book genre do you prefer?</label><br>
                    <select id="q3-genre" name="q3_genre" required>
                        <option value="">--Please choose an option--</option>
                        <option value="fiction">Fiction</option>
                        <option value="nonfiction">Non-Fiction</option>
                        <option value="adventure">Adventure</option>
                        <option value="self_help">Self-Help</option>
                    </select><br><br>

                    <p><strong>Question 4:</strong> What is your favorite season?</p>
                    <input type="radio" id="q4-a" name="q4_activity" value="a" required>
                    <label for="q4-a">Summer (Beach, sun, and late nights).</label><br>
                    <input type="radio" id="q4-b" name="q4_activity" value="b">
                    <label for="q4-b">Winter (Snowboarding, hot chocolate, and fireplace).</label><br>
                    <input type="radio" id="q4-c" name="q4_activity" value="c">
                    <label for="q4-c">Fall (Crisp air, hoodies, and pumpkin spice).</label><br><br>
                    
                    <label for="q4-dream"><strong>Question 4:</strong> Describe your dream vacation in a few words:</label><br>
                    <textarea id="q4-dream" name="q4_dream" rows="3" required></textarea><br><br>

                    <label for="q5-pet"><strong>Question 5:</strong> What is your spirit animal?</label>
                    <select id="q5-pet" name="q5_pet" required>
                        <option value="">--Please choose an option--</option>
                        <option value="lion">Lion</option>
                        <option value="eagle">Eagle</option>
                        <option value="dolphin">Dolphin</option>
                        <option value="cat">Cat</option>
                    </select><br><br>

                    <input type="submit" value="Get My Score!" class="submit-button">

                </fieldset>
            </form>
        </div>
        
    </div>
    <?php require_once 'footer.php'; ?>
    <?php
// The header includes the start of the HTML, the CSS links, and the theme.js script.
require_once 'header.php'; 
// Any other necessary includes or page-specific logic here...
?>
</body>
</html>