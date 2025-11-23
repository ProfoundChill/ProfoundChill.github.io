// --- Global Variable for Local Storage ---
// 1. Load saved items from localStorage or start with an empty array [cite: 142]
let items = JSON.parse(localStorage.getItem("items")) || []; 

// Call renderList() to display any saved items immediately upon page load [cite: 143]
renderList(); 

// 5. Function called when the "Add Item" button is clicked 
function addItem() {
    // 5a. Recover the text from the user input [cite: 91]
    const inputElement = document.getElementById("todo-input");
    const item_text = inputElement.value.trim(); 

    // If the input is empty, send a warning [cite: 91]
    if (item_text === "") {
        alert("Please enter a valid to-do item!");
        return; 
    }

    // 2. Save in storage [cite: 146]
    const newItem = {
        text: item_text, // The text of the new item [cite: 149]
        id: Date.now() // Unique timestamp-based ID [cite: 150]
    };
    items.push(newItem); // Add new item to the local array [cite: 151]
    localStorage.setItem("items", JSON.stringify(items)); // Save the updated array to storage [cite: 152]

    // 5b. Call the RenderItem function [cite: 92]
    renderItem(item_text, newItem.id);

    // Clear the input field
    inputElement.value = '';
}

// 3. Function to display all saved items [cite: 154]
function renderList() {
    // Clear the existing list contents first
    const listContainer = document.getElementById("todo-list-container");
    listContainer.innerHTML = ''; 

    // Loop through the global 'items' array [cite: 155]
    items.forEach((item) => {
        // Render each item, passing its text and ID [cite: 158]
        renderItem(item.text, item.id); 
    });
}

// 6. Function to create the <li> element and add it to the list [cite: 93]
// 4a. Now accepts an 'id' argument [cite: 160]
function renderItem(item_text, id) {
    // 6a. Recover the ul element
    const listContainer = document.getElementById("todo-list-container");

    // 6b. Create a new li element [cite: 95]
    const listItem = document.createElement("li");

    // 4b. Store the unique ID in the DOM for deletion reference [cite: 162]
    listItem.dataset.id = id;

    // 1a. Create a span for the text content [cite: 108]
    const textSpan = document.createElement("span");
    // 1b. Set its text content (using textContent for safety) [cite: 109, 99, 100]
    textSpan.textContent = item_text; 
    // 1c. Add the span as a child of the <li> [cite: 110]
    listItem.appendChild(textSpan);

    // 2. Create the trash icon span [cite: 111]
    const trashSpan = document.createElement("span");
    // 2b. Add Font Awesome classes to make it look like a trash can [cite: 116, 117]
    trashSpan.classList.add('fas', 'fa-trash');

    // 3. Add an event listener to the garbage can [cite: 119]
    trashSpan.addEventListener("click", () => {
        // Get the id stored in the parent <li> element
        const itemIdToDelete = parseInt(listItem.dataset.id); 

        // 5. Delete the item from the global 'items' array [cite: 164]
        items = items.filter(x => x.id !== itemIdToDelete); 

        // 5. Update localStorage with the new, shorter array [cite: 166]
        localStorage.setItem("items", JSON.stringify(items)); 

        // 3. Remove the <li> element from the DOM [cite: 122]
        listItem.remove();
    });

    // 2c. Add the trash span as a child of the <li> [cite: 118]
    listItem.appendChild(trashSpan);

    // 6d. Append the <li> as a child of the <ul> [cite: 101]
    listContainer.appendChild(listItem); 
}