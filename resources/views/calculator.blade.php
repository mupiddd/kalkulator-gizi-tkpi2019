<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentUser ? "Nola's Pixel Nutrition ♥ Kalkulator Gizi TKPI 2019" : "PixelGizi ♥ Kalkulator Gizi TKPI 2019" }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Silkscreen (Pixel Heading), Pixelify Sans (Pixel UI), Plus Jakarta Sans (Clean Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">

    <!-- TomSelect CSS & JS untuk Searchable Dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <style>
        :root {
            --pink-hot: #ff2e93;
            --pink-deep: #db2777;
            --pink-mid: #f472b6;
            --pink-soft: #fce7f3;
            --pink-pale: #fff5f9;
            --pixel-ink: #1e1224;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--pixel-ink);
            background-color: #fff8fc;
            background-image:
                linear-gradient(to right, rgba(244, 114, 182, 0.14) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(244, 114, 182, 0.14) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        .font-pixel-title {
            font-family: 'Silkscreen', monospace;
            letter-spacing: -0.02em;
        }

        .font-pixel-ui {
            font-family: 'Pixelify Sans', sans-serif;
        }

        /* Retro Pixel Card & Borders */
        .pixel-card {
            background: rgba(255, 255, 255, 0.95);
            border: 3px solid var(--pixel-ink);
            box-shadow: 6px 6px 0px #f472b6;
            border-radius: 1.25rem;
        }

        .pixel-card-pink {
            background: linear-gradient(180deg, #fffbfd 0%, #ffe4f1 100%);
            border: 3px solid var(--pixel-ink);
            box-shadow: 6px 6px 0px #ff2e93;
            border-radius: 1.25rem;
        }

        .pixel-btn {
            border: 2.5px solid var(--pixel-ink);
            box-shadow: 4px 4px 0px var(--pixel-ink);
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }

        .pixel-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 5px 5px 0px var(--pixel-ink);
        }

        .pixel-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px var(--pixel-ink);
        }

        .pixel-badge {
            border: 2px solid var(--pixel-ink);
            box-shadow: 2px 2px 0px #f472b6;
        }

        /* Floating cute animations */
        @keyframes floatGhost {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes pulseHeart {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.14); }
        }

        @keyframes twinkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(0.85); }
        }

        .animate-ghost {
            animation: floatGhost 3.2s ease-in-out infinite;
        }

        .animate-heart {
            animation: pulseHeart 1.8s ease-in-out infinite;
        }

        .animate-twinkle {
            animation: twinkle 2.4s ease-in-out infinite;
        }

        /* Accessible Form Controls (modern-web-guidance: forms) */
        .pixel-input {
            font-size: 1rem;
            padding: 0.7rem 1rem;
            min-height: 48px;
            box-sizing: border-box;
            border: 2.5px solid #f472b6;
            border-radius: 0.875rem;
            background: #ffffff;
            color: var(--pixel-ink);
            transition: all 0.15s ease;
        }

        .pixel-input:focus {
            outline: none;
            border-color: var(--pink-hot);
            box-shadow: 0 0 0 3px rgba(255, 46, 147, 0.22);
        }

        @media (pointer: coarse) {
            .pixel-input, .ts-control {
                min-height: 52px !important;
            }
        }

        /* Custom TomSelect Pink Pixel Styling */
        .ts-control {
            border-radius: 0.875rem !important;
            padding: 0.65rem 0.9rem !important;
            min-height: 48px !important;
            border: 2.5px solid #f472b6 !important;
            font-size: 0.925rem !important;
            box-shadow: none !important;
            background-color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: var(--pink-hot) !important;
            box-shadow: 0 0 0 3px rgba(255, 46, 147, 0.22) !important;
        }

        .ts-dropdown {
            border-radius: 0.875rem !important;
            margin-top: 6px !important;
            font-size: 0.875rem !important;
            border: 2.5px solid var(--pixel-ink) !important;
            box-shadow: 5px 5px 0px #f472b6 !important;
            overflow: hidden !important;
            z-index: 50 !important;
        }

        .ts-dropdown .option {
            padding: 0.6rem 0.9rem !important;
        }

        .ts-dropdown .active {
            background-color: #ffe4f1 !important;
            color: #9d174d !important;
            font-weight: 600 !important;
        }

        /* Responsive Table Container & Sticky Headers (modern-web-guidance: responsive-table) */
        .table-wrapper {
            overflow: auto;
            max-inline-size: 100%;
            max-block-size: min(680px, 78vh);
            container-type: inline-size;
            border-radius: 0.875rem;
            border: 2px solid #fbcfe8;
        }

        .nutrition-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            --label-1: "Zat Gizi";
            --label-2: "Hasil Hitung";
            --label-3: "Satuan";
            --label-4: "Acuan / 100g BDD";
        }

        .nutrition-table thead {
            position: sticky;
            inset-block-start: 0;
            z-index: 2;
        }

        .nutrition-table tbody th {
            position: sticky;
            inset-inline-start: 0;
            background: #ffffff;
            z-index: 1;
        }

        .nutrition-table tbody tr.row-highlight th {
            background: #fff0f7;
        }

        .nutrition-table tbody tr:hover th,
        .nutrition-table tbody tr:hover td {
            background-color: #fdf2f8 !important;
        }

        @container (width < 520px) {
            .nutrition-table,
            .nutrition-table thead,
            .nutrition-table tbody,
            .nutrition-table tr,
            .nutrition-table th,
            .nutrition-table td {
                display: block;
            }

            .nutrition-table thead {
                display: none;
            }

            .nutrition-table tr {
                margin-block-end: 0.75rem;
                border: 2px solid #f9a8d4;
                border-radius: 0.75rem;
                overflow: hidden;
                background: #fff;
            }

            .nutrition-table tbody th {
                position: sticky;
                inset-block-start: 0;
                z-index: 2;
                background: #fce7f3;
                border-bottom: 1px solid #f9a8d4;
            }

            .nutrition-table td:nth-child(2)::before {
                content: var(--label-2) ": " / var(--label-2);
                font-weight: 600;
                color: #be185d;
            }

            .nutrition-table td:nth-child(3)::before {
                content: var(--label-3) ": " / var(--label-3);
                font-weight: 600;
                color: #9d174d;
            }

            .nutrition-table td:nth-child(4)::before {
                content: var(--label-4) ": " / var(--label-4);
                font-weight: 500;
                color: #64748b;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- Floating Decorative Pixel Ornaments in Background -->
    <div class="pointer-events-none fixed inset-0 overflow-hidden z-0" aria-hidden="true">
        <!-- Pixel Heart Top Left -->
        <svg class="absolute top-20 left-8 w-7 h-7 text-pink-500 animate-heart opacity-75 hidden sm:block" viewBox="0 0 16 16" fill="currentColor">
            <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
        </svg>
        <!-- Pixel Sparkle Top Right -->
        <svg class="absolute top-24 right-12 w-8 h-8 text-pink-500 animate-twinkle opacity-80 hidden sm:block" viewBox="0 0 16 16" fill="currentColor">
            <path d="M7 1h2v4h2v2h4v2h-4v2H9v4H7v-4H5V9H1V7h4V5h2V1z"/>
        </svg>
        <!-- Pixel Heart Bottom Left -->
        <svg class="absolute bottom-28 left-14 w-6 h-6 text-rose-400 animate-twinkle opacity-70 hidden md:block" viewBox="0 0 16 16" fill="currentColor">
            <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
        </svg>
        <!-- Pixel Sparkle Bottom Right -->
        <svg class="absolute bottom-36 right-10 w-6 h-6 text-pink-400 animate-heart opacity-75 hidden md:block" viewBox="0 0 16 16" fill="currentColor">
            <path d="M7 1h2v4h2v2h4v2h-4v2H9v4H7v-4H5V9H1V7h4V5h2V1z"/>
        </svg>
    </div>

    <!-- Top Navigation Bar (Inspired by Pixo Header) -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 pt-5 pb-2">
        <div class="pixel-card px-4 sm:px-6 py-3.5 flex flex-wrap items-center justify-between gap-3">
            <!-- Brand Logo -->
            <a href="{{ route('calculator.index') }}" class="flex items-center gap-3 group">
                <!-- Cute Pink Pixel Ghost Icon -->
                <div class="w-10 h-10 rounded-xl bg-pink-100 border-2 border-[#1e1224] flex items-center justify-center shadow-[2px_2px_0px_#ff2e93] group-hover:scale-105 transition">
                    <svg class="w-7 h-7" viewBox="0 0 16 16" fill="none">
                        <path d="M5 2h6v2h2v8h-2v-2H9v2H7v-2H5v2H3V4h2V2z" fill="#ff2e93"/>
                        <rect x="5" y="6" width="2" height="2" fill="#ffffff"/>
                        <rect x="9" y="6" width="2" height="2" fill="#ffffff"/>
                        <rect x="6" y="7" width="1" height="1" fill="#1e1224"/>
                        <rect x="10" y="7" width="1" height="1" fill="#1e1224"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-pixel-title text-base sm:text-lg font-bold text-[#1e1224]">{{ $currentUser ? 'NolaPixel' : 'PixelGizi' }}</span>
                        <span class="text-xs font-pixel-ui bg-pink-500 text-white px-2 py-0.5 rounded-md border border-[#1e1224]">TKPI 2019 &amp; 2020</span>
                    </div>
                    <p class="text-xs text-pink-700 font-medium">
                        {{ $currentUser ? 'Kalkulator Gizi Spesial untuk Nola ♥' : 'Kalkulator Gizi Bahan Makanan ♥' }}
                    </p>
                </div>
            </a>

            <!-- Center Cute Badges -->
            <div class="hidden md:flex items-center gap-2.5 text-xs font-pixel-ui">
                <span class="px-3 py-1.5 rounded-full bg-pink-50 text-pink-700 border-2 border-pink-300 flex items-center gap-1.5">
                    <span class="text-pink-500">♥</span> Edisi Aktif: TKPI {{ $tahun ?? '2020' }} ({{ $ingredients->count() ?: 1146 }} Bahan)
                </span>
                <span class="px-3 py-1.5 rounded-full bg-pink-50 text-pink-700 border-2 border-pink-300 flex items-center gap-1.5">
                    <span class="text-pink-500">✦</span> Acuan Resmi Kemenkes RI
                </span>
            </div>

            <!-- Right User Status / Logout -->
            <div class="flex items-center gap-2.5">
                @if($currentUser)
                    <div class="flex items-center gap-2 bg-pink-100/90 border-2 border-[#1e1224] px-3 py-1.5 rounded-full text-xs font-bold text-pink-900 shadow-[2px_2px_0px_#f472b6]">
                        <span class="inline-block w-2 h-2 rounded-full bg-pink-500 animate-ping"></span>
                        <span>Halo, {{ $currentUser }}! ♥</span>
                    </div>
                    <form action="{{ route('calculator.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="pixel-btn bg-white hover:bg-rose-50 text-rose-700 text-xs font-pixel-ui font-bold px-3 py-1.5 rounded-full">
                            Keluar ✕
                        </button>
                    </form>
                @else
                    <span class="bg-[#ff2e93] text-white text-xs font-pixel-ui font-bold px-3.5 py-1.5 rounded-full border-2 border-[#1e1224] shadow-[2px_2px_0px_#1e1224]">
                        ♥ Private Pixel Space
                    </span>
                @endif
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">

        @if(!$currentUser)
            <!-- ========================================== -->
            <!-- HALAMAN LOGIN PRIVATE PIXEL SPACE          -->
            <!-- (Terinspirasi langsung dari Pixo)          -->
            <!-- ========================================== -->
            <div class="max-w-3xl mx-auto my-2">
                <div class="pixel-card overflow-hidden">
                    <!-- Top Hero Section -->
                    <div class="p-6 sm:p-10 text-center relative">
                        <!-- Badge -->
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-pink-100 border-2 border-[#1e1224] text-pink-800 text-xs font-pixel-ui font-bold mb-4 shadow-[2px_2px_0px_#f472b6]">
                            <span>♥</span> PRIVATE PIXEL SPACE <span>♥</span>
                        </div>

                        <!-- Big Pixel Title like "Small pixels. Big brain." -->
                        <h1 class="font-pixel-title text-2xl sm:text-4xl font-bold text-[#1e1224] leading-tight">
                            Small pixels.<br>
                            <span class="text-[#ff2e93]">Big love &amp; care.</span>
                        </h1>
                        <p class="text-sm text-slate-600 mt-3 max-w-md mx-auto">
                            Kalkulator Gizi TKPI 2019 bertema pixel pink yang dibuat khusus dengan penuh kasih sayang. Masukkan nama panggilanmu untuk masuk yaa!
                        </p>

                        <!-- Pixo-Style Cute Pixel Ghost & Pink Trees Illustration -->
                        <div class="relative my-6 py-4 flex flex-col items-center justify-center">
                            <!-- Floating Clouds & Hearts -->
                            <div class="flex items-center justify-between w-full max-w-md px-6 mb-1">
                                <!-- Left Pixel Heart -->
                                <svg class="w-7 h-7 text-[#ff2e93] animate-heart" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
                                </svg>
                                <!-- Right Pixel Sparkle -->
                                <svg class="w-8 h-8 text-[#ff2e93] animate-twinkle" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M7 1h2v4h2v2h4v2h-4v2H9v4H7v-4H5V9H1V7h4V5h2V1z"/>
                                </svg>
                            </div>

                            <!-- Cute Pixel Ghost Mascot + Heart Speech Bubble -->
                            <div class="relative inline-flex items-center justify-center animate-ghost">
                                <!-- Main Cute Ghost SVG -->
                                <svg class="w-32 h-32 sm:w-36 sm:h-36 drop-shadow-[0_6px_0_rgba(244,114,182,0.35)]" viewBox="0 0 32 32" fill="none">
                                    <!-- Black Pixel Outline -->
                                    <path d="M11 4h10v2h3v2h2v3h2v13h-2v2h-3v-2h-2v2h-3v2h-4v-2h-3v-2H9v2H6v-2H4V11h2V8h2V6h3V4z" fill="#1e1224"/>
                                    <!-- White Ghost Body -->
                                    <path d="M11 6h10v2h3v3h2v11h-2v-2h-3v2h-3v2h-4v-2h-3v-2H8v2H6V11h2V8h3V6z" fill="#ffffff"/>
                                    <!-- Pink Shading -->
                                    <path d="M6 19h2v3H6v-3zm18 0h2v3h-2v-3zm-13 3h3v2h4v-2h3v2h-3v2h-4v-2h-3v-2z" fill="#fbcfe8"/>
                                    <!-- Rosy Cheeks -->
                                    <rect x="8" y="16" width="3" height="2" fill="#ff7eb6"/>
                                    <rect x="21" y="16" width="3" height="2" fill="#ff7eb6"/>
                                    <!-- Left Big Cute Eye -->
                                    <rect x="10" y="11" width="4" height="5" fill="#1e1224"/>
                                    <rect x="10" y="11" width="2" height="2" fill="#ffffff"/>
                                    <rect x="12" y="14" width="1" height="1" fill="#ff7eb6"/>
                                    <!-- Right Big Cute Eye -->
                                    <rect x="18" y="11" width="4" height="5" fill="#1e1224"/>
                                    <rect x="18" y="11" width="2" height="2" fill="#ffffff"/>
                                    <rect x="20" y="14" width="1" height="1" fill="#ff7eb6"/>
                                </svg>

                                <!-- Speech Bubble with Heart (Top Right of Mascot) -->
                                <div class="absolute -top-2 -right-12 sm:-right-16 bg-white border-2 border-[#ff2e93] px-3 py-1.5 rounded-xl shadow-[3px_3px_0px_#ff2e93] animate-heart">
                                    <svg class="w-5 h-5 text-[#ff2e93]" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Pink Pixel Ground Strip -->
                            <div class="w-full max-w-lg h-3 bg-gradient-to-r from-transparent via-pink-300 to-transparent rounded-full mt-2"></div>
                        </div>

                        <!-- Login Form (Pixo Search-Pill Style) -->
                        <form action="{{ route('calculator.login') }}" method="POST" class="max-w-md mx-auto mt-2">
                            @csrf
                            <label for="nickname-input" class="block text-xs font-pixel-ui uppercase tracking-wider text-pink-700 font-bold mb-2">
                                ✦ Masukkan Nama Panggilan Spesial ✦
                            </label>
                            <div class="flex items-center gap-2 bg-white p-1.5 rounded-full border-3 border-[#ff2e93] shadow-[0_0_0_2px_#ff2e93,4px_4px_0px_#1e1224]">
                                <span class="pl-3 text-[#ff2e93]" aria-hidden="true">
                                    <svg class="w-5 h-5" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M7 1h2v4h2v2h4v2h-4v2H9v4H7v-4H5V9H1V7h4V5h2V1z"/>
                                    </svg>
                                </span>
                                <input
                                    id="nickname-input"
                                    type="text"
                                    name="nickname"
                                    value="{{ old('nickname') }}"
                                    placeholder="Ketik nama panggilanmu..."
                                    autocomplete="nickname"
                                    required
                                    autofocus
                                    class="w-full bg-transparent px-2 py-2 text-sm sm:text-base font-semibold text-[#1e1224] placeholder-pink-300 focus:outline-none"
                                >
                                <button
                                    type="submit"
                                    class="bg-[#ff2e93] hover:bg-[#e01b7b] text-white font-pixel-ui font-bold text-sm px-5 py-2.5 rounded-full border-2 border-[#1e1224] transition flex items-center gap-1.5 shrink-0"
                                >
                                    <span>Masuk</span>
                                    <span>→</span>
                                </button>
                            </div>

                            @error('nickname')
                                <div role="alert" class="mt-3 p-3 rounded-xl bg-rose-50 border-2 border-rose-500 text-rose-700 text-xs font-semibold flex items-center justify-center gap-2">
                                    <span>♥</span>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </form>
                    </div>

                    <!-- Bottom Pink Pixel Landscape Banner (Just like Pixo bottom cards) -->
                    <div class="bg-[#ff2e93] border-t-3 border-[#1e1224] p-6 text-white">
                        <p class="text-center font-pixel-title text-xs uppercase tracking-widest text-pink-100 mb-4">
                            ♥ BUILT WITH PIXEL LOVE ♥
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-[#1e1224]">
                            <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-3.5 shadow-[3px_3px_0px_#1e1224]">
                                <div class="font-pixel-ui font-bold text-sm text-[#ff2e93] flex items-center gap-1.5">
                                    <span>♥</span> Pesan Cinta Acak
                                </div>
                                <p class="text-xs text-slate-600 mt-1">Kata-kata manis di sisi kiri yang berganti setiap kali halaman di-refresh.</p>
                            </div>
                            <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-3.5 shadow-[3px_3px_0px_#1e1224]">
                                <div class="font-pixel-ui font-bold text-sm text-[#ff2e93] flex items-center gap-1.5">
                                    <span>✦</span> 1.147 Data TKPI
                                </div>
                                <p class="text-xs text-slate-600 mt-1">Database lengkap Tabel Komposisi Pangan Indonesia 2019 tersambung ke Supabase.</p>
                            </div>
                            <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-3.5 shadow-[3px_3px_0px_#1e1224]">
                                <div class="font-pixel-ui font-bold text-sm text-[#ff2e93] flex items-center gap-1.5">
                                    <span>✿</span> Hitung Otomatis
                                </div>
                                <p class="text-xs text-slate-600 mt-1">Rincian 14 parameter gizi lengkap dengan konversi BDD secara instan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- ======================================================== -->
            <!-- HALAMAN UTAMA KALKULATOR (WIDESCREEN 2 KOLOM MELEBAR)    -->
            <!-- KIRI: Kata-Kata Romantis Acak & Ornamen Pixel Cute       -->
            <!-- KANAN: Form & Tabel Perhitungan Gizi Memanjang ke Bawah  -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- ==================================================== -->
                <!-- SISI KIRI (5 KOLOM): KATA-KATA ROMANTIS ACAK & PIXEL -->
                <!-- ==================================================== -->
                <aside class="lg:col-span-5 lg:sticky lg:top-6 space-y-5">
                    <div class="pixel-card overflow-hidden">
                        <!-- Top Diorama Banner (Pixo Pink Pixel Scene) -->
                        <div class="relative pt-6 pb-4 px-5 text-center bg-gradient-to-b from-white via-pink-50/60 to-pink-100/80 border-b-3 border-[#1e1224]">
                            <!-- Pixel Clouds & Stars -->
                            <div class="flex items-center justify-between px-2 mb-1">
                                <span class="inline-flex items-center gap-1 text-xs font-pixel-ui font-bold text-pink-700 bg-white px-2.5 py-1 rounded-full border-2 border-[#1e1224] shadow-[2px_2px_0px_#f472b6]">
                                    ♥ For Nola
                                </span>
                                <span class="inline-flex items-center gap-1 text-xs font-pixel-ui font-bold text-white bg-[#ff2e93] px-2.5 py-1 rounded-full border-2 border-[#1e1224] shadow-[2px_2px_0px_#1e1224]">
                                    ✦ Love Note
                                </span>
                            </div>

                            <!-- Cute Pixel Ghost Mascot + Pink Pixel Trees Scene -->
                            <div class="relative flex items-end justify-center gap-3 pt-3 pb-1">
                                <!-- Left Pink Pixel Tree -->
                                <svg class="w-14 h-16 shrink-0" viewBox="0 0 24 28" fill="none" aria-hidden="true">
                                    <path d="M8 2h8v2h4v4h2v6h-2v2h-4v2H8v-2H4v-2H2V8h2V4h4V2z" fill="#1e1224"/>
                                    <path d="M8 4h8v2h4v6h-4v2H8v-2H4V6h4V4z" fill="#ff7eb6"/>
                                    <path d="M6 10h12v4H8v2H6v-6z" fill="#ff2e93"/>
                                    <rect x="10" y="18" width="4" height="8" fill="#1e1224"/>
                                    <rect x="11" y="18" width="2" height="8" fill="#7c2d12"/>
                                </svg>

                                <!-- Center Floating Cute Ghost Mascot -->
                                <div class="relative animate-ghost">
                                    <svg class="w-24 h-24 sm:w-28 sm:h-28 drop-shadow-[0_5px_0_rgba(255,46,147,0.3)]" viewBox="0 0 32 32" fill="none">
                                        <path d="M11 4h10v2h3v2h2v3h2v13h-2v2h-3v-2h-2v2h-3v2h-4v-2h-3v-2H9v2H6v-2H4V11h2V8h2V6h3V4z" fill="#1e1224"/>
                                        <path d="M11 6h10v2h3v3h2v11h-2v-2h-3v2h-3v2h-4v-2h-3v-2H8v2H6V11h2V8h3V6z" fill="#ffffff"/>
                                        <path d="M6 19h2v3H6v-3zm18 0h2v3h-2v-3zm-13 3h3v2h4v-2h3v2h-3v2h-4v-2h-3v-2z" fill="#fbcfe8"/>
                                        <rect x="8" y="16" width="3" height="2" fill="#ff7eb6"/>
                                        <rect x="21" y="16" width="3" height="2" fill="#ff7eb6"/>
                                        <rect x="10" y="11" width="4" height="5" fill="#1e1224"/>
                                        <rect x="10" y="11" width="2" height="2" fill="#ffffff"/>
                                        <rect x="12" y="14" width="1" height="1" fill="#ff7eb6"/>
                                        <rect x="18" y="11" width="4" height="5" fill="#1e1224"/>
                                        <rect x="18" y="11" width="2" height="2" fill="#ffffff"/>
                                        <rect x="20" y="14" width="1" height="1" fill="#ff7eb6"/>
                                    </svg>
                                    <!-- Speech Bubble Heart -->
                                    <div class="absolute -top-2 -right-6 bg-white border-2 border-[#ff2e93] px-2 py-1 rounded-lg shadow-[2px_2px_0px_#ff2e93] animate-heart">
                                        <svg class="w-4 h-4 text-[#ff2e93]" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Right Pink Pixel Tree with Flag Hill -->
                                <svg class="w-14 h-16 shrink-0" viewBox="0 0 24 28" fill="none" aria-hidden="true">
                                    <rect x="11" y="2" width="2" height="8" fill="#1e1224"/>
                                    <path d="M13 2h6v4h-6V2z" fill="#ff2e93"/>
                                    <path d="M6 10h12v2h4v6h-2v4H4v-4H2v-6h4v-2z" fill="#1e1224"/>
                                    <path d="M6 12h12v2h2v6H4v-6h2v-2z" fill="#f472b6"/>
                                    <path d="M4 18h16v4H4v-4z" fill="#db2777"/>
                                </svg>
                            </div>

                            <h2 class="font-pixel-title text-base sm:text-lg font-bold text-[#1e1224] mt-2">
                                Pesan Manis Buat <span class="text-[#ff2e93]">Nola</span> ♥
                            </h2>
                            <p class="text-xs text-pink-700 font-medium">
                                Selalu berganti secara acak setiap kali halaman di-refresh ✨
                            </p>
                        </div>

                        <!-- Romantic Quote RPG Dialog Card -->
                        <div class="p-5 sm:p-6 bg-white">
                            <div class="relative bg-pink-50/90 border-3 border-[#1e1224] rounded-2xl p-5 shadow-[4px_4px_0px_#ff2e93]">
                                <!-- Top Quote Corner Ornament -->
                                <div class="flex items-center justify-between mb-3 pb-2 border-b-2 border-dashed border-pink-200">
                                    <span class="font-pixel-ui text-xs font-bold text-[#ff2e93] flex items-center gap-1.5">
                                        <span class="inline-block animate-heart">♥</span>
                                        <span>DAILY LOVE MESSAGE</span>
                                    </span>
                                    <span class="text-[11px] font-pixel-ui bg-white px-2 py-0.5 rounded border border-pink-300 text-pink-700">
                                        From: Mufid
                                    </span>
                                </div>

                                <!-- The Romantic Quote Text -->
                                <blockquote id="romantic-quote-text" class="text-sm sm:text-base font-semibold text-[#1e1224] leading-relaxed min-h-[4.5rem] flex items-center">
                                    “{{ $randomQuote }}”
                                </blockquote>

                                <!-- Bottom Quote Footer & Button to Shuffle Anytime -->
                                <div class="mt-4 pt-3 border-t-2 border-dashed border-pink-200 flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-1 text-pink-500 text-xs font-pixel-ui">
                                        <span>♥</span><span>♥</span><span>♥</span>
                                        <span class="text-pink-700 ml-1">100% Sayang Nola</span>
                                    </div>
                                    <button
                                        type="button"
                                        id="btn-next-quote"
                                        class="pixel-btn bg-[#ff2e93] hover:bg-[#e01b7b] text-white text-xs font-pixel-ui font-bold px-3.5 py-1.5 rounded-full flex items-center gap-1.5"
                                    >
                                        <span>✦</span>
                                        <span>Pesan Cinta Lainnya</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Cute Daily Reminders for Nola (Like Pixo Bottom Feature Cards) -->
                            <div class="grid grid-cols-3 gap-2.5 mt-4">
                                <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-2.5 text-center shadow-[2px_2px_0px_#f472b6]">
                                    <div class="text-base">🍱</div>
                                    <div class="font-pixel-ui text-xs font-bold text-pink-800 mt-0.5">Makan Teratur</div>
                                    <div class="text-[11px] text-pink-600">Jangan telat yaa</div>
                                </div>
                                <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-2.5 text-center shadow-[2px_2px_0px_#f472b6]">
                                    <div class="text-base">💧</div>
                                    <div class="font-pixel-ui text-xs font-bold text-pink-800 mt-0.5">Minum Air</div>
                                    <div class="text-[11px] text-pink-600">Biar tetap segar</div>
                                </div>
                                <div class="bg-pink-50 border-2 border-[#1e1224] rounded-xl p-2.5 text-center shadow-[2px_2px_0px_#f472b6]">
                                    <div class="text-base">💖</div>
                                    <div class="font-pixel-ui text-xs font-bold text-pink-800 mt-0.5">Tetap Senyum</div>
                                    <div class="text-[11px] text-pink-600">Nola manis banget</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- ==================================================== -->
                <!-- SISI KANAN (7 KOLOM): FORM & PERHITUNGAN MEMANJANG   -->
                <!-- ==================================================== -->
                <section class="lg:col-span-7 space-y-6">

                    <!-- Card 1: Form Cari Bahan Makanan & Berat (Gaya Pixo Search Card) -->
                    <div class="pixel-card p-5 sm:p-6">
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                            <div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-[#ff2e93] text-white border-2 border-[#1e1224] flex items-center justify-center font-pixel-title text-sm shadow-[2px_2px_0px_#1e1224]">
                                    ✦
                                </span>
                                <div>
                                    <h2 class="font-pixel-title text-sm sm:text-base font-bold text-[#1e1224]">
                                        Hitung Zat Gizi Makanan
                                    </h2>
                                    <p class="text-xs text-slate-500">Pilih versi acuan (TKPI 2019 / 2020), bahan pangan, dan beratnya (gram)</p>
                                </div>
                            </div>

                            <!-- Quick Pixel Version Pill Switcher (Opsi A) -->
                            <div class="inline-flex items-center bg-pink-50 border-2 border-[#1e1224] rounded-xl p-1 shadow-[2px_2px_0px_#f472b6]">
                                <button
                                    type="button"
                                    data-switch-tahun="2019"
                                    class="btn-tahun-pill px-3 py-1 rounded-lg text-xs font-pixel-ui font-bold transition {{ ($tahun ?? '2020') === '2019' ? 'bg-[#ff2e93] text-white border border-[#1e1224] shadow-[1px_1px_0px_#1e1224]' : 'text-pink-800 hover:bg-pink-100' }}"
                                >
                                    TKPI 2019
                                </button>
                                <button
                                    type="button"
                                    data-switch-tahun="2020"
                                    class="btn-tahun-pill px-3 py-1 rounded-lg text-xs font-pixel-ui font-bold transition {{ ($tahun ?? '2020') === '2020' ? 'bg-[#ff2e93] text-white border border-[#1e1224] shadow-[1px_1px_0px_#1e1224]' : 'text-pink-800 hover:bg-pink-100' }}"
                                >
                                    TKPI 2020 ✦
                                </button>
                            </div>
                        </div>

                        <form id="calc-form" action="{{ route('calculator.calculate') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end">
                            <div class="sm:col-span-3">
                                <label for="select-tahun" class="block text-xs font-pixel-ui uppercase tracking-wide font-bold text-pink-800 mb-1.5">
                                    ★ Versi Acuan TKPI
                                </label>
                                <select id="select-tahun" name="tahun" class="pixel-input w-full font-bold text-sm cursor-pointer">
                                    <option value="2020" {{ ($tahun ?? '2020') === '2020' ? 'selected' : '' }}>TKPI 2020 (Terbaru)</option>
                                    <option value="2019" {{ ($tahun ?? '2020') === '2019' ? 'selected' : '' }}>TKPI 2019</option>
                                </select>
                            </div>

                            <div class="sm:col-span-5">
                                <label for="select-bahan" class="block text-xs font-pixel-ui uppercase tracking-wide font-bold text-pink-800 mb-1.5">
                                    ♥ Cari &amp; Pilih Bahan Makanan (TKPI {{ $tahun ?? '2020' }})
                                </label>
                                <select id="select-bahan" name="ingredient_id" required placeholder="Ketik nama bahan atau kode TKPI...">
                                    <option value="">-- Ketik untuk mencari bahan --</option>
                                    @foreach($ingredients as $item)
                                        <option value="{{ $item->id }}" {{ (isset($selected) && $selected->id == $item->id) ? 'selected' : '' }}>
                                            [{{ $item->kode_tkpi }}] {{ $item->nama_bahan }} (BDD: {{ $item->bdd }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="berat-input" class="block text-xs font-pixel-ui uppercase tracking-wide font-bold text-pink-800 mb-1.5">
                                    ✦ Berat (g)
                                </label>
                                <input
                                    id="berat-input"
                                    type="number"
                                    step="0.1"
                                    min="0.1"
                                    name="berat"
                                    value="{{ $beratInput ?? '' }}"
                                    placeholder="100"
                                    required
                                    class="pixel-input w-full font-semibold"
                                >
                            </div>

                            <div class="sm:col-span-2">
                                <button
                                    type="submit"
                                    class="pixel-btn w-full min-h-[48px] bg-[#ff2e93] hover:bg-[#e01b7b] text-white font-pixel-ui font-bold py-2.5 px-3 rounded-xl text-sm flex items-center justify-center gap-1"
                                >
                                    <span>Hitung</span>
                                    <span>♥</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Card 2: Hasil Perhitungan Gizi Memanjang ke Bawah di Sisi Kanan -->
                    @if(isset($hasil))
                        <div class="pixel-card overflow-hidden">
                            <!-- Header Hasil Bahan Makanan -->
                            <div class="bg-gradient-to-r from-pink-100 via-pink-50 to-white p-5 sm:p-6 border-b-3 border-[#1e1224]">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div>
                                        <div class="inline-flex flex-wrap items-center gap-2">
                                            <span class="text-xs font-pixel-title font-bold uppercase bg-[#ff2e93] text-white px-3 py-1 rounded-lg border-2 border-[#1e1224] shadow-[2px_2px_0px_#1e1224]">
                                                KODE TKPI: {{ $hasil['kode_tkpi'] }}
                                            </span>
                                            <span class="text-xs font-pixel-ui font-bold uppercase bg-pink-600 text-white px-2.5 py-1 rounded-lg border-2 border-[#1e1224]">
                                                EDISI TKPI {{ $hasil['tahun'] ?? ($selected->tahun ?? ($tahun ?? '2020')) }}
                                            </span>
                                            <span class="text-xs font-pixel-ui font-bold uppercase bg-white text-pink-700 px-2.5 py-1 rounded-lg border-2 border-pink-300">
                                                Protein {{ ucfirst($selected->kategori_protein) }}
                                            </span>
                                        </div>
                                        <h3 class="text-xl sm:text-2xl font-extrabold text-[#1e1224] mt-2.5">
                                            {{ $hasil['nama_bahan'] }}
                                        </h3>
                                    </div>

                                    <div class="bg-white p-3.5 rounded-xl border-2 border-[#1e1224] shadow-[3px_3px_0px_#f472b6] text-xs sm:text-sm shrink-0">
                                        <div class="flex items-center justify-between gap-4 text-slate-600">
                                            <span>Berat Kotor:</span>
                                            <strong class="text-[#1e1224] font-bold">{{ $hasil['berat_awal'] }} g</strong>
                                        </div>
                                        <div class="flex items-center justify-between gap-4 text-slate-600 mt-1 pt-1 border-t border-pink-100">
                                            <span>BDD ({{ $hasil['bdd_persen'] }}%):</span>
                                            <strong class="text-[#ff2e93] font-bold">{{ $hasil['berat_bdd'] }} g bersih</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4 Kartu Ringkasan Makronutrien Utama -->
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5">
                                    <div class="bg-white border-2 border-[#1e1224] rounded-xl p-3 shadow-[3px_3px_0px_#ff2e93]">
                                        <div class="text-[11px] font-pixel-ui font-bold uppercase text-pink-600">♥ Energi Kalori</div>
                                        <div class="text-lg sm:text-xl font-extrabold text-[#ff2e93] mt-0.5">{{ $hasil['kalori'] }} <span class="text-xs font-semibold">kkal</span></div>
                                    </div>
                                    <div class="bg-white border-2 border-[#1e1224] rounded-xl p-3 shadow-[3px_3px_0px_#f472b6]">
                                        <div class="text-[11px] font-pixel-ui font-bold uppercase text-pink-600">✦ Protein ({{ $selected->kategori_protein === 'hewani' ? 'H' : 'N' }})</div>
                                        <div class="text-lg sm:text-xl font-extrabold text-[#1e1224] mt-0.5">
                                            {{ $selected->kategori_protein === 'hewani' ? $hasil['protein_h'] : $hasil['protein_n'] }}
                                            <span class="text-xs font-semibold">g</span>
                                        </div>
                                    </div>
                                    <div class="bg-white border-2 border-[#1e1224] rounded-xl p-3 shadow-[3px_3px_0px_#f472b6]">
                                        <div class="text-[11px] font-pixel-ui font-bold uppercase text-pink-600">✿ Lemak</div>
                                        <div class="text-lg sm:text-xl font-extrabold text-[#1e1224] mt-0.5">{{ $hasil['lemak'] }} <span class="text-xs font-semibold">g</span></div>
                                    </div>
                                    <div class="bg-white border-2 border-[#1e1224] rounded-xl p-3 shadow-[3px_3px_0px_#f472b6]">
                                        <div class="text-[11px] font-pixel-ui font-bold uppercase text-pink-600">★ Karbohidrat</div>
                                        <div class="text-lg sm:text-xl font-extrabold text-[#1e1224] mt-0.5">{{ $hasil['kh'] }} <span class="text-xs font-semibold">g</span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel Rincian Lengkap Zat Gizi Memanjang ke Bawah -->
                            <div class="p-5 sm:p-6 bg-white">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-pixel-title text-xs sm:text-sm font-bold text-pink-800 uppercase">
                                        ♥ Tabel Rincian Lengkap Zat Gizi (15 Parameter • TKPI {{ $hasil['tahun'] ?? ($selected->tahun ?? ($tahun ?? '2020')) }})
                                    </h4>
                                    <span class="text-xs text-slate-400">Scroll ke bawah untuk detail lengkap</span>
                                </div>

                                <div class="table-wrapper">
                                    <table class="nutrition-table text-left">
                                        <thead>
                                            <tr class="bg-pink-100 border-b-2 border-pink-300 text-pink-950 text-xs sm:text-sm font-pixel-ui">
                                                <th scope="col" class="py-3 px-4 font-bold">Zat Gizi</th>
                                                <th scope="col" class="py-3 px-4 font-bold">Hasil Perhitungan</th>
                                                <th scope="col" class="py-3 px-4 font-bold">Satuan</th>
                                                <th scope="col" class="py-3 px-4 text-pink-700 font-normal">Nilai Asli / 100g BDD</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-pink-100 text-slate-700 text-sm">
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Berat Bahan</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['berat_awal'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">100 g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">BDD (Berat Dapat Dimakan)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['bdd_persen'] }}</td>
                                                <td class="py-3 px-4">%</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $hasil['bdd_persen'] }} %</td>
                                            </tr>
                                            <tr class="row-highlight bg-pink-50/70">
                                                <th scope="row" class="py-3 px-4 font-bold text-[#ff2e93]">♥ Kalori (Energi)</th>
                                                <td class="py-3 px-4 font-extrabold text-[#ff2e93] text-base">{{ $hasil['kalori'] }}</td>
                                                <td class="py-3 px-4 font-semibold text-pink-700">kkal</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->kalori }} kkal</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Protein Hewani (h)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['protein_h'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->kategori_protein == 'hewani' ? $selected->protein : 0 }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Protein Nabati (n)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['protein_n'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->kategori_protein == 'nabati' ? $selected->protein : 0 }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Lemak</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['lemak'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->lemak }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Karbohidrat (KH)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['kh'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->kh }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Kalsium (Ca)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['ca'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->ca }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Fosfor (P)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['p'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->p }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Besi (Fe)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['fe'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->fe }} g</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Natrium (Na)</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['natrium'] }}</td>
                                                <td class="py-3 px-4">miligram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->natrium ?? 0 }} mg</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Vitamin A</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['vit_a'] }}</td>
                                                <td class="py-3 px-4">UI</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->vit_a }} UI</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Vitamin B1</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['vit_b1'] }}</td>
                                                <td class="py-3 px-4">miligram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->vit_b1 }} mg</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Vitamin C</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['vit_c'] }}</td>
                                                <td class="py-3 px-4">miligram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->vit_c }} mg</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="py-3 px-4 font-semibold text-[#1e1224]">Air</th>
                                                <td class="py-3 px-4 font-bold text-[#1e1224]">{{ $hasil['air'] }}</td>
                                                <td class="py-3 px-4">gram</td>
                                                <td class="py-3 px-4 text-slate-400">{{ $selected->air }} g</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Empty State Saat Belum Memilih Bahan Makanan -->
                        <div class="pixel-card-pink p-8 sm:p-10 text-center">
                            <div class="w-16 h-16 mx-auto rounded-2xl bg-white border-3 border-[#1e1224] shadow-[4px_4px_0px_#ff2e93] flex items-center justify-center mb-4 animate-heart">
                                <svg class="w-9 h-9 text-[#ff2e93]" viewBox="0 0 16 16" fill="currentColor">
                                    <path d="M2 4h4v2h4V4h4v4h-2v2h-2v2H6v-2H4V8H2V4z"/>
                                </svg>
                            </div>
                            <h3 class="font-pixel-title text-base sm:text-lg font-bold text-[#1e1224]">
                                Belum Ada Bahan Makanan yang Dipilih ♥
                            </h3>
                            <p class="text-sm text-pink-900/80 max-w-md mx-auto mt-2">
                                Silakan pilih bahan makanan dan masukkan berat (gram) pada kotak di atas, lalu klik tombol <strong>Hitung Gizi ♥</strong>. Hasil rincian gizinya akan muncul memanjang ke bawah di sisi kanan ini!
                            </p>
                        </div>
                    @endif

                </section>
            </div>
        @endif

    </main>

    <!-- Bottom Stepped Pink Pixel Wave Footer (Matching Pixo Aesthetic) -->
    <footer class="relative z-10 mt-10">
        <!-- Pixelated stepped top edge -->
        <div class="w-full overflow-hidden leading-none" aria-hidden="true">
            <svg class="w-full h-6 sm:h-8 text-[#ff2e93]" viewBox="0 0 120 12" preserveAspectRatio="none" fill="currentColor">
                <path d="M0 8h6V6h6V4h8v2h6v2h8V6h6V2h10v4h6v2h8V4h8v2h6v2h10V6h8V4h8v2h8v2h8v4H0V8z"/>
            </svg>
        </div>
        <div class="bg-[#ff2e93] text-white py-5 px-4 border-t-2 border-[#1e1224]">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs font-pixel-ui">
                <div class="flex items-center gap-2">
                    <span>♥</span>
                    <span>{{ $currentUser ? 'MADE WITH PIXEL LOVE BY MUFID ESPECIAL FOR NOLA' : 'MADE WITH PIXEL LOVE • TKPI 2019 & 2020' }}</span>
                    <span>♥</span>
                </div>
                <div class="text-pink-100">
                    Tabel Komposisi Pangan Indonesia (TKPI) 2019 &amp; 2020 • PostgreSQL Supabase
                </div>
            </div>
        </div>
    </footer>

    <!-- Inisialisasi TomSelect, Switcher Versi TKPI & Tombol Acak Kata Romantis -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectEl = document.getElementById('select-bahan');
            if (selectEl) {
                new TomSelect('#select-bahan', {
                    create: false,
                    maxOptions: 100,
                    sortField: {
                        field: 'text',
                        direction: 'asc'
                    },
                    placeholder: 'Ketik nama bahan atau kode TKPI...'
                });
            }

            const calcForm = document.getElementById('calc-form');
            const selectTahun = document.getElementById('select-tahun');
            const beratInput = document.getElementById('berat-input');
            const indexUrl = @json(route('calculator.index'));

            function handleTahunSwitch(targetTahun) {
                if (!selectTahun) return;
                selectTahun.value = targetTahun;
                if (calcForm && selectEl && selectEl.value && beratInput && beratInput.value) {
                    calcForm.submit();
                } else {
                    window.location.href = indexUrl + '?tahun=' + encodeURIComponent(targetTahun);
                }
            }

            if (selectTahun) {
                selectTahun.addEventListener('change', function () {
                    handleTahunSwitch(this.value);
                });
            }

            document.querySelectorAll('.btn-tahun-pill').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetTahun = this.getAttribute('data-switch-tahun');
                    if (targetTahun) {
                        handleTahunSwitch(targetTahun);
                    }
                });
            });

            const quotes = @json($quotes ?? []);
            const quoteEl = document.getElementById('romantic-quote-text');
            const nextQuoteBtn = document.getElementById('btn-next-quote');

            if (nextQuoteBtn && quoteEl && quotes.length > 1) {
                nextQuoteBtn.addEventListener('click', function () {
                    const current = quoteEl.textContent.replace(/^[“"]|[”"]$/g, '').trim();
                    let next = current;
                    while (next === current) {
                        next = quotes[Math.floor(Math.random() * quotes.length)];
                    }
                    quoteEl.style.opacity = '0';
                    setTimeout(function () {
                        quoteEl.textContent = '“' + next + '”';
                        quoteEl.style.transition = 'opacity 0.25s ease';
                        quoteEl.style.opacity = '1';
                    }, 150);
                });
            }
        });
    </script>

</body>
</html>