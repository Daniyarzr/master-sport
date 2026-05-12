<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Sport | Магазин спортивной одежды</title>
        <meta
            name="description"
            content="Master Sport - современный магазин спортивной одежды: новинки, популярные коллекции, экипировка для зала и улицы."
        >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Unbounded:wght@500;700&display=swap"
            rel="stylesheet"
        >
        <style>
            :root {
                --ms-bg: #ecf2f9;
                --ms-white: #ffffff;
                --ms-blue-900: #0f2a46;
                --ms-blue-700: #155dbc;
                --ms-blue-500: #2f8bff;
                --ms-orange: #ff7a1f;
                --ms-graphite: #202a35;
                --ms-muted: #677487;
                --ms-line: #d8e4f2;
                --ms-radius: 20px;
                --ms-shadow: 0 18px 44px rgba(12, 31, 52, 0.12);
            }

            * {
                box-sizing: border-box;
            }

            html,
            body {
                margin: 0;
                padding: 0;
                min-height: 100%;
            }

            body {
                font-family: "Manrope", "Segoe UI", sans-serif;
                color: var(--ms-graphite);
                background:
                    radial-gradient(circle at 8% 0%, rgba(47, 139, 255, 0.24), transparent 44%),
                    radial-gradient(circle at 96% 4%, rgba(255, 122, 31, 0.2), transparent 36%),
                    var(--ms-bg);
                line-height: 1.45;
                overflow-x: hidden;
            }

            body::before {
                content: "";
                position: fixed;
                inset: 0;
                pointer-events: none;
                background-image: linear-gradient(transparent 95%, rgba(255, 255, 255, 0.45) 96%);
                background-size: 100% 34px;
                opacity: 0.45;
                z-index: -1;
            }

            .container {
                width: min(1160px, calc(100% - 2rem));
                margin: 0 auto;
            }

            .announce {
                background: linear-gradient(92deg, var(--ms-blue-900), #163f6f);
                color: #e7f1ff;
                font-size: 0.88rem;
                padding: 0.65rem 0;
                text-align: center;
                letter-spacing: 0.03em;
            }

            .announce strong {
                color: #ffffff;
                font-weight: 800;
            }

            .site-header {
                position: sticky;
                top: 14px;
                z-index: 12;
                padding-top: 1rem;
            }

            .nav-shell {
                display: flex;
                gap: 1rem;
                align-items: center;
                justify-content: space-between;
                background: rgba(255, 255, 255, 0.88);
                border: 1px solid rgba(216, 228, 242, 0.9);
                border-radius: 18px;
                backdrop-filter: blur(10px);
                box-shadow: 0 12px 24px rgba(16, 38, 61, 0.08);
                padding: 0.85rem 1rem;
            }

            .brand {
                display: inline-flex;
                align-items: center;
                gap: 0.7rem;
                text-decoration: none;
                color: var(--ms-graphite);
            }

            .brand-mark {
                width: 34px;
                height: 34px;
                border-radius: 10px;
                background: linear-gradient(140deg, var(--ms-blue-500), #1d4f8c 68%, var(--ms-orange));
                box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.5);
            }

            .brand-text {
                font-family: "Unbounded", "Segoe UI", sans-serif;
                font-size: 1.05rem;
                letter-spacing: 0.02em;
            }

            .nav-links {
                display: flex;
                flex-wrap: wrap;
                gap: 0.6rem;
                justify-content: center;
            }

            .nav-links a {
                color: #2d3a4b;
                text-decoration: none;
                padding: 0.45rem 0.8rem;
                border-radius: 999px;
                font-size: 0.95rem;
                transition: background-color 0.2s ease, color 0.2s ease;
            }

            .nav-links a:hover {
                background: #eaf3ff;
                color: var(--ms-blue-700);
            }

            .nav-actions {
                display: flex;
                gap: 0.6rem;
                align-items: center;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.45rem;
                text-decoration: none;
                border-radius: 999px;
                padding: 0.58rem 1rem;
                font-weight: 700;
                font-size: 0.92rem;
                transition: transform 0.25s ease, box-shadow 0.25s ease, background-color 0.25s ease;
            }

            .btn:hover {
                transform: translateY(-1px);
            }

            .btn-outline {
                color: var(--ms-blue-700);
                border: 1px solid #bdd8fa;
                background: #f8fbff;
            }

            .btn-outline:hover {
                box-shadow: 0 7px 15px rgba(21, 93, 188, 0.16);
            }

            .btn-primary {
                color: #fff;
                background: linear-gradient(120deg, var(--ms-orange), #ff9348);
                box-shadow: 0 12px 22px rgba(255, 122, 31, 0.32);
            }

            .hero {
                padding: 1rem 0 2rem;
            }

            .hero-grid {
                display: grid;
                grid-template-columns: 1.16fr 0.84fr;
                gap: 1.2rem;
                align-items: stretch;
            }

            .hero-copy,
            .hero-panel {
                border-radius: var(--ms-radius);
                box-shadow: var(--ms-shadow);
            }

            .hero-copy {
                background: #fff;
                padding: 2.1rem;
                border: 1px solid var(--ms-line);
                position: relative;
                overflow: hidden;
            }

            .hero-copy::after {
                content: "";
                position: absolute;
                inset: auto -58px -58px auto;
                width: 200px;
                height: 200px;
                border-radius: 40px;
                background: linear-gradient(145deg, rgba(47, 139, 255, 0.2), rgba(255, 122, 31, 0.24));
                transform: rotate(18deg);
            }

            .tag {
                display: inline-flex;
                align-items: center;
                gap: 0.45rem;
                background: #edf5ff;
                color: var(--ms-blue-700);
                border-radius: 999px;
                padding: 0.3rem 0.7rem;
                font-weight: 700;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }

            .hero-copy h1 {
                margin: 1.1rem 0 0.9rem;
                font-family: "Unbounded", "Segoe UI", sans-serif;
                font-size: clamp(1.95rem, 3vw, 3rem);
                line-height: 1.14;
                color: #10263d;
            }

            .hero-copy p {
                margin: 0;
                max-width: 47ch;
                color: var(--ms-muted);
                font-size: 1.02rem;
            }

            .hero-actions {
                margin-top: 1.6rem;
                display: flex;
                flex-wrap: wrap;
                gap: 0.7rem;
            }

            .hero-stats {
                margin-top: 1.7rem;
                display: grid;
                gap: 0.7rem;
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .hero-stats div {
                background: #f7fbff;
                border: 1px solid #dbe9f8;
                border-radius: 14px;
                padding: 0.72rem;
            }

            .hero-stats strong {
                display: block;
                font-size: 1.06rem;
                color: var(--ms-blue-900);
            }

            .hero-stats span {
                color: var(--ms-muted);
                font-size: 0.82rem;
            }

            .hero-panel {
                padding: 1.5rem;
                background: linear-gradient(152deg, #102f4f, #1f5ea4 56%, #367ee9);
                color: #f0f6ff;
                position: relative;
                overflow: hidden;
            }

            .hero-panel::before,
            .hero-panel::after {
                content: "";
                position: absolute;
                border-radius: 36px;
                transform: rotate(21deg);
            }

            .hero-panel::before {
                width: 210px;
                height: 210px;
                right: -95px;
                top: -88px;
                background: rgba(255, 255, 255, 0.14);
            }

            .hero-panel::after {
                width: 180px;
                height: 180px;
                left: -72px;
                bottom: -95px;
                background: rgba(255, 122, 31, 0.22);
            }

            .panel-content {
                position: relative;
                z-index: 1;
            }

            .panel-kicker {
                color: #a6cbff;
                font-weight: 700;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.09em;
            }

            .panel-title {
                margin: 0.8rem 0 0.5rem;
                font-family: "Unbounded", "Segoe UI", sans-serif;
                font-size: 1.42rem;
                line-height: 1.24;
            }

            .panel-copy {
                margin: 0;
                color: #daebff;
                max-width: 26ch;
                font-size: 0.95rem;
            }

            .panel-box {
                margin-top: 1.35rem;
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.26);
                border-radius: 14px;
                padding: 0.88rem;
                display: flex;
                justify-content: space-between;
                gap: 0.7rem;
            }

            .panel-box span {
                font-size: 0.84rem;
                color: #d8ebff;
            }

            .panel-box strong {
                font-size: 1.15rem;
                color: #fff;
            }

            .promo-banner {
                padding: 1.3rem 0 2rem;
            }

            .promo-frame {
                position: relative;
                min-height: clamp(460px, 68vh, 640px);
                border-radius: 26px;
                overflow: hidden;
                border: 1px solid rgba(189, 216, 250, 0.58);
                box-shadow: 0 28px 54px rgba(10, 33, 56, 0.3);
                background: #142f4a;
            }

            .promo-image {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }

            .promo-overlay {
                position: absolute;
                inset: 0;
                background:
                    linear-gradient(108deg, rgba(6, 22, 38, 0.9) 8%, rgba(9, 30, 48, 0.16) 52%),
                    linear-gradient(0deg, rgba(5, 19, 33, 0.55), rgba(5, 19, 33, 0.55));
            }

            .promo-overlay::before {
                content: "";
                position: absolute;
                inset: 12% auto auto 4%;
                width: 46%;
                height: 42%;
                border-radius: 38px;
                background: linear-gradient(160deg, rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0.08));
                transform: skewX(-17deg);
                opacity: 0.7;
            }

            .promo-content {
                position: relative;
                z-index: 1;
                height: 100%;
                min-height: clamp(460px, 68vh, 640px);
                padding: clamp(1.4rem, 3vw, 2.6rem);
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                max-width: 680px;
                color: #ecf4ff;
            }

            .promo-kicker {
                display: inline-flex;
                width: fit-content;
                align-items: center;
                border-radius: 999px;
                padding: 0.26rem 0.68rem;
                background: rgba(47, 139, 255, 0.24);
                border: 1px solid rgba(176, 213, 255, 0.5);
                text-transform: uppercase;
                letter-spacing: 0.08em;
                font-size: 0.78rem;
                font-weight: 700;
            }

            .promo-title {
                margin: 0.95rem 0 0.6rem;
                font-family: "Unbounded", "Segoe UI", sans-serif;
                font-size: clamp(1.7rem, 4vw, 3.2rem);
                line-height: 1.12;
                color: #ffffff;
            }

            .promo-copy {
                margin: 0;
                max-width: 40ch;
                color: #d5eaff;
                font-size: clamp(0.96rem, 1.8vw, 1.12rem);
            }

            .promo-actions {
                margin-top: 1.1rem;
                display: flex;
                gap: 0.65rem;
                flex-wrap: wrap;
            }

            .promo-stats {
                margin-top: 1rem;
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.6rem;
                width: min(560px, 100%);
            }

            .promo-stats div {
                border: 1px solid rgba(192, 220, 252, 0.38);
                background: rgba(15, 44, 72, 0.45);
                backdrop-filter: blur(3px);
                border-radius: 14px;
                padding: 0.66rem 0.72rem;
            }

            .promo-stats strong {
                display: block;
                font-size: 1rem;
                color: #ffffff;
                margin-bottom: 0.15rem;
            }

            .promo-stats span {
                color: #cbe3ff;
                font-size: 0.82rem;
            }

            .section {
                padding: 1.5rem 0;
            }

            .section-head {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 0.8rem;
                margin-bottom: 0.95rem;
            }

            .section h2 {
                margin: 0;
                font-family: "Unbounded", "Segoe UI", sans-serif;
                color: #12283f;
                font-size: clamp(1.35rem, 1.9vw, 1.95rem);
            }

            .section p {
                margin: 0;
                color: var(--ms-muted);
            }

            .collection-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 0.9rem;
            }

            .collection-card {
                border-radius: 18px;
                padding: 1.1rem;
                border: 1px solid var(--ms-line);
                background: #fff;
                box-shadow: var(--ms-shadow);
                position: relative;
                overflow: hidden;
            }

            .collection-card::after {
                content: "";
                position: absolute;
                width: 120px;
                height: 120px;
                border-radius: 28px;
                right: -44px;
                bottom: -52px;
                transform: rotate(26deg);
                opacity: 0.65;
            }

            .collection-card.blue::after {
                background: linear-gradient(135deg, rgba(47, 139, 255, 0.26), rgba(21, 93, 188, 0.44));
            }

            .collection-card.orange::after {
                background: linear-gradient(135deg, rgba(255, 122, 31, 0.24), rgba(255, 145, 51, 0.38));
            }

            .collection-card.graphite::after {
                background: linear-gradient(135deg, rgba(40, 51, 64, 0.22), rgba(112, 131, 153, 0.34));
            }

            .collection-card strong {
                position: relative;
                z-index: 1;
                display: block;
                color: #0f2a46;
                margin-bottom: 0.45rem;
                font-size: 1.08rem;
            }

            .collection-card p,
            .collection-card ul {
                position: relative;
                z-index: 1;
            }

            .collection-card ul {
                margin: 0.8rem 0 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.34rem;
                font-size: 0.88rem;
                color: #4f5e72;
            }

            .collection-card li::before {
                content: "•";
                color: var(--ms-orange);
                margin-right: 0.43rem;
            }

            .new-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 0.9rem;
            }

            .product-card {
                border-radius: 18px;
                border: 1px solid var(--ms-line);
                background: #fff;
                overflow: hidden;
                box-shadow: 0 12px 24px rgba(9, 30, 53, 0.09);
                transition: transform 0.24s ease;
            }

            .product-card:hover {
                transform: translateY(-4px);
            }

            .product-cover {
                height: 164px;
                position: relative;
                overflow: hidden;
            }

            .product-cover::before,
            .product-cover::after {
                content: "";
                position: absolute;
                border-radius: 50%;
                filter: blur(0.5px);
            }

            .cover-blue {
                background: linear-gradient(155deg, #cce2ff 18%, #2f8bff 110%);
            }

            .cover-graphite {
                background: linear-gradient(155deg, #d8dee6 12%, #6b7f99 118%);
            }

            .cover-orange {
                background: linear-gradient(155deg, #ffe1c8 20%, #ff9a50 114%);
            }

            .cover-night {
                background: linear-gradient(155deg, #d7e8ff 18%, #2f3d4c 115%);
            }

            .product-cover::before {
                width: 115px;
                height: 115px;
                background: rgba(255, 255, 255, 0.34);
                left: -34px;
                top: -36px;
            }

            .product-cover::after {
                width: 150px;
                height: 150px;
                background: rgba(255, 255, 255, 0.25);
                right: -55px;
                bottom: -58px;
            }

            .product-body {
                padding: 0.86rem;
            }

            .product-meta {
                display: flex;
                justify-content: space-between;
                gap: 0.7rem;
                align-items: center;
                margin-bottom: 0.5rem;
            }

            .badge {
                display: inline-flex;
                align-items: center;
                border-radius: 999px;
                padding: 0.2rem 0.55rem;
                font-size: 0.75rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .badge-new {
                color: #fff;
                background: var(--ms-orange);
            }

            .badge-hit {
                color: #1452a3;
                background: #ddebff;
            }

            .product-price {
                color: #112e4b;
                font-weight: 800;
                font-size: 1rem;
            }

            .product-title {
                margin: 0 0 0.6rem;
                color: #162c42;
                font-weight: 700;
                font-size: 0.98rem;
            }

            .service-grid {
                display: grid;
                grid-template-columns: 1.2fr 0.8fr;
                gap: 0.9rem;
            }

            .service-card,
            .contact-card {
                border-radius: 18px;
                border: 1px solid var(--ms-line);
                background: #fff;
                box-shadow: var(--ms-shadow);
                padding: 1.1rem;
            }

            .service-list {
                margin: 0.95rem 0 0;
                padding: 0;
                list-style: none;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.72rem;
            }

            .service-list li {
                border: 1px solid #dfebf7;
                background: #f7fbff;
                border-radius: 13px;
                padding: 0.78rem;
            }

            .service-list strong {
                display: block;
                color: #153a61;
                margin-bottom: 0.3rem;
                font-size: 0.94rem;
            }

            .contact-links {
                margin: 0.9rem 0 0;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 0.53rem;
            }

            .contact-links a {
                color: #153e6a;
                text-decoration: none;
                font-weight: 700;
            }

            .contact-links a:hover {
                color: var(--ms-orange);
            }

            .mini-note {
                margin-top: 1rem;
                border-radius: 12px;
                border: 1px dashed #bfd8f7;
                background: #f4f9ff;
                padding: 0.7rem 0.8rem;
                color: #48627e;
                font-size: 0.86rem;
            }

            footer {
                padding: 2rem 0 2.2rem;
            }

            .footer-shell {
                border-radius: 16px;
                padding: 1.05rem;
                background: #132b45;
                color: #d7e9ff;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.8rem;
                flex-wrap: wrap;
            }

            .footer-links {
                display: flex;
                gap: 0.8rem;
                flex-wrap: wrap;
            }

            .footer-links a {
                color: #ecf4ff;
                text-decoration: none;
                font-size: 0.9rem;
            }

            .footer-links a:hover {
                color: #ffbe8f;
            }

            .reveal {
                opacity: 0;
                transform: translateY(18px);
                animation: rise 0.7s ease forwards;
            }

            .reveal-1 {
                animation-delay: 0.08s;
            }

            .reveal-2 {
                animation-delay: 0.18s;
            }

            .reveal-3 {
                animation-delay: 0.28s;
            }

            .reveal-4 {
                animation-delay: 0.36s;
            }

            @keyframes rise {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 1040px) {
                .hero-grid,
                .service-grid {
                    grid-template-columns: 1fr;
                }

                .promo-frame,
                .promo-content {
                    min-height: 500px;
                }

                .promo-stats {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .new-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 760px) {
                .container {
                    width: min(1160px, calc(100% - 1.2rem));
                }

                .site-header {
                    position: static;
                    padding-top: 0.65rem;
                }

                .nav-shell {
                    padding: 0.78rem;
                    gap: 0.7rem;
                    flex-direction: column;
                    align-items: stretch;
                }

                .nav-links {
                    justify-content: flex-start;
                }

                .nav-actions {
                    justify-content: flex-start;
                    flex-wrap: wrap;
                }

                .hero {
                    padding-top: 1.4rem;
                }

                .hero-copy {
                    padding: 1.35rem;
                }

                .promo-frame,
                .promo-content {
                    min-height: 420px;
                }

                .promo-content {
                    padding: 1.2rem;
                }

                .promo-overlay::before {
                    width: 70%;
                    height: 40%;
                    inset: 10% auto auto -8%;
                }

                .promo-stats {
                    grid-template-columns: 1fr;
                }

                .hero-stats {
                    grid-template-columns: 1fr;
                }

                .collection-grid,
                .new-grid,
                .service-list {
                    grid-template-columns: 1fr;
                }

                .section-head {
                    flex-direction: column;
                    align-items: flex-start;
                    margin-bottom: 0.8rem;
                }
            }
        </style>
    </head>
    <body>
        @php
            $loginUrl = \Illuminate\Support\Facades\Route::has('login') ? route('login') : '#';
            $cabinetUrl = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : '#';
        @endphp

        <div class="announce">
            Бесплатная доставка по РФ при заказе от <strong>7 000 ₽</strong> | Новая коллекция уже в наличии
        </div>

        <header class="site-header">
            <div class="container">
                <div class="nav-shell reveal reveal-1">
                    <a class="brand" href="#">
                        <span class="brand-mark" aria-hidden="true"></span>
                        <span class="brand-text">MASTER SPORT</span>
                    </a>

                    <nav class="nav-links" aria-label="Главное меню">
                        <a href="#top">Главная</a>
                        <a href="#popular">Популярное</a>
                        <a href="#new">Новинки</a>
                        <a href="#contacts">Контакты</a>
                    </nav>

                    <div class="nav-actions">
                        <a class="btn btn-outline" href="{{ $loginUrl }}">Вход</a>
                        <a class="btn btn-primary" href="{{ $cabinetUrl }}">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </header>

        <main id="top">
            <section class="promo-banner reveal reveal-2" aria-label="Промо баннер">
                <div class="container">
                    <article class="promo-frame">
                        <img
                            class="promo-image"
                            src="{{ asset('images/master-sport-banner.png') }}"
                            alt="Промо коллекция Master Sport"
                        >
                        <div class="promo-overlay" aria-hidden="true"></div>

                        <div class="promo-content">
                            <span class="promo-kicker">Move. Perform. Inspire.</span>
                            <h2 class="promo-title">Одежда для тех, кто живёт в движении</h2>
                            <p class="promo-copy">
                                Новый дроп для спорта и активной жизни: выразительный стиль, технологичные ткани и комфорт
                                на каждый день.
                            </p>
                            <div class="promo-actions">
                                <a class="btn btn-primary" href="#new">Смотреть дроп</a>
                                <a class="btn btn-outline" href="#popular">Подобрать коллекцию</a>
                            </div>
                            <div class="promo-stats">
                                <div>
                                    <strong>Spring 2026</strong>
                                    <span>новый сезон</span>
                                </div>
                                <div>
                                    <strong>72 часа</strong>
                                    <span>ограниченный запуск</span>
                                </div>
                                <div>
                                    <strong>-20%</strong>
                                    <span>по промокоду MOVE</span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="hero">
                <div class="container hero-grid">
                    <article class="hero-copy reveal reveal-3">
                        <span class="tag">Новая коллекция 2026</span>
                        <h1>Экипировка, которая двигается в твоём темпе.</h1>
                        <p>
                            Минималистичная спортивная одежда с технологичными тканями и точной посадкой. Коллекции для
                            бега, фитнеса и городского стиля в цветах синего, графитового и оранжевого.
                        </p>

                        <div class="hero-actions">
                            <a class="btn btn-primary" href="#new">Смотреть новинки</a>
                            <a class="btn btn-outline" href="#popular">Популярные коллекции</a>
                        </div>

                        <div class="hero-stats">
                            <div>
                                <strong>420+</strong>
                                <span>моделей в каталоге</span>
                            </div>
                            <div>
                                <strong>24 часа</strong>
                                <span>на отправку заказа</span>
                            </div>
                            <div>
                                <strong>4.9/5</strong>
                                <span>оценка клиентов</span>
                            </div>
                        </div>
                    </article>

                    <aside class="hero-panel reveal reveal-4">
                        <div class="panel-content">
                            <span class="panel-kicker">Капсула сезона</span>
                            <h2 class="panel-title">Velocity Drop<br>Blue Graphite</h2>
                            <p class="panel-copy">
                                Капсула из худи, джоггеров и компрессионных футболок. Доступны размеры XS-XXL.
                            </p>
                            <div class="panel-box">
                                <div>
                                    <span>Старт цены</span>
                                    <strong>2 990 ₽</strong>
                                </div>
                                <a class="btn btn-outline" href="#new">В каталог</a>
                            </div>
                        </div>
                    </aside>
                </div>
            </section>

            <section class="section" id="popular">
                <div class="container">
                    <div class="section-head reveal reveal-1">
                        <h2>Популярные коллекции</h2>
                        <p>Топ-направления этого сезона</p>
                    </div>

                    <div class="collection-grid">
                        <article class="collection-card blue reveal reveal-2">
                            <strong>Running Core</strong>
                            <p>Лёгкие слои для пробежек в любую погоду.</p>
                            <ul>
                                <li>Дышащие материалы Dry Flow</li>
                                <li>Светоотражающие детали</li>
                                <li>От 3 490 ₽</li>
                            </ul>
                        </article>

                        <article class="collection-card orange reveal reveal-3">
                            <strong>Gym Motion</strong>
                            <p>Гибкая посадка и комфорт для силовых тренировок.</p>
                            <ul>
                                <li>4-way stretch ткань</li>
                                <li>Поддержка и компрессия</li>
                                <li>От 2 690 ₽</li>
                            </ul>
                        </article>

                        <article class="collection-card graphite reveal reveal-4">
                            <strong>Urban Sport</strong>
                            <p>Минимализм для города: спорт и casual в одном образе.</p>
                            <ul>
                                <li>Сдержанная графитовая палитра</li>
                                <li>Новые oversize формы</li>
                                <li>От 3 190 ₽</li>
                            </ul>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="new">
                <div class="container">
                    <div class="section-head reveal reveal-1">
                        <h2>Новинки недели</h2>
                        <p>Свежие позиции уже доступны в магазине</p>
                    </div>

                    <div class="new-grid">
                        <article class="product-card reveal reveal-2">
                            <div class="product-cover cover-blue"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge badge-new">NEW</span>
                                    <span class="product-price">3 690 ₽</span>
                                </div>
                                <p class="product-title">Футболка Aero Fit Blue</p>
                                <a class="btn btn-outline" href="#">Подробнее</a>
                            </div>
                        </article>

                        <article class="product-card reveal reveal-3">
                            <div class="product-cover cover-graphite"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge badge-hit">Хит</span>
                                    <span class="product-price">4 490 ₽</span>
                                </div>
                                <p class="product-title">Худи Flex Graphite</p>
                                <a class="btn btn-outline" href="#">Подробнее</a>
                            </div>
                        </article>

                        <article class="product-card reveal reveal-4">
                            <div class="product-cover cover-orange"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge badge-new">NEW</span>
                                    <span class="product-price">2 990 ₽</span>
                                </div>
                                <p class="product-title">Шорты Sprint Orange</p>
                                <a class="btn btn-outline" href="#">Подробнее</a>
                            </div>
                        </article>

                        <article class="product-card reveal reveal-4">
                            <div class="product-cover cover-night"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge badge-hit">Хит</span>
                                    <span class="product-price">5 290 ₽</span>
                                </div>
                                <p class="product-title">Куртка Storm Night</p>
                                <a class="btn btn-outline" href="#">Подробнее</a>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="contacts">
                <div class="container service-grid">
                    <article class="service-card reveal reveal-2">
                        <h2>Почему выбирают Master Sport</h2>
                        <p>Собрали всё важное для удобного и быстрого запуска магазина.</p>
                        <ul class="service-list">
                            <li>
                                <strong>Быстрая доставка</strong>
                                Отправляем заказы в день оплаты.
                            </li>
                            <li>
                                <strong>Примерка и возврат</strong>
                                14 дней на обмен и возврат.
                            </li>
                            <li>
                                <strong>Подбор размера</strong>
                                Онлайн-таблица и помощь менеджера.
                            </li>
                            <li>
                                <strong>Подарочные сертификаты</strong>
                                Электронные и физические карты.
                            </li>
                        </ul>
                    </article>

                    <aside class="contact-card reveal reveal-3">
                        <h2>Контакты</h2>
                        <p>Свяжитесь с нами любым удобным способом.</p>
                        <ul class="contact-links">
                            <li><a href="tel:+78005553535">+7 (800) 555-35-35</a></li>
                            <li><a href="mailto:hello@mastersport.ru">hello@mastersport.ru</a></li>
                            <li><a href="#">Telegram канал</a></li>
                            <li><a href="#">VK сообщество</a></li>
                        </ul>
                        <div class="mini-note">Пн-Вс: 09:00-21:00. Поддержка отвечает в чате в среднем за 5 минут.</div>
                    </aside>
                </div>
            </section>
        </main>

        <footer>
            <div class="container">
                <div class="footer-shell">
                    <span>© 2026 Master Sport. Спортивная одежда для движения каждый день.</span>
                    <div class="footer-links">
                        <a href="#">Политика конфиденциальности</a>
                        <a href="#">Доставка и оплата</a>
                        <a href="#">Публичная оферта</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
