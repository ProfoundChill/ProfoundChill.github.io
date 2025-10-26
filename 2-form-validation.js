// Part 3: Function to validate the form inputs [cite: 119]
function validate(event) {
    // 3a: Prevent the form from submitting by default, so we can run our checks first [cite: 125]
    event.preventDefault(); 

    // Get the input elements
    const nameInput = document.getElementById("user-name");
    const emailInput = document.getElementById("user-email");

    // Get the trimmed values
    const nameValue = nameInput.value.trim();
    const emailValue = emailInput.value.trim();
    
    let isValid = true; // Flag to track validation status

    // 2: Check that the name is not empty [cite: 121]
    if (nameValue === "") {
        alert("The Name field cannot be empty. Please enter your name!");
        nameInput.focus(); // Focus on the empty field for the user
        isValid = false;
    } 
    
    // 2: Check that the email is not empty [cite: 121]
    if (emailValue === "") {
        alert("The Email field cannot be empty. Please enter your email address!");
        // We only focus if the name was already valid, otherwise keep focus on name
        if (isValid) { 
             emailInput.focus();
        }
        isValid = false;
    }
    
    // 3b: If isValid is true, allow the form to submit (return true). 
    // If it's false, the form submission is blocked, and the data is preserved[cite: 126, 123].
    // Since we used event.preventDefault() at the top, we just return the boolean value.
    if (isValid) {
        // Example: If valid, you might do something here before allowing submission:
        alert("Form is valid! (In a real scenario, this would now send data to the server.)");
        // To truly allow the submission to continue after preventDefault, you'd typically 
        // use form.submit() after all checks, but for this lab's requirement of returning 
        // true/false with onsubmit="return validate()", we keep the return statement.
        return true; 
    } else {
        return false;
    }
}