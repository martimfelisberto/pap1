<!DOCTYPE html>
@php
$categorias = App\Models\Categoria::all()->groupBy('genero');
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reshopping</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="TemplatesJungle">
    <meta name="keywords" content="ecommerce,fashion,store">
    <meta name="description" content="Bootstrap 5 Fashion Store HTML CSS Template">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('kaira/css/vendor.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('kaira/style.css') }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('kaira/images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">


</head>

<body class="homepage">

    @if(session('error'))
    <div style="background-color: #FEE2E2; color: #B91C1C; padding: 1rem; border-radius: 8px; margin: 1rem 0; text-align: center;">
        {{ session('error') }}
    </div>
    @endif

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <defs>
            <symbol xmlns="http://www.w3.org/2000/svg" id="instagram" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor"
                    d="M11 3.5h1M4.5.5h6a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4h-6a4 4 0 0 1-4-4v-6a4 4 0 0 1 4-4Zm3 10a3 3 0 1 1 0-6a3 3 0 0 1 0 6Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="facebook" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor"
                    d="M7.5 14.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14Zm0 0v-8a2 2 0 0 1 2-2h.5m-5 4h5" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="twitter" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="m14.478 1.5l.5-.033a.5.5 0 0 0-.871-.301l.371.334Zm-.498 2.959a.5.5 0 1 0-1 0h1Zm-6.49.082h-.5h.5Zm0 .959h.5h-.5Zm-6.99 7V12a.5.5 0 0 0-.278.916L.5 12.5Zm.998-11l.469-.175a.5.5 0 0 0-.916-.048l.447.223Zm3.994 9l.354.353a.5.5 0 0 0-.195-.827l-.159.474Zm7.224-8.027l-.37.336l.18.199l.265-.04l-.075-.495Zm1.264-.94c.051.778.003 1.25-.123 1.606c-.122.345-.336.629-.723 1l.692.722c.438-.42.776-.832.974-1.388c.193-.546.232-1.178.177-2.006l-.998.066Zm0 3.654V4.46h-1v.728h1Zm-6.99-.646V5.5h1v-.959h-1Zm0 .959V6h1v-.5h-1ZM10.525 1a3.539 3.539 0 0 0-3.537 3.541h1A2.539 2.539 0 0 1 10.526 2V1Zm2.454 4.187C12.98 9.503 9.487 13 5.18 13v1c4.86 0 8.8-3.946 8.8-8.813h-1ZM1.03 1.675C1.574 3.127 3.614 6 7.49 6V5C4.174 5 2.421 2.54 1.966 1.325l-.937.35Zm.021-.398C.004 3.373-.157 5.407.604 7.139c.759 1.727 2.392 3.055 4.73 3.835l.317-.948c-2.155-.72-3.518-1.892-4.132-3.29c-.612-1.393-.523-3.11.427-5.013l-.895-.446Zm4.087 8.87C4.536 10.75 2.726 12 .5 12v1c2.566 0 4.617-1.416 5.346-2.147l-.708-.706Zm7.949-8.009A3.445 3.445 0 0 0 10.526 1v1c.721 0 1.37.311 1.82.809l.74-.671Zm-.296.83a3.513 3.513 0 0 0 2.06-1.134l-.744-.668a2.514 2.514 0 0 1-1.466.813l.15.989ZM.222 12.916C1.863 14.01 3.583 14 5.18 14v-1c-1.63 0-3.048-.011-4.402-.916l-.556.832Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="pinterest" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor"
                    d="m4.5 13.5l3-7m-3.236 3a2.989 2.989 0 0 1-.764-2V7A3.5 3.5 0 0 1 7 3.5h1A3.5 3.5 0 0 1 11.5 7v.5a3 3 0 0 1-3 3a2.081 2.081 0 0 1-1.974-1.423L6.5 9m1 5.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="youtube" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="m1.61 12.738l-.104.489l.105-.489Zm11.78 0l.104.489l-.105-.489Zm0-10.476l.104-.489l-.105.489Zm-11.78 0l.106.489l-.105-.489ZM6.5 5.5l.277-.416A.5.5 0 0 0 6 5.5h.5Zm0 4H6a.5.5 0 0 0 .777.416L6.5 9.5Zm3-2l.277.416a.5.5 0 0 0 0-.832L9.5 7.5ZM0 3.636v7.728h1V3.636H0Zm15 7.728V3.636h-1v7.728h1ZM1.506 13.227c3.951.847 8.037.847 11.988 0l-.21-.978a27.605 27.605 0 0 1-11.568 0l-.21.978ZM13.494 1.773a28.606 28.606 0 0 0-11.988 0l.21.978a27.607 27.607 0 0 1 11.568 0l.21-.978ZM15 3.636c0-.898-.628-1.675-1.506-1.863l-.21.978c.418.09.716.458.716.885h1Zm-1 7.728a.905.905 0 0 1-.716.885l.21.978A1.905 1.905 0 0 0 15 11.364h-1Zm-14 0c0 .898.628 1.675 1.506 1.863l.21-.978A.905.905 0 0 1 1 11.364H0Zm1-7.728c0-.427.298-.796.716-.885l-.21-.978A1.905 1.905 0 0 0 0 3.636h1ZM6 5.5v4h1v-4H6Zm.777 4.416l3-2l-.554-.832l-3 2l.554.832Zm3-2.832l-3-2l-.554.832l3 2l.554-.832Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
            </symbol>
            <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
                <path fill="currentColor"
                    d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
            </symbol>
        </defs>
    </svg>

    <nav style="padding: 1rem; background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB; width: 100%; margin: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo e Título -->
            <div style="display: flex; align-items: center;">
                <a href="/" style="display: flex; align-items: center; text-decoration: none;">
                    <img src="{{ asset('kaira/images/logo.png') }}" alt="Reshopping"
                        style="width: 80px; height: auto; margin-right: 1rem;">
                    <h2 style="font-size: 1.75rem; font-weight: bold; color: #333; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                        Reshopping
                    </h2>
                </a>
            </div>

            <!-- Links Centrais da Navbar -->
            <div style="display: flex; gap: 1.5rem; align-items: center;">
                <a href="/" style="color: #374151; text-decoration: none; font-size: 1rem; font-weight: 500;">Home</a>
                @foreach($categorias as $genero => $categoriasGenero)
                <div style="position: relative;">
                    <button onclick="toggleDropdown('dropdown{{ ucfirst($genero) }}')"
                        style="background: none; border: none; color: #374151; font-size: 1rem; font-weight: 500; cursor: pointer;">
                        {{ ucfirst($genero) }} <i class="bi bi-chevron-down" style="margin-left: 0.5rem;"></i>
                    </button>
                    <ul id="dropdown{{ ucfirst($genero) }}"
                        style="display: none; position: absolute; top: 2rem; left: 0; background: #FFF; border-radius: 8px; padding: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); list-style: none; z-index: 10;">
                        @foreach($categoriasGenero as $categoria)
                        <li style="margin: 0.5rem 0;">
                            <a href="{{ route('produtos.index', ['genero' => $genero, 'categoria' => $categoria->id]) }}"
                                style="color: #374151; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
                                {{ ucfirst($categoria->titulo) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
                @auth
                <a href="/contactos" style="color: #374151; text-decoration: none; font-size: 1rem; font-weight: 500;">Contacta-nos</a>
                @else
                <a href="{{ route('login', ['redirect' => 'contactos']) }}" style="color: #374151; text-decoration: none; font-size: 1rem; font-weight: 500;">Contacta-nos</a>
                @endauth

                @if(auth()->check() && auth()->user()->is_admin())

                <div style="position: relative;">
                    <button onclick="toggleDropdown('dropdownadminCategorias')"
                        style="background: none; border: none; color: #374151; font-size: 1rem; font-weight: 500; cursor: pointer;">
                        <i class="bi bi-tags" style="margin-right: 0.5rem;"></i>Categorias
                    </button>
                    <ul id="dropdownadminCategorias"
                        style="display: none; position: absolute; top: 2rem; left: 0; background: #FFF; border-radius: 8px; padding: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); list-style: none; z-index: 10;">
                        <li style="margin: 0.5rem 0;">
                            <a href="{{ route('categorias.create') }}"
                                style="color: #374151; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
                                <i class="bi bi-plus-circle" style="margin-right: 0.5rem;"></i>Nova Categoria
                            </a>
                        </li>
                        <li style="margin: 0.5rem 0;">
                            <a href="{{ route('categorias.index') }}"
                                style="color: #374151; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
                                <i class="bi bi-list" style="margin-right: 0.5rem;"></i>Listar Categorias
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>

            <!-- Seção de Autenticação, Busca e Carrinho -->
            <div style="display: flex; gap: 1rem; align-items: center;">
                @guest
                <div style="position: relative;">
                    <button onclick="toggleDropdown('dropdownauthOptions')"
                        style="padding: 0.5rem 1rem; background-color: rgb(36, 104, 250); color: #FFF; border: none; border-radius: 8px; font-size: 0.875rem; cursor: pointer;">
                        <i class="bi bi-box-arrow-in-right" style="margin-right: 0.5rem;"></i>Entra ou Regista te já
                    </button>
                    <ul id="dropdownauthOptions"
                        style="display: none; position: absolute; top: 2.5rem; right: 0; background: #FFF; border-radius: 8px; padding: 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); list-style: none; z-index: 10;">
                        <li style="margin: 0.5rem 0;">
                            <a href="{{ route('login') }}"
                                style="color: #374151; text-decoration: none; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center;">
                                <i class="bi bi-box-arrow-in-right" style="margin-right: 0.5rem;"></i>Entrar
                            </a>
                        </li>
                        <li style="margin: 0.5rem 0;">
                            <a href="{{ route('register') }}"
                                style="color: #374151; text-decoration: none; font-size: 0.875rem; font-weight: 500; display: flex; align-items: center;">
                                <i class="bi bi-person-plus" style="margin-right: 0.5rem;"></i>Registrar
                            </a>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('produtos.create') }}"
                    style="padding: 0.5rem 1rem; background-color: rgb(4, 23, 85); color: #FFF; border: none; border-radius: 8px; font-size: 0.875rem; text-decoration: none; cursor: pointer;">
                    <i class="bi bi-plus-lg" style="margin-right: 0.5rem;"></i>Anunciar um Produto
                </a>

                <!-- Search Icon -->
                <div>
                    <form action="{{ route('produtos.index') }}" method="GET" style="display: flex; align-items: center;">
                        <input type="text" name="search" placeholder="Pesquisar produtos..."
                            value="{{ request('search') }}"
                            style="padding: 0.5rem; border: 1px solid #E5E7EB; border-radius: 8px; font-size: 0.875rem; width: 200px;">
                        <button type="submit" style="background: none; border: none; color: #374151; cursor: pointer;">
                            <i class="bi bi-search" style="font-size: 1.25rem;"></i>
                        </button>
                    </form>
                </div>


                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                            alt="Profile"
                            class="rounded-circle me-2"
                            style="width: 32px; height: 32px; object-fit: cover;">
                        @else
                        <i class="bi bi-person-circle me-2 fs-5"></i>
                        @endif
                        <span>{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>
                                Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('produtos.myproducts') }}">
                                <i class="bi bi-bag me-2"></i>
                                Meus Produtos
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('favoritos.index') }}">
                                <i class="bi bi-heart me-2"></i>
                                Meus Favoritos
                            </a>
                        </li>
                        @if(auth()->user()->is_admin())
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Painel Admin
                            </a>
                        </li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item d-flex align-items-center">
                                @csrf
                                <button type="submit" class="btn btn-link text-danger p-0 d-flex align-items-center w-100">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endguest
            </div>
            <!-- Cart Icon -->
            <div>
                <a href="{{ route('carrinho.index') }}" class="position-relative" style="text-decoration: none; color: #041755;">
                    <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                    @php
                        if (auth()->check()) {
                            // For logged in users with database cart
                            $cartCount = \App\Models\CarrinhoItem::where('user_id', auth()->id())->sum('quantidade');
                        } else {
                            // For guests with session cart
                            $carrinho = session()->get('carrinho', []);
                            $cartCount = 0;
                            foreach ($carrinho as $item) {
                                $cartCount += $item['quantidade'] ?? 1;
                            }
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span style="position: absolute; top: -8px; right: -10px; background-color: #DC2626; color: white; border-radius: 50%; width: 22px; height: 22px; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    </nav>

    <!-- Faz com que os dropdowns se escondamao clicar fora deles -->
    <script>
        // Fecha dropdowns quando clicar fora
        document.addEventListener('click', function(event) {
            const isDropdownButton = event.target.closest('[onclick^="toggleDropdown"]');
            const isDropdownContent = event.target.closest('[id^="dropdown"]');

            if (!isDropdownButton && !isDropdownContent) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown"]');
                allDropdowns.forEach(dropdown => {
                    dropdown.style.display = "none";
                });
            }
        });


        function toggleDropdown(id) {
            var dropdown = document.getElementById(id);
            dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") ? "block" : "none";
        }
    </script>


    {{ $slot }}

    <div class="container">
        <footer id="footer" style="padding: 1rem; background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB; width: 100%; margin: 0;">
            <!-- Primeira Parte – Conteúdo do Footer -->
            <div style="padding: 2rem 1rem;">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem;">
                    <!-- Bloco 1: Introdução -->
                    <div style="flex: 1 1 250px;">
                        <div style="margin-bottom: 1rem;">
                            <a href="#">
                                <img src="{{ asset('kaira/images/main-logo.png') }}" alt="logo" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                    </div>

                    <!-- Bloco 2: Atalhos -->
                    <div style="flex: 1 1 250px;">
                        <ul style="list-style: none; padding: 0; margin: 0; text-transform: uppercase; font-size: 0.875rem; color: #666;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="http://reshoppingpap.test/" style="color: #333; text-decoration: none;">Página inicial</a>
                            </li>

                            <li style="margin-bottom: 0.5rem;">
                                <a href="#" style="color: #333; text-decoration: none;">Contacte-nos</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Bloco 3: Ajuda & Informações -->
                    <div style="flex: 1 1 250px;">
                        <h5 style="font-size: 1rem; text-transform: uppercase; color: #333; margin-bottom: 1rem;">Ajuda & informações</h5>
                        <ul style="list-style: none; padding: 0; margin: 0; text-transform: uppercase; font-size: 0.875rem; color: #666;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="#" style="color: #333; text-decoration: none;">Contacte-nos</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Bloco 4: Contacte-nos -->
                    <div style="flex: 1 1 250px;">
                        <h5 style="font-size: 1rem; text-transform: uppercase; color: #333; margin-bottom: 1rem;">Contacte-nos</h5>
                        <p style="font-size: 0.875rem; margin-bottom: 0.5rem;">
                            <a href="mailto:ajuda@reshopping.pt" style="color: rgb(4, 23, 85); text-decoration: none;">ajuda@reshopping.pt</a>
                        </p>
                        <p style="font-size: 0.875rem;">
                            <a href="tel:+351965221732" style="color: rgb(4, 23, 85); text-decoration: none;">+351 965 221 732</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Segunda Parte – Rodapé Inferior -->
            <div style="padding: 1rem; background-color: #F9FAFB; border-bottom: 1px solid #E5E7EB; width: 100%; margin: 0;">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">

                    <!-- Copyright -->
                    <div style="flex: 1 1 300px; text-align: right; font-size: 0.875rem; color: #666;">
                        <p style="margin: 0;">
                            © Copyright 2022 Kaira. All rights reserved.
                            Design by
                            <a href="https://templatesjungle.com" target="_blank" style="color: rgb(4, 23, 85); text-decoration: none;">TemplatesJungle</a>
                            Distribution By
                            <a href="https://themewagon.com" target="_blank" style="color: rgb(4, 23, 85); text-decoration: none;">ThemeWagon</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('kaira/js/jquery.min.js') }}"></script>
    <script src="{{ asset('kaira/js/plugins.js') }}"></script>
    <script src="{{ asset('kaira/js/SmoothScroll.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="{{ asset('kaira/js/script.min.js') }}"></script>

</body>

</html>