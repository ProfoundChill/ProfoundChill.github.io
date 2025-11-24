<html>
<head>
    <title>Oliver's Artistic Self</title> 
    <meta charset="UTF-8">
    <meta name="author" content="Oliver Raga">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="my_style.css">
    
    
    <style>
        /* Begins the CSS styling section */
        
        /* Styles for the body element (the entire page) */
        body {
            background-image: url('https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800');
            /* Sets a background image from Unsplash */
            background-size: cover;
            /* Makes the background image cover the entire viewport */
            background-repeat: no-repeat;
            /* Prevents the background image from repeating */
            background-position: center;
            /* Centers the background image */
            background-attachment: fixed;
            /* Fixes the background image so it doesn't scroll with the page */
            margin: 0;
            /* Removes default margin around the body */
            padding: 20px;
            /* Adds 20px of padding inside the body */
            font-family: Arial, sans-serif;
            /* Sets the default font family */
            min-height: 100vh;
            /* Ensures the body takes at least the full viewport height */
        }
        
        /* Styles for all h1 headings */
        h1 {
            color: white;
            /* Sets text color to white */
            text-align: center;
            /* Centers the text horizontally */
            background-color: rgba(0, 0, 0, 0.7);
            /* Sets a semi-transparent black background */
            padding: 20px;
            /* Adds 20px of padding inside the heading */
            border-radius: 10px;
            /* Rounds the corners of the heading */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            /* Adds a shadow effect to the text */
        }
        
        /* Styles for elements with the class "keyword" */
        .keyword {
            font-family: 'Courier New', monospace;
            /* Uses a monospace font for keywords */
            background-color: rgba(255, 255, 255, 0.9);
            /* Sets a semi-transparent white background */
            padding: 15px;
            /* Adds 15px of padding inside each keyword element */
            margin: 10px;
            /* Adds 10px of margin around each keyword element */
            border-radius: 8px;
            /* Rounds the corners of the keyword boxes */
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            /* Adds a subtle shadow effect */
        }
        
        /* Specific styles for the element with id "adventure" */
        #adventure {
            font-size: 28px;
            /* Sets a larger font size */
            color: #FF6B35;
            /* Sets a specific orange color */
            transform: rotate(-5deg);
            /* Rotates the element slightly counter-clockwise */
            position: relative;
            /* Positions the element relative to its normal position */
            left: 50px;
            /* Moves the element 50px to the right from its normal position */
        }
        
        /* Specific styles for the element with id "technology" */
        #technology {
            font-size: 24px;
            /* Sets a medium font size */
            color: #004E89;
            /* Sets a specific blue color */
            text-align: center;
            /* Centers the text */
            font-weight: bold;
            /* Makes the text bold */
        }
        
        /* Specific styles for the element with id "curious" */
        #curious {
            font-size: 20px;
            /* Sets a standard font size */
            color: #9A031E;
            /* Sets a specific red color */
            transform: rotate(3deg);
            /* Rotates the element slightly clockwise */
            position: relative;
            /* Positions the element relative to its normal position */
            right: 30px;
            /* Moves the element 30px to the left from its normal position */
        }
        
        /* Specific styles for the element with id "creative" */
        #creative {
            font-size: 32px;
            /* Sets a large font size */
            color: #7209B7;
            /* Sets a specific purple color */
            text-align: right;
            /* Aligns the text to the right */
            font-style: italic;
            /* Makes the text italic */
        }
        
        /* Specific styles for the element with id "global" */
        #global {
            font-size: 26px;
            /* Sets a medium-large font size */
            color: #F18F01;
            /* Sets a specific orange color */
            text-align: center;
            /* Centers the text */
            transform: rotate(-2deg);
            /* Rotates the element slightly counter-clockwise */
            text-decoration: underline;
            /* Underlines the text */
        }
        
        /* Styles for elements with the class "explanation" */
        .explanation {
            background-color: rgba(255, 255, 255, 0.95);
            /* Sets a nearly opaque white background */
            padding: 20px;
            /* Adds 20px of padding inside the element */
            border-radius: 10px;
            /* Rounds the corners */
            margin: 30px auto;
            /* Adds 30px margin top/bottom and centers horizontally */
            max-width: 600px;
            /* Limits the maximum width to 600px */
            color: #333;
            /* Sets a dark gray text color */
            font-size: 16px;
            /* Sets a standard font size */
            line-height: 1.6;
            /* Increases line spacing for better readability */
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            /* Adds a shadow effect */
        }
        
        /* Styles for elements with the class "home-link" */
        .home-link {
            display: block;
            /* Makes the link a block-level element (takes full width) */
            text-align: center;
            /* Centers the text inside the link */
            margin-top: 20px;
            /* Adds 20px of margin above the link */
            color: white;
            /* Sets text color to white */
            background-color: rgba(0, 0, 0, 0.8);
            /* Sets a semi-transparent black background */
            padding: 10px 20px;
            /* Adds 10px top/bottom and 20px left/right padding */
            text-decoration: none;
            /* Removes the default underline from the link */
            border-radius: 5px;
            /* Rounds the corners slightly */
            max-width: 200px;
            /* Limits the maximum width to 200px */
            margin: 20px auto;
            /* Adds 20px margin top/bottom and centers horizontally */
        }
        
        /* Styles for when the home-link is hovered over */
        .home-link:hover {
            background-color: rgba(0, 0, 0, 0.9);
            /* Darkens the background on hover */
        }
    </style>
    </head>

<body>
    <div class="body_wrapper">
        
    <?php
// The header includes the start of the HTML, the CSS links, and the theme.js script.
require_once 'header.php'; 
// Any other necessary includes or page-specific logic here...
?>
        <?php require_once 'nav.php'; ?>
       
        <h1>My Artistic Self</h1>
        <p class="keyword" id="adventure">Adventure</p> <p class="keyword" id="technology">Technology</p>
        <p class="keyword" id="curious">Curiousity</p>
        <p class="keyword" id="creative">Creativity</p> 
        <p class="keyword" id="global">Global</p>
        
        <div class="explanation">
            <p>The background image represents the intersection of technology and art - the vibrant, flowing digital patterns mirror my passion for both coding and creative expression. The five keywords capture different aspects of my personality: my love for <strong>adventure</strong> through travel and new experiences, my dedication to <strong>technology</strong> and programming, my naturally <strong>curious</strong> mind that drives me to learn, my <strong>creative</strong> approach to problem-solving, and my <strong>global</strong> perspective shaped by living in Venezuela, Dubai, the US, and now Canada.</p>
        </div>
        
        <a class="home-link" href="index.php">Return to Home Page</a>
   