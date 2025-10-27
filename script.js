function checkDiscounts() {
  const shoesQty = parseInt(document.getElementById('shoes_qty').value) || 1;
  const pantsQty = parseInt(document.getElementById('pants_qty').value) || 1;

  let discountMessages = [];

  if (shoesQty >= 5) {
    discountMessages.push("🎉 10% Discount Applied to Shoes!");
  } else {
    discountMessages.push("⚠️ No discount for Shoes (need at least 5).");
  }

  if (pantsQty >= 5) {
    discountMessages.push("🎉 10% Discount Applied to Pants!");
  } else {
    discountMessages.push("⚠️ No discount for Pants (need at least 5).");
  }

  // If both are below 5, show a simpler message
  if (shoesQty < 5 && pantsQty < 5) {
    alert("No discounts applied. Buy at least 5 items to get 10% off!");
  } else {
    alert(discountMessages.join("\n"));
  }
}

// JS live calculator (client-side preview)
document.addEventListener("DOMContentLoaded", () => {
  const shoesPrice = 20;
  const pantsPrice = 100;

  function calculateOrder() {
    const shoesQty = parseInt(document.getElementById('shoes_qty').value) || 1;
    const pantsQty = parseInt(document.getElementById('pants_qty').value) || 1;

    let shoesSubtotal = shoesPrice * shoesQty;
    let pantsSubtotal = pantsPrice * pantsQty;

    let shoesDiscount = 0;
    let pantsDiscount = 0;
    let discountMessages = [];

    // 🥿 SHOES discount
    if (shoesQty >= 5) {
      shoesDiscount = shoesSubtotal * 0.10;
      discountMessages.push(`🎉 10% Discount Applied to Shoes!`);
      document.querySelector('.discount-badge[data-item="shoes"]').style.display = 'inline-block';
    } else {
      document.querySelector('.discount-badge[data-item="shoes"]').style.display = 'none';
    }

    // 👖 PANTS discount
    if (pantsQty >= 5) {
      pantsDiscount = pantsSubtotal * 0.10;
      discountMessages.push(`🎉 10% Discount Applied to Pants!`);
      document.querySelector('.discount-badge[data-item="pants"]').style.display = 'inline-block';
    } else {
      document.querySelector('.discount-badge[data-item="pants"]').style.display = 'none';
    }

    const originalSubtotal = shoesSubtotal + pantsSubtotal;
    const totalItemDiscounts = shoesDiscount + pantsDiscount;
    const subtotalBeforeTax = originalSubtotal - totalItemDiscounts;
    let bulkDiscount = 0;

    if (subtotalBeforeTax > 500) {
      bulkDiscount = subtotalBeforeTax * 0.05;
      discountMessages.push("🎉 5% Bulk Order Discount Applied!");
    }

    const grandTotal = subtotalBeforeTax - bulkDiscount;

    // Update DOM totals
    document.getElementById('original-subtotal').textContent = '₱' + originalSubtotal.toFixed(2);
    document.getElementById('item-discounts').textContent = '-₱' + totalItemDiscounts.toFixed(2);
    document.getElementById('subtotal-before-tax').textContent = '₱' + subtotalBeforeTax.toFixed(2);
    document.getElementById('bulk-discount').textContent = '-₱' + bulkDiscount.toFixed(2);
    document.getElementById('grand-total').textContent = '₱' + grandTotal.toFixed(2);

    // 🧮 Update individual item discount info
    const shoesDiscountPercent = shoesQty >= 5 ? '10%' : '0%';
    const pantsDiscountPercent = pantsQty >= 5 ? '10%' : '0%';
    document.getElementById('shoes-discount-percent').textContent = `Discount: ${shoesDiscountPercent}`;
    document.getElementById('pants-discount-percent').textContent = `Discount: ${pantsDiscountPercent}`;

    // Show messages
    const messagesDiv = document.getElementById('discount-messages');
    if (discountMessages.length > 0) {
      messagesDiv.innerHTML = discountMessages.map(msg => `<p>${msg}</p>`).join('');
      messagesDiv.style.display = 'block';
    } else {
      messagesDiv.style.display = 'none';
    }
  }

  document.getElementById('shoes_qty').addEventListener('input', calculateOrder);
  document.getElementById('pants_qty').addEventListener('input', calculateOrder);
});
