// ItemGroup prototype to represent a group of the same item
// name: The name of the item (e.g., "pants")
// price: The cost per single item (e.g., 10.05)
// count: The number of items in the group (e.g., 15)
function ItemGroup(name, price, count) {
    this.name = name;       // Store the item's name
    this.price = price;     // Store the item's price
    this.count = count;     // Store the quantity of the item
}

function Cart() {
    this.itemGroups = []; // An array to hold all the item groups in the cart

    // Method to add an ItemGroup to the cart's list
    this.addItemGroup = function(itemGroup) {
        this.itemGroups.push(itemGroup); // 'push' adds the new itemGroup to the end of the array
    };

    // Method to calculate the total cost of all items before tax
    this.getTotalAmount = function() {
        let totalAmount = 0; // Initialized a variable to hold the total, starting at 0

        // Loop through each itemGroup in the itemGroups array
        for (let i = 0; i < this.itemGroups.length; i++) {
            // For each group, multiply its price by its count and add to the total
            totalAmount += this.itemGroups[i].price * this.itemGroups[i].count;
        }
        return totalAmount; // Return the final calculated total
    };

    this.showTotalAmount = function() {
        if (this.itemGroups.length === 0) {
            document.write("<p>You have 0 items, for a total amount of 0$, in your cart!</p>");
        } else {
            // This is the section you needed to code.
            const total = this.getTotalAmount(); // Get the total amount before taxes
            const taxes = total * 0.15; // Calculate 15% tax
            const totalWithTaxes = total + taxes; // Add taxes to the total

            // Display the final message with the number of item groups and formatted prices
            // .toFixed(2) ensures the money values are shown with exactly two decimal places
            document.write(
                `<p>You have ${this.itemGroups.length} item group(s) in your cart, for a total amount of ${total.toFixed(2)}$. With taxes, this is ${totalWithTaxes.toFixed(2)}$.</p>`
            );
        }
    };
}

document.write("<h2> 1) Creating the cart </h2>");
let my_cart = new Cart();
my_cart.showTotalAmount();

document.write("<h2> 2) Adding 15 pants at 10.05$ each to the cart! </h2>");
let pants = new ItemGroup("pants", 10.05, 15);
my_cart.addItemGroup(pants);
my_cart.showTotalAmount();

document.write("<h2> 3) Adding 1 coat at 99.99$ to the cart! </h2>");
// Corrected the item name from "pants" to "coat" for clarity
let coat = new ItemGroup("coat", 99.99, 1);
my_cart.addItemGroup(coat);
my_cart.showTotalAmount();