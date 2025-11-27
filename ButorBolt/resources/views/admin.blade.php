<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin felület – Termékkezelés</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        .btn-add {
            background-color: #28a745;
            color: #fff;
            margin-bottom: 20px;
        }
        .btn-add:hover { background-color: #218838; }
        .btn-delete { background-color: #dc3545; color: #fff; }
        .btn-delete:hover { background-color: #c82333; }
        .btn-edit { background-color: #ffc107; color: #000; }
        .btn-edit:hover { background-color: #e0a800; }

        .admin-actions {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
        }

        .product-img {
            height: 160px;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .modal-bg {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 400px;
            max-width: 90%;
            position: relative;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .modal h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-close {
            position: absolute;
            top: 8px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .profile-menu { position: relative; }
        .profile-circle {
            width: 40px; height: 40px;
            border-radius: 50%;
            overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            background-color: #f5f5f5;
            cursor: pointer;
            transition: background 0.3s;
        }
        .profile-circle:hover { background-color: #e0e0e0; }
        .profile-img { width: 100%; height: 100%; object-fit: cover; }

        .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 100;
            min-width: 150px;
        }
        .profile-dropdown a,
        .profile-dropdown button {
            display: block;
            width: 100%;
            padding: 10px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
        }
        .profile-dropdown a:hover,
        .profile-dropdown button:hover {
            background-color: #f0f0f0;
        }

        /* --- Szűrő dropdown --- */
        .filter-dropdown {
            display: none;
            position: absolute;
            top: 100%; /* közvetlenül a gomb alatt */
            left: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            min-width: 160px;
            z-index: 1000;
        }
        .filter-dropdown a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: black;
            cursor: pointer;
        }
        .filter-dropdown a:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="">
        </a>
    </div>


                <div class="search-wrapper" style="display: flex; align-items: center; gap: 5px;">
    <div class="icon" title="Szűrés" id ="filterBtn" style="position: relative; cursor: pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="black">
            <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
        </svg>
                    <div class="dropdown-content" id="filterDropdown" style="position:absolute; top:30px; right:0; display:none; background:white; border:1px solid #ccc; border-radius:6px; min-width:180px; box-shadow:0 4px 10px rgba(0,0,0,0.1); z-index:100;">
                <a data-sort="price-asc">Ár szerint növekvő</a>
                <a data-sort="price-desc">Ár szerint csökkenő</a>
                <a data-sort="name-asc">Név szerint (A–Z)</a>
                <a data-sort="name-desc">Név szerint (Z–A)</a>
                <a data-sort="favourite-desc">Legkedveltebb</a>
            </div>
    </div>
    <div class="search-box">
        <input type="text" placeholder="Keresés..." id="searchInput">
        <div class="suggestions-box" id="suggestionsBox"></div>
    </div>
</div>
<div class="right-group">
        <a href="{{ route('home') }}" class="btn-nav btn-preview" title="Előnézet">Előnézet</a>

        <div class="profile-menu">
            <div class="profile-circle" id="profileToggle" title="Profil">
                <img src="{{ asset('/images/adminkep.jpg') }}" alt="Admin ikon" class="profile-img">
            </div>
            <div class="profile-dropdown" id="profileDropdown">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Kijelentkezés</button>
                </form>
            </div>
        </div>
    </div>
</header>

<main class="form-container" style="margin-top:120px;">
    <h2>Admin kezelőfelület</h2>
    <button class="btn-nav btn-add" id="btnAddProduct">+ Termék hozzáadása</button>

    <div class="product-grid" id="productGrid">
        @foreach ($products as $p)
            <div class="product-card" data-name="{{ $p['name'] }}" data-price="{{ $p['price'] }}">
                <div class="product-img" style="background-image:url('{{ $p['img'] }}')"></div>
                <h3>{{ $p['name'] }}</h3>
                <p><strong>{{ number_format($p['price'], 0, '', ' ') }} Ft</strong></p>
                <small>Készlet: {{ $p['stock'] }}</small>
                <div class="admin-actions">
                    <form method="POST" action="{{ route('admin.delete', $p['id']) }}" onsubmit="return confirm('Biztosan törlöd a terméket?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-nav btn-delete">🗑️</button>
                    </form>
                    <button class="btn-nav btn-edit"
                            data-id="{{ $p['id'] }}"
                            data-name="{{ $p['name'] }}"
                            data-stock="{{ $p['stock'] }}"
                            data-price="{{ $p['price'] }}"
                            data-category="{{ $p['category'] }}">
                        ✏️
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    @if ($products->isEmpty())
        <p style="margin-top:20px;">Jelenleg nincsenek termékek az adatbázisban.</p>
    @endif
</main>

<!-- Modal -->
<div class="modal-bg" id="productModal">
    <div class="modal">
        <span class="modal-close" id="closeModal">&times;</span>
        <h3 id="modalTitle">Új termék hozzáadása</h3>

        <form id="productForm" method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="productId">

            <div class="form-field">
                <input type="text" name="name" id="productName" placeholder="Termék neve" required>
            </div>

            <div class="form-field">
                <input type="number" name="price" id="productPrice" placeholder="Ár (Ft)" required>
            </div>

            <div class="form-field">
                <input type="number" name="stock" id="productStock" placeholder="Elérhető mennyiség" min="0" step="1" required>
            </div>

            <div class="form-field">
                <select name="category" id="productCategory">
                    <option value="">-- Válassz kategóriát --</option>
                    @foreach($products->pluck('category')->unique()->sort() as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-field">
                <input type="file" name="img" id="productImg">
            </div>

            <button type="submit" class="btn-nav btn-add">Mentés</button>
        </form>
    </div>
</div>

<script>
    // Modal megnyitás / bezárás
    const modal = document.getElementById('productModal');
    const btnAdd = document.getElementById('btnAddProduct');
    const closeModal = document.getElementById('closeModal');
    const form = document.getElementById('productForm');
    const title = document.getElementById('modalTitle');

    btnAdd.addEventListener('click', () => {
        title.textContent = "Új termék hozzáadása";
        form.action = "{{ route('admin.store') }}";
        form.reset();
        modal.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });

   document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
        title.textContent = "Termék szerkesztése";
        form.action = "/admin/update/" + btn.dataset.id; 
        modal.style.display = 'flex';

        document.getElementById('productId').value = btn.dataset.id;
        document.getElementById('productName').value = btn.dataset.name;
        document.getElementById('productPrice').value = btn.dataset.price;
        document.getElementById('productStock').value = btn.dataset.stock;
        document.getElementById('productCategory').value = btn.dataset.category || '';
    });
});


    // Profil dropdown
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('profileToggle');
        const dropdown = document.getElementById('profileDropdown');

        if (toggle && dropdown) {
            toggle.addEventListener('click', e => {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', e => {
                if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }
    });

    // Szűrő dropdown működés
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');
    filterBtn.addEventListener('click', e => {
        e.stopPropagation();
        filterDropdown.style.display = filterDropdown.style.display === 'block' ? 'none' : 'block';
    });
    document.addEventListener('click', e => {
        if (!filterBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
            filterDropdown.style.display = 'none';
        }
    });

    // Szűrő funkció (ár, név szerint rendezés)
    filterDropdown.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            const sort = link.getAttribute('data-sort');
            const grid = document.getElementById('productGrid');
            const cards = Array.from(grid.querySelectorAll('.product-card'));
            let sortedCards = [];

            if (sort === 'price-asc') {
                sortedCards = cards.sort((a,b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
            } else if (sort === 'price-desc') {
                sortedCards = cards.sort((a,b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
            } else if (sort === 'name-asc') {
                sortedCards = cards.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
            } else if (sort === 'name-desc') {
                sortedCards = cards.sort((a,b) => b.dataset.name.localeCompare(a.dataset.name));
            }

            sortedCards.forEach(card => grid.appendChild(card));
            filterDropdown.style.display = 'none';
        });
    });
</script>

</body>
</html>
