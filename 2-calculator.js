function compute_days() {
    const dobString = get_dob(); // Get the date of birth string (e.g., "2005-10-03")

    // If no date is selected, show an error and stop.
    if (!dobString) {
        write_answer_days("Please select your date of birth first!");
        return;
    }

    const dob = new Date(dobString); // Convert the string into a Date object
    const today = new Date(); // Get the current date

    // Calculate the difference in milliseconds between today and the date of birth
    const diffTime = today.getTime() - dob.getTime();

    // Convert milliseconds to days (1000ms * 60s * 60min * 24hr)
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

    // Display the final answer
    write_answer_days(`You are approximately ${diffDays} days old.`);
}

function compute_circle() {
    const screen = get_screen_dims(); // Get an object with screen width and height

    // The biggest circle that fits must have a diameter equal to the smaller screen dimension
    const smaller_dim = Math.min(screen.width, screen.height);

    // The radius is half of the diameter
    const radius = smaller_dim / 2;

    // The area of a circle is Pi * r^2
    const area = Math.PI * Math.pow(radius, 2);

    // Display the results, rounded to two decimal places
    write_answer_circle(
        `The biggest circle that fits on your screen has a radius of ${radius.toFixed(2)}px and an area of ${area.toFixed(2)}px².`
    );
}

function check_palindrome() {
    const text_input = get_palindrome(); // Get the text from the input field

    // Prepare the string for checking:
    // 1. Convert to lowercase to ignore case (e.g., 'Racecar' and 'racecar' are the same)
    // 2. Remove all spaces and non-alphanumeric characters for a fair comparison (e.g., "A man, a plan, a canal: Panama")
    const cleaned_text = text_input.toLowerCase().replace(/[\W_]/g, '');

    // If the cleaned string is empty, it can be considered a palindrome.
    if (cleaned_text.length === 0) {
        write_answer_palindrome(`"${text_input}" is a palindrome!`);
        return;
    }

    let isPalindrome = true; // Assume it's a palindrome until proven otherwise

    // Loop through the first half of the string
    for (let i = 0; i < cleaned_text.length / 2; i++) {
        // Compare the character at the start (i) with the character at the end (length - 1 - i)
        if (cleaned_text[i] !== cleaned_text[cleaned_text.length - 1 - i]) {
            isPalindrome = false; // If they don't match, it's not a palindrome
            break; // Exit the loop since we found a mismatch
        }
    }

    // Display the final result based on the isPalindrome variable
    if (isPalindrome) {
        write_answer_palindrome(`Yes, "${text_input}" is a palindrome!`);
    } else {
        write_answer_palindrome(`No, "${text_input}" is not a palindrome.`);
    }
}

function create_fibo() {
    // Get the user's desired length from the input field and convert it to an integer
    const fibo_length = parseInt(document.getElementById("fibo_length").value);

    // Handle invalid inputs (negative numbers or not a number)
    if (isNaN(fibo_length) || fibo_length < 0) {
        write_answer_fibo("Please enter a valid non-negative number.");
        return;
    }

    // Handle edge cases for 0 and 1
    if (fibo_length === 0) {
        write_answer_fibo("The sequence is empty.");
        return;
    }
    if (fibo_length === 1) {
        write_answer_fibo("The sequence is: 0");
        return;
    }

    // Initialize the Fibonacci sequence with the first two numbers
    let fibo_sequence = [0, 1];

    // Loop to generate the rest of the sequence up to the desired length
    // We start at i=2 because we already have the first two elements (at index 0 and 1)
    for (let i = 2; i < fibo_length; i++) {
        // The next number is the sum of the previous two
        const next_number = fibo_sequence[i - 1] + fibo_sequence[i - 2];
        fibo_sequence.push(next_number); // Add the new number to the array
    }

    // Display the final sequence by joining the array elements with a comma and space
    write_answer_fibo("The sequence is: " + fibo_sequence.join(", "));
}