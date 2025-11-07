<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kedvencek</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
        }
        .category-buttons .btn-nav {
            background-color: #fff;
            border: 1px solid #ccc;
        }
        .category-buttons .btn-nav.active {
            background-color: #000;
            color: #fff;
            border-color: #000;
        }

        .no-favourites {
            grid-column: 1 / -1;
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            white-space: nowrap;
            margin-top: 100px;
        }
        .remove-favourite {
    background-color: #dc3545;
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.remove-favourite:hover {
    background-color: #b02a37;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
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
            <input type="text" placeholder="Keresés..." id="searchInput">
            <div class="suggestions-box" id="suggestionsBox"></div>
        </div>
    </div>

    <div class="right-group">
        <div class="icon" title="Kosár">
            <a href="{{ Route::has('bag.index') ? route('bag.index') : url('/bag') }}" style="text-decoration:none; color:inherit;">
                🛒
                @php $cnt = session('cart_count', collect(session('cart', []))->sum('qty')); @endphp
                @if($cnt > 0)
                    <span style="font-weight:700;">({{ $cnt }})</span>
                @endif
            </a>
        </div>
        <div class="profile-circle" title="Profil">👤</div>
    </div>
</header>

<main class="home-wrap">
    <section class="hero-card" style="margin-top:120px;">
        <div class="hero-text">
            <h1>Kedvenc termékeid</h1>
            <p>Itt találod az összes szívezett termékedet.</p>
        </div>
    </section>

    <section class="category-buttons" id="categoryButtons">
        <button class="btn-nav active" data-category="all">Összes</button>
        @foreach ($categories as $category)
            <button class="btn-nav" data-category="{{ $category }}">{{ $category }}</button>
        @endforeach
    </section>

    <section class="section">
        <div class="product-grid">
            @forelse ($favourites as $p)
                <div class="product-card" data-category="{{ $p['category'] }}">
                    <a href="{{ Route::has('items.show') ? route('items.show', ['id' => $p['id']]) : url('/items/'.$p['id']) }}"
                       style="text-decoration: none; color: inherit;">
                        <div class="product-img" style="background-image:url('{{ $p['img'] }}')"></div>
                        <div class="product-info">
                            <h3>{{ $p['name'] }}</h3>
                            <div class="price">{{ number_format($p['price'], 0, '', ' ') }} Ft</div>
                            <small style="color: #6c757d;">Kategória: {{ $p['category'] }}</small>
                        </div>
                    </a>
                    <div class="actions" style="padding: 0 14px 14px;">
                        <button class="btn-nav remove-favourite"
        data-id="{{ $p['id'] }}"
        style="background-color:#dc3545; color:white;">
    Eltávolítás
</button>
                        <a class="btn-nav" href="{{ Route::has('items.show') ? route('items.show', ['id' => $p['id']]) : url('/items/'.$p['id']) }}">Megnézem</a>
                    </div>
                </div>
            @empty
                <div class="no-favourites">
                    Nincsenek kedvenc termékeid még.<br>
                    Böngéssz a <a href="{{ route('home') }}">főoldalon</a> és szívezz ki párat!
                </div>
            @endforelse
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-inner">
        <div>© {{ date('Y') }} ButorBolt – Kedvencek</div>
    </div>
</footer>
<script>
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('suggestionsBox');
    const categoryButtonsContainer = document.getElementById('categoryButtons');
    const productCards = document.querySelectorAll('.product-card');
    const categoryButtons = categoryButtonsContainer.querySelectorAll('.btn-nav');

    const products = @json($favourites);

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        suggestionsBox.innerHTML = '';

        if (query === '') {
            suggestionsBox.style.display = 'none';
            return;
        }

        const filtered = products.filter(p => p.name.toLowerCase().includes(query));

        if (filtered.length === 0) {
            suggestionsBox.style.display = 'none';
            return;
        }

        filtered.forEach(item => {
            const div = document.createElement('div');
            div.classList.add('suggestion-item');
            div.textContent = item.name;
            div.addEventListener('click', () => {
                window.location.href = `{{ url('/items') }}/${item.id}`;
            });
            suggestionsBox.appendChild(div);
        });

        suggestionsBox.style.display = 'block';
    });

    searchInput.addEventListener('blur', () => {
        setTimeout(() => suggestionsBox.style.display = 'none', 100);
    });

    categoryButtonsContainer.addEventListener('click', (event) => {
        if (event.target.tagName === 'BUTTON') {
            const selectedCategory = event.target.getAttribute('data-category');

            categoryButtons.forEach(button => button.classList.remove('active'));
            event.target.classList.add('active');

            productCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (selectedCategory === 'all' || cardCategory === selectedCategory) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    });
document.querySelectorAll('.remove-favourite').forEach(btn => {
    btn.addEventListener('click', async function() {
        const id = this.dataset.id;
        const card = this.closest('.product-card');

        try {
            const response = await fetch(`/favourites/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                card.style.transition = "opacity 0.4s ease, transform 0.4s ease";
                card.style.opacity = "0";
                card.style.transform = "scale(0.95)";
                setTimeout(() => card.remove(), 400);

                localStorage.removeItem(`favourite_${id}`);
            } else {
                alert('Hiba történt az eltávolításkor.');
            }
        } catch (error) {
            console.error('Hálózati hiba:', error);
        }
    });
});
</script>
</script>

</body>
</html>
