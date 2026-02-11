/* Suren Kulasegaram, 101220595 */
/* My prettier formatter extension auto formatted any file I opened */

let subtotal = 0;

for (let i = 0; i < filenames.length; i++) {
  var total = calculateTotal(quantities[i], prices[i]);
  subtotal += total;
  outputCartRow(filenames[i], titles[i], quantities[i], prices[i], total);
}

let tax = subtotal * 0.1;
let shipping = subtotal > 1000 ? 0 : 40;
let grandTotal = subtotal + tax + shipping;

outputTotals(subtotal, tax, shipping, grandTotal);
