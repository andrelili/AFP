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
        .btn-add:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }
        .btn-edit:hover {
            background-color: #e0a800;
        }

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
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="">
        </a>
        <div class="menu-icon" title="Menü">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="icon" title="Szűrés">
            <svg xmlns="http://www.w3.org/2000/svg"
            width="22" height="22"
            viewBox="0 0 24 24"
            fill="black">
            <path d="M3 4h18l-7 8v7l-4 2v-9L3 4z"/>
            </svg>
        </div>
    </div>

    <div class="center-group">
        <div class="search-box">
            <input type="text" placeholder="Keresés...">
        </div>
    </div>

    <div class="right-group">
        <div class="profile-circle" title="Profil">
            <img src="{{asset('/images/adminkep.jpg')}}" alt="Admin ikon" class="profile-img">
        </div>
    </div>
</header>

<main class="form-container" style="margin-top:120px;">
    <h2>Admin kezelőfelület</h2>
    <button class="btn-nav btn-add" id="btnAddProduct">+ Termék hozzáadása</button>

    <div class="product-grid">
        @foreach ($products as $p)
            <div class="product-card">
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
                            data-price="{{ $p['price'] }}">
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
                <input type="file" name="img" id="productImg">
            </div>

            <button type="submit" class="btn-nav btn-add">Mentés</button>
        </form>
    </div>
</div>

<script>
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
            form.action = "{{ route('admin.update') }}";
            modal.style.display = 'flex';

            document.getElementById('productId').value = btn.dataset.id;
            document.getElementById('productName').value = btn.dataset.name;
            document.getElementById('productPrice').value = btn.dataset.price;
            document.getElementById('productStock').value = btn.dataset.stock;
        });
    });
</script>

</body>
</html>
