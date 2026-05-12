<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Sport | Home</title>
        <meta
            name="description"
            content="Master Sport: спортивная одежда, новые коллекции и стильные капсулы для зала, бега и города."
        >
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Unbounded:wght@500;700&display=swap"
            rel="stylesheet"
        >
        <link rel="stylesheet" href="{{ asset('css/storefront.css') }}">
    </head>
    <body>
        @php
            $loginUrl = \Illuminate\Support\Facades\Route::has('login') ? route('login') : '#';
            $cabinetUrl = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : '#';
        @endphp

        <div class="top-ribbon">
            Бесплатная доставка по РФ от <strong>7 000 ₽</strong> | Новый дроп уже в наличии
        </div>

        <header class="site-header">
            <div class="container">
                <div class="nav-shell">
                    <a class="brand" href="{{ route('home') }}">
                        <span class="brand-mark" aria-hidden="true"></span>
                        <span class="brand-text">MASTER SPORT</span>
                    </a>

                    <nav class="nav-links" aria-label="Главное меню">
                        <a class="is-active" href="{{ route('home') }}">Home</a>
                        <a href="{{ route('catalog') }}">Каталог</a>
                        <a href="#collections">Коллекции</a>
                        <a href="{{ route('contacts') }}">Контакты</a>
                    </nav>

                    <div class="nav-actions">
                        <a class="btn btn-outline" href="{{ $loginUrl }}">Вход</a>
                        <a class="btn btn-primary" href="{{ $cabinetUrl }}">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="full-banner section" aria-label="Промо-баннер">
                <div class="container">
                    <article class="full-banner-frame" data-reveal>
                        <img
                            class="full-banner-image"
                            src="{{ asset('images/master-sport-banner.png') }}"
                            alt="Промо-баннер коллекции Master Sport"
                        >
                        <div class="full-banner-overlay" aria-hidden="true"></div>
                        <div class="full-banner-content">
                            <span class="eyebrow">Move. Perform. Inspire.</span>
                            <h1>Одежда для тех, кто живет в движении</h1>
                            <p>
                                Новый дроп для спорта и активной жизни: выразительный стиль,
                                технологичные ткани и комфорт на каждый день.
                            </p>
                            <div class="hero-actions">
                                <a class="btn btn-primary" href="{{ route('catalog') }}">Смотреть каталог</a>
                                <a class="btn btn-outline" href="#new">Смотреть новинки</a>
                            </div>
                            <div class="full-banner-meta">
                                <span>420+ моделей</span>
                                <span>Доставка 24 часа</span>
                                <span>Скидка до 20%</span>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="container hero-grid">
                    <article class="hero-card" data-reveal>
                        <span class="eyebrow">Spring/Summer 2026</span>
                        <h2>Экип, который качает стиль и комфорт на максимум.</h2>
                        <p>
                            Минималистичные линии, технологичные ткани и насыщенная палитра.
                            Собрали коллекции для бега, зала и города в одном месте.
                        </p>

                        <div class="hero-actions">
                            <a class="btn btn-primary" href="{{ route('catalog') }}">Перейти в каталог</a>
                            <a class="btn btn-outline" href="#collections">Выбрать коллекцию</a>
                        </div>

                        <div class="hero-stats">
                            <div class="stat-box">
                                <strong>420+</strong>
                                <span>моделей в каталоге</span>
                            </div>
                            <div class="stat-box">
                                <strong>24 часа</strong>
                                <span>на отправку заказа</span>
                            </div>
                            <div class="stat-box">
                                <strong>4.9/5</strong>
                                <span>оценка покупателей</span>
                            </div>
                        </div>
                    </article>

                    <aside class="hero-mini-panel" data-reveal>
                        <h3>Капсула сезона</h3>
                        <p class="hero-mini-title">Velocity Drop Blue Graphite</p>
                        <p>
                            Капсула из худи, джоггеров и компрессионных футболок.
                            Размеры XS-XXL, ограниченный запуск.
                        </p>
                        <div class="hero-mini-meta">
                            <span>Старт цены</span>
                            <strong>2 990 ₽</strong>
                        </div>
                        <a class="btn btn-outline" href="{{ route('catalog') }}">В каталог</a>
                    </aside>
                </div>
            </section>

            <section class="section" id="collections">
                <div class="container">
                    <div class="section-head">
                        <h2>Популярные коллекции</h2>
                        <p>Топ-направления этого сезона</p>
                    </div>

                    <div class="collections-grid">
                        <article class="collection-card blue" data-reveal>
                            <h3>Running Core</h3>
                            <p>Легкие дышащие слои и защита от ветра для ежедневных пробежек.</p>
                            <a class="link-inline" href="{{ route('catalog', ['collection' => 'run']) }}">Смотреть в каталоге</a>
                        </article>

                        <article class="collection-card orange" data-reveal>
                            <h3>Gym Motion</h3>
                            <p>Гибкая посадка и 4-way stretch ткани для силовых и функциональных тренировок.</p>
                            <a class="link-inline" href="{{ route('catalog', ['collection' => 'gym']) }}">Смотреть в каталоге</a>
                        </article>

                        <article class="collection-card mint" data-reveal>
                            <h3>Urban Flex</h3>
                            <p>Чистый силуэт, приятные текстуры и легкий спорт-casual для города.</p>
                            <a class="link-inline" href="{{ route('catalog', ['collection' => 'urban']) }}">Смотреть в каталоге</a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="section" id="new">
                <div class="container">
                    <div class="section-head">
                        <h2>Новинки недели</h2>
                        <p>Свежий дроп уже доступен в каталоге</p>
                    </div>

                    <div class="products-grid">
                        <article class="product-card" data-reveal>
                            <div class="product-cover tone-blue"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge new">new</span>
                                    <span class="product-price">3 690 ₽</span>
                                </div>
                                <h3>Aero Fit Tee Blue</h3>
                                <p>Легкая футболка Dry Flow для бега и кардио.</p>
                                <div class="pill-row">
                                    <span class="mini-pill">Running Core</span>
                                    <span class="mini-pill">Унисекс</span>
                                </div>
                            </div>
                        </article>

                        <article class="product-card" data-reveal>
                            <div class="product-cover tone-graphite"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge hit">hit</span>
                                    <span class="product-price">4 490 ₽</span>
                                </div>
                                <h3>Flex Hoodie Graphite</h3>
                                <p>Мягкий худи oversize с утепленным внутренним слоем.</p>
                                <div class="pill-row">
                                    <span class="mini-pill">Urban Flex</span>
                                    <span class="mini-pill">Мужское</span>
                                </div>
                            </div>
                        </article>

                        <article class="product-card" data-reveal>
                            <div class="product-cover tone-orange"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge new">new</span>
                                    <span class="product-price">2 990 ₽</span>
                                </div>
                                <h3>Sprint Shorts Orange</h3>
                                <p>Эластичные шорты с компрессионным внутренним слоем.</p>
                                <div class="pill-row">
                                    <span class="mini-pill">Gym Motion</span>
                                    <span class="mini-pill">Женское</span>
                                </div>
                            </div>
                        </article>

                        <article class="product-card" data-reveal>
                            <div class="product-cover tone-night"></div>
                            <div class="product-body">
                                <div class="product-meta">
                                    <span class="badge drop">drop</span>
                                    <span class="product-price">5 290 ₽</span>
                                </div>
                                <h3>Storm Shell Night</h3>
                                <p>Легкая ветровка с влагозащитой и анатомическим кроем.</p>
                                <div class="pill-row">
                                    <span class="mini-pill">Outdoor Shift</span>
                                    <span class="mini-pill">Унисекс</span>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
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

        <script>
            (() => {
                const revealItems = document.querySelectorAll("[data-reveal]");
                if (!revealItems.length || !("IntersectionObserver" in window)) {
                    revealItems.forEach((item) => item.classList.add("is-visible"));
                    return;
                }

                const observer = new IntersectionObserver(
                    (entries, obs) => {
                        entries.forEach((entry) => {
                            if (!entry.isIntersecting) {
                                return;
                            }
                            entry.target.classList.add("is-visible");
                            obs.unobserve(entry.target);
                        });
                    },
                    { threshold: 0.14 }
                );

                revealItems.forEach((item) => observer.observe(item));
            })();
        </script>
    </body>
</html>
