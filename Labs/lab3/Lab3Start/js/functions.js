/* Suren Kulasegaram, 101220595 */
/* My prettier formatter extension auto formatted any file I opened */

function calculateTotal(quantity, price) {
  return quantity * price;
}

function outputCartRow(file, title, quantity, price, total) {
  document.write("<tr>");
  document.write('<td><img src="images/' + file + '"></td>');
  document.write("<td>" + title + "</td>");
  document.write("<td>" + quantity + "</td>");
  document.write("<td>$" + price.toFixed(2) + "</td>");
  document.write("<td>$" + total.toFixed(2) + "</td>");
  document.write("</tr>");
}

function outputTotals(subtotal, tax, shipping, grandTotal) {
  document.write('<tr class="totals">');
  document.write('<td colspan="4">Subtotal</td>');
  document.write("<td>$" + subtotal.toFixed(2) + "</td>");
  document.write("</tr>");
  document.write('<tr class="totals">');
  document.write('<td colspan="4">Tax</td>');
  document.write("<td>$" + tax.toFixed(2) + "</td>");
  document.write("</tr>");
  document.write('<tr class="totals">');
  document.write('<td colspan="4">Shipping</td>');
  document.write("<td>$" + shipping.toFixed(2) + "</td>");
  document.write("</tr>");
  document.write('<tr class="totals focus">');
  document.write('<td colspan="4">Grand Total</td>');
  document.write("<td>$" + grandTotal.toFixed(2) + "</td>");
  document.write("</tr>");
}
