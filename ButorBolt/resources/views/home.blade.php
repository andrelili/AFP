{{-- resources/views/home.blade.php (Kis projekt / Prototípus) --}}
<!doctype html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ButorBolt – Kezdőlap (Prototípus)</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    :root{--bb-primary:#0d6efd;--bb-dark:#20242a}
    body{background:#fff}
    .bb-shadow{box-shadow:0 8px 24px rgba(20,24,31,.08)}
    .product-card{transition:transform .2s ease,box-shadow .2s ease}
    .product-card:hover{transform:translateY(-4px);box-shadow:0 16px 32px rgba(20,24,31,.14)}
    .price{font-weight:600}
    .qty-input{width:64px}
    .offcanvas-header .badge{font-size:.8rem}
    .card-img-top {
      width: 100%;
      aspect-ratio: 16 / 9;
      object-fit: cover;
      display: block;
        }

  </style>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-white sticky-top bb-shadow">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/">ButorBolt <span class="text-primary">Prototípus</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
          <li class="nav-item me-2"><a class="nav-link" href="#termekek">Termékek</a></li>
          <li class="nav-item">
            <button class="btn btn-sm btn-primary position-relative" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas" aria-controls="cartCanvas">
              <i class="bi bi-cart3 me-1"></i> Kosár
              <span id="cartCount" class="badge bg-warning text-dark position-absolute top-0 start-100 translate-middle rounded-pill">0</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO rövid infóval -->
  <header class="py-5 bg-light border-bottom">
    <div class="container">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <h1 class="display-6 fw-bold mb-2">Stílusos bútorok – egyszerű prototípus kosárral</h1>
          <p class="text-secondary mb-0">Statikus terméklista + böngészőben tárolt kosár (hozzáadás, törlés, mennyiség). A <strong>„Rendelés leadása”</strong> csak bemutató, nincs adatbázis/kifizetés.</p>
        </div>
      </div>
    </div>
  </header>

  <!-- TERMÉKLISTA (STATIKUS) -->
  <main id="termekek" class="py-5">
    <div class="container">
      <div class="d-flex justify-content-between align-items-end mb-3">
        <h2 class="h4 fw-bold mb-0">Termékek</h2>
        <small class="text-secondary">Minta képek – cseréld saját fotókra</small>
      </div>

      @php

      @endphp

      <div class="row g-3 g-md-4">
        @foreach($products as $p)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 product-card border-0">
              <img src="{{ $p['img'] }}" class="card-img-top rounded-3" alt="{{ $p['name'] }}">
              <div class="card-body px-0">
                <h3 class="h6 mb-1">{{ $p['name'] }}</h3>
                <div class="d-flex align-items-center justify-content-between">
                  <div class="price">{{ number_format($p['price'], 0, ',', ' ') }} Ft</div>
                  <button class="btn btn-sm btn-primary" onclick="addToCart({{ $p['id'] }})"><i class="bi bi-cart-plus me-1"></i>Kosárba</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <script>window.PRODUCTS = @json($products);</script>
    </div>
  </main>

  <!-- KOSÁR OFFCANVAS -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas" aria-labelledby="cartCanvasLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="cartCanvasLabel"><i class="bi bi-cart3 me-2"></i>Kosár <span class="badge bg-secondary" id="cartItemsBadge">0 tétel</span></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Bezárás"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
      <div id="cartItems" class="vstack gap-3">
        <!-- Dinamikus kosár tételek ide -->
      </div>
      <div class="mt-auto pt-3 border-top">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span class="fw-semibold">Végösszeg:</span>
          <span class="fs-5 fw-bold" id="cartTotal">0 Ft</span>
        </div>
        <div class="d-grid gap-2">
          <button id="checkoutBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal" disabled><i class="bi bi-box-seam me-1"></i>Rendelés leadása</button>
          <button class="btn btn-outline-secondary" onclick="clearCart()"><i class="bi bi-trash3 me-1"></i>Kosár ürítése</button>
        </div>
      </div>
    </div>
  </div>

  <!-- RENDELÉS MODAL (prototípus) -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Rendelés leadása (prototípus)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bezárás"></button>
        </div>
        <div class="modal-body">
          <p class="text-secondary small mb-3">Ez csak bemutató. A rendelés <strong>nem mentődik</strong> el és <strong>nincs fizetés</strong>.</p>
          <div id="orderSummary" class="vstack gap-2"></div>
          <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
            <strong>Végösszeg:</strong>
            <strong id="orderTotal">0 Ft</strong>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Mégse</button>
          <button type="button" class="btn btn-primary" onclick="confirmOrder()"><i class="bi bi-check2-circle me-1"></i>Megerősítés</button>
        </div>
      </div>
    </div>
  </div>

  <footer class="border-top py-4 mt-5">
    <div class="container small text-secondary d-flex justify-content-between">
      <span>© {{ date('Y') }} ButorBolt – Prototípus</span>
      <span>DB nélkül • localStorage kosár</span>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // --- Kosár prototípus (localStorage) ---
    const CART_KEY = 'butorbolt_cart';
    const fmt = n => new Intl.NumberFormat('hu-HU').format(n) + ' Ft';

    function loadCart(){
      try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; } catch { return []; }
    }
    function saveCart(items){ localStorage.setItem(CART_KEY, JSON.stringify(items)); }

    function getProduct(id){ return (window.PRODUCTS || []).find(p => p.id === id); }

    function addToCart(id){
      const cart = loadCart();
      const idx = cart.findIndex(i => i.id === id);
      if(idx > -1){ cart[idx].qty += 1; }
      else { cart.push({ id, qty: 1 }); }
      saveCart(cart); renderCart();
    }

    function removeFromCart(id){
      const cart = loadCart().filter(i => i.id !== id);
      saveCart(cart); renderCart();
    }

    function changeQty(id, delta){
      const cart = loadCart();
      const idx = cart.findIndex(i => i.id === id);
      if(idx > -1){
        cart[idx].qty = Math.max(1, cart[idx].qty + delta);
        saveCart(cart); renderCart();
      }
    }

    function setQty(id, val){
      const cart = loadCart();
      const idx = cart.findIndex(i => i.id === id);
      if(idx > -1){
        const q = Math.max(1, parseInt(val||1,10));
        cart[idx].qty = q; saveCart(cart); renderCart();
      }
    }

    function clearCart(){ saveCart([]); renderCart(); }

    function totals(){
      const cart = loadCart();
      let total = 0, count = 0;
      cart.forEach(i => {
        const p = getProduct(i.id); if(!p) return; total += p.price * i.qty; count += i.qty;
      });
      return { total, count };
    }

    function renderCart(){
      const wrap = document.getElementById('cartItems');
      wrap.innerHTML = '';
      const cart = loadCart();
      const { total, count } = totals();

      document.getElementById('cartTotal').textContent = fmt(total);
      document.getElementById('cartCount').textContent = count;
      document.getElementById('cartItemsBadge').textContent = `${cart.length} tétel`;
      document.getElementById('checkoutBtn').disabled = cart.length === 0;

      cart.forEach(i => {
        const p = getProduct(i.id); if(!p) return;
        const div = document.createElement('div');
        div.className = 'd-flex align-items-center gap-2';
        div.innerHTML = `
          <img src="${p.img}" alt="${p.name}" class="rounded" style="width:56px;height:56px;object-fit:cover;">
          <div class="flex-grow-1">
            <div class="fw-semibold">${p.name}</div>
            <div class="text-secondary small">${fmt(p.price)} / db</div>
          </div>
          <div class="input-group input-group-sm" style="width: 128px;">
            <button class="btn btn-outline-secondary" type="button" aria-label="Mennyiség csökkentése" onclick="changeQty(${p.id}, -1)">-</button>
            <input class="form-control text-center" value="${i.qty}" oninput="setQty(${p.id}, this.value)" aria-label="Mennyiség">
            <button class="btn btn-outline-secondary" type="button" aria-label="Mennyiség növelése" onclick="changeQty(${p.id}, 1)">+</button>
          </div>
          <div class="text-end" style="width:110px;">
            <div class="fw-semibold">${fmt(p.price * i.qty)}</div>
            <button class="btn btn-link text-danger p-0 small" onclick="removeFromCart(${p.id})"><i class="bi bi-x-circle me-1"></i>Törlés</button>
          </div>
        `;
        wrap.appendChild(div);
      });

      // Frissítjük a rendelés összegzését is (ha nyitva a modal)
      renderOrderSummary();
    }

    function renderOrderSummary(){
      const cont = document.getElementById('orderSummary');
      if(!cont) return;
      cont.innerHTML = '';
      const cart = loadCart();
      cart.forEach(i => {
        const p = getProduct(i.id); if(!p) return;
        const row = document.createElement('div');
        row.className = 'd-flex justify-content-between align-items-center';
        row.innerHTML = `<span>${p.name} × ${i.qty}</span><strong>${fmt(p.price * i.qty)}</strong>`;
        cont.appendChild(row);
      });
      document.getElementById('orderTotal').textContent = fmt(totals().total);
    }

    function confirmOrder(){
      // Prototípus: csupán visszajelzünk és ürítjük a kosarat
      const amount = totals().total;
      const modalEl = document.getElementById('orderModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      modal.hide();
      clearCart();
      const toast = document.createElement('div');
      toast.className = 'toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3';
      toast.role = 'status'; toast.ariaLive = 'polite'; toast.ariaAtomic = 'true';
      toast.innerHTML = `<div class="d-flex"><div class="toast-body"><i class="bi bi-check2-circle me-2"></i>Rendelés leadva (demo): ${fmt(amount)}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>`;
      document.body.appendChild(toast);
      const t = new bootstrap.Toast(toast, { delay: 2500 }); t.show();
    }

    // Init
    document.addEventListener('DOMContentLoaded', renderCart);
  </script>
</body>
</html>

