<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Discounts and Promotions</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <header>
    <h1>Shop Smart: See Your Discounts Instantly</h1>
  </header>
  <main>
    <section class="order-summary">
      <h2>Your Order</h2>

      <?php
      $items = [
        'shoes' => ['price' => 20, 'quantity' => $_POST['shoes_qty'] ?? 1],
        'pants' => ['price' => 100, 'quantity' => $_POST['pants_qty'] ?? 1],
      ];

      $subtotal = 0;
      $bulkDiscount = 0;
      $discountMessages = [];
      $discountApplied = false;

      foreach ($items as $key => &$item) {
        $item['subtotal'] = $item['price'] * $item['quantity'];

        if ($item['quantity'] >= 5) {
          $item['discount'] = $item['subtotal'] * 0.10;
          $item['subtotal_after_discount'] = $item['subtotal'] - $item['discount'];
          $discountMessages[] = "🎉 10% Discount Applied to " . ucfirst($key) . "!";
          $discountApplied = true;
        } else {
          $item['discount'] = 0;
          $item['subtotal_after_discount'] = $item['subtotal'];
        }

        $subtotal += $item['subtotal_after_discount'];
      }

      if ($subtotal > 500) {
        $bulkDiscount = $subtotal * 0.05;
        $subtotal -= $bulkDiscount;
        $discountMessages[] = '🎉 5% Bulk Order Discount Applied!';
        $discountApplied = true;
      }

      $finalTotal = $subtotal;
      ?>
      <form method="POST" action="">
        <!-- Shoes -->
        <div class="cart-item">
          <div class="item-details">
            <img src="images/jordan.png" alt="Shoes" class="item-image" />
            <div>
              <div class="item-name">Shoes 
                <span class="discount-badge" data-item="shoes" style="<?= $items['shoes']['discount'] > 0 ? '' : 'display:none;' ?>">-10%</span>
              </div>
              <div class="item-price">₱<?= number_format($items['shoes']['price'], 2) ?> each</div>
            </div>
          </div>
          <input type="number" name="shoes_qty" id="shoes_qty" value="<?= $items['shoes']['quantity'] ?>" min="1" class="item-quantity">
          <div style="text-align: right;">
            <div class="item-subtotal">₱<?= number_format($items['shoes']['subtotal_after_discount'], 2) ?></div>
            <?php if ($items['shoes']['discount'] > 0): ?>
              <div class="discount-amount">Saved: ₱<?= number_format($items['shoes']['discount'], 2) ?></div>
            <?php endif; ?>
            <div id="shoes-discount-percent" style="font-size:0.9rem;color:#4CAF50;">Discount: <?= $items['shoes']['quantity'] >= 5 ? '10%' : '0%' ?></div>
          </div>
        </div>

        <!-- Pants -->
        <div class="cart-item">
          <div class="item-details">
            <img src="images/pants.png" alt="Pants" class="item-image" />
            <div>
              <div class="item-name">Pants 
                <span class="discount-badge" data-item="pants" style="<?= $items['pants']['discount'] > 0 ? '' : 'display:none;' ?>">-10%</span>
              </div>
              <div class="item-price">₱<?= number_format($items['pants']['price'], 2) ?> each</div>
            </div>
          </div>
          <input type="number" name="pants_qty" id="pants_qty" value="<?= $items['pants']['quantity'] ?>" min="1" class="item-quantity">
          <div style="text-align: right;">
            <div class="item-subtotal">₱<?= number_format($items['pants']['subtotal_after_discount'], 2) ?></div>
            <?php if ($items['pants']['discount'] > 0): ?>
              <div class="discount-amount">Saved: ₱<?= number_format($items['pants']['discount'], 2) ?></div>
            <?php endif; ?>
            <div id="pants-discount-percent" style="font-size:0.9rem;color:#4CAF50;">Discount: <?= $items['pants']['quantity'] >= 5 ? '10%' : '0%' ?></div>
          </div>
        </div>

        <!-- Summary -->
        <div class="summary-section">
          <div class="summary-row">
            <span>Subtotal (before item discounts):</span>
            <span id="original-subtotal">₱<?= number_format($items['shoes']['subtotal'] + $items['pants']['subtotal'], 2) ?></span>
          </div>
          <div class="summary-row">
            <span>Item Discounts:</span>
            <span id="item-discounts">-₱<?= number_format($items['shoes']['discount'] + $items['pants']['discount'], 2) ?></span>
          </div>
          <div class="summary-row subtotal-before-tax">
            <span>Subtotal Before Tax:</span>
            <span id="subtotal-before-tax">₱<?= number_format($items['shoes']['subtotal_after_discount'] + $items['pants']['subtotal_after_discount'], 2) ?></span>
          </div>
          <div class="summary-row">
            <span>Bulk Order Discount (5%):</span>
            <span id="bulk-discount">-₱<?= number_format($bulkDiscount, 2) ?></span>
          </div>
          <div class="summary-row total">
            <span>Grand Total:</span>
            <span id="grand-total">₱<?= number_format($finalTotal, 2) ?></span>
          </div>
        </div>

        <!-- Discount messages -->
        <?php if (!empty($discountMessages)): ?>
        <div class="discount-messages" id="discount-messages">
          <?php foreach ($discountMessages as $msg): ?>
            <p><?= $msg ?></p>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="discount-messages" id="discount-messages" style="display:none;"></div>
        <?php endif; ?>

        <section class="actions">
<button type="button" id="apply-discounts" onclick="checkDiscounts()">Apply Discounts</button>
          <button type="button" id="reload-page" onclick="window.location.href = window.location.pathname;">Reload</button>
        </section>
      </form>
    </section>
  </main>


  <footer>
    <p>&copy; 2025 Your E-commerce Site</p>
  </footer>
  <script src="script.js">

  </script>
</body>
</html>
