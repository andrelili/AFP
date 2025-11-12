<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilom</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .profile-container {
            max-width: 800px;
            margin: 140px auto 60px;
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-pic {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #eee;
        }

        .profile-pic-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-pic-upload input[type="file"] {
            display: none;
        }

        .upload-label {
            cursor: pointer;
            background: #000;
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f8f8;
        }

        .form-group input:disabled {
            background-color: #eee;
            color: #666;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn-nav {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-nav:hover {
            background-color: #333;
        }

        .home-button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: 0.2s;
        }

        .home-button:hover {
            background-color: #333;
        }

        @media (max-width: 600px) {
            .profile-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="left-group">
        <a href="{{ route('home') }}">
            <img class="logo" src="{{ asset('images/butorlogo.png') }}" alt="Logo">
        </a>
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

        <a href="{{ route('home') }}" class="home-button" title="Főoldal">Főoldal</a>
    </div>
</header>

<main class="home-wrap">
    <section class="profile-container">
        <div class="profile-header">
            <div class="profile-pic-upload">
                {{-- Profilkép megjelenítése + cache törés --}}
                <img src="{{ Auth::user()->profile_picture
                    ? asset('storage/' . Auth::user()->profile_picture . '?v=' . time())
                    : asset('images/default-avatar.png') }}"
                    alt="Profilkép" class="profile-pic" id="profilePreview">

                {{-- Profilkép módosítás --}}
                <label for="profilePicture" class="upload-label">Profilkép módosítása</label>
                <form id="profilePicForm" method="POST" enctype="multipart/form-data" action="{{ route('profile.updatePicture') }}">
                    @csrf
                    <input type="file" id="profilePicture" name="profile_picture" accept="image/*">
                </form>
            </div>
        </div>

        {{-- Profil adatok --}}
        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
            @csrf
            @method('PUT')
            <div class="form-group">
            <label for="username">Felhasználónév</label>
            <input type="text" id="username" name="username" value="{{ old('username', Auth::user()->username) }}" disabled>
            </div>


            <div class="form-group">
                <label for="email">E-mail cím</label>
                <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" disabled>
            </div>

            <div class="form-group">
                <label for="address">Cím</label>
                <input type="text" id="address" name="address" value="{{ old('address', Auth::user()->address ?? '') }}" disabled>
            </div>

            <div class="action-buttons">
                <button type="button" class="btn-nav" id="editBtn">Módosítás</button>
                <button type="submit" class="btn-nav" id="saveBtn" style="display:none;">Mentés</button>
            </div>
        </form>
    </section>
</main>

<footer class="footer">
    <div class="footer-inner">
        <div>© {{ date('Y') }} ButorBolt – Profilom</div>
    </div>
</footer>

<script>
    // --- Adatmódosítás kezelése ---
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const inputs = document.querySelectorAll('#profileForm input');

    editBtn.addEventListener('click', () => {
        inputs.forEach(input => input.disabled = false);
        editBtn.style.display = 'none';
        saveBtn.style.display = 'inline-block';
    });

    // --- Profilkép feltöltés ---
    const profilePicture = document.getElementById('profilePicture');
    const profilePreview = document.getElementById('profilePreview');
    const profilePicForm = document.getElementById('profilePicForm');

    profilePicture.addEventListener('change', () => {
        const file = profilePicture.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => profilePreview.src = e.target.result;
            reader.readAsDataURL(file);
            profilePicForm.submit();
        }
    });
</script>

</body>
</html>
