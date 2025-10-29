// Part 1: Function to clean up the path to be relative and consistent
// This prevents comparison errors between absolute and relative paths [cite: 62]
function splitAtRoot (path) {
    const url = new URL(path, location.origin);
    const pathFromRoot = url.pathname;
    // You can uncomment this line for debugging the path:
    // document.write("<br>----> path from root: " + pathFromRoot); [cite: 65]
    return pathFromRoot;
}

// Part 1: Main function to set the navigation menu content and highlight the current page [cite: 54]
function setNav (current_path) {
    // 6d: Apply splitAtRoot to the path received [cite: 69]
    current_path = splitAtRoot(current_path);

    // 3: Fetch the content of nav.html [cite: 32]
    fetch("nav.html")
    .then(r => r.text()) // 3: Read the file's content as text [cite: 39]
    .then(html => {
        // 4: Find the nav element and set its innerHTML to the content of nav.html [cite: 42]
        const nav = document.getElementById("main-nav");
        nav.innerHTML = html; 

        // 6e: Loop through all children of the inserted navigation (i.e., the anchor <a> tags) [cite: 70, 76]
        for (let child of nav.children) {
            // 6e: Ensure the child is an anchor element [cite: 77]
            if (child instanceof HTMLAnchorElement) {
                // Get the cleaned path of the link's destination (child.href) [cite: 72]
                const child_path = splitAtRoot(child.href);
                
                // 6f: Compare the link's path with the current page's path
                if (child_path === current_path) {
                    // 6f: Add the highlight class if they match [cite: 74]
                    child.classList.add("current-page");
                }
            }
        }
    });
}

// 6b: Code to get the current path automatically and call setNav when the script loads [cite: 59, 60]
const current_path = location.pathname; 
setNav(current_path);