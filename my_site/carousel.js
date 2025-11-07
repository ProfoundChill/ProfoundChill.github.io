// Part 2: Image Carousel Logic

let current_slide = 0; // 6a. Variable to track the current slide index, starting at 0
showSlide(current_slide); // Display first slide on load
 
function showSlide(n) {
    // 7a. Get all elements with the class "slideshow_img"
    let slides = document.getElementsByClassName("slideshow_img"); 

    // Handle wrap-around logic (10. What happens when index goes out of bounds?)
    if (n >= slides.length) { 
        current_slide = 0; // Loop back to the first slide
    } 
    else if (n < 0) { 
        current_slide = slides.length - 1; // Jump to the last slide
    }

    // 7b. Loop through all images and hide them
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // hide it [cite: 327]
    }

    // 7b. Show the current slide
    slides[current_slide].style.display = "block"; // show it [cite: 328]
}

function next() {
    // 8. Increase the current slide index by 1 and show it [cite: 329]
    current_slide++; 
    showSlide(current_slide);
}

function previous() {
    // 9. Decrease the current slide index by 1 and show it [cite: 330]
    current_slide--; 
    showSlide(current_slide);
}
