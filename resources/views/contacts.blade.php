<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Sport | Контакты</title>
        <meta
            name="description"
            content="Контакты Master Sport: телефон, email, VK-группа и адрес магазина в Ижевске."
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
            Контакты Master Sport в Ижевске: отвечаем ежедневно с <strong>09:00 до 21:00</strong>
        </div>

        <header class="site-header">
            <div class="container">
                <div class="nav-shell">
                    <a class="brand" href="{{ route('home') }}">
                        <span class="brand-mark" aria-hidden="true"></span>
                        <span class="brand-text">MASTER SPORT</span>
                    </a>

                    <nav class="nav-links" aria-label="Главное меню">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('catalog') }}">Каталог</a>
                        <a href="{{ route('home') }}#collections">Коллекции</a>
                        <a class="is-active" href="{{ route('contacts') }}">Контакты</a>
                    </nav>

                    <div class="nav-actions">
                        <a class="btn btn-outline" href="{{ $loginUrl }}">Вход</a>
                        <a class="btn btn-primary" href="{{ $cabinetUrl }}">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="section">
                <div class="container">
                    <article class="catalog-hero-card" data-reveal>
                        <span class="eyebrow">Контакты</span>
                        <h1>Магазин Master Sport в Ижевске</h1>
                        <p>
                            Здесь можно посмотреть адрес на карте, написать на почту или связаться по телефону.
                            Формы обратной связи нет, только прямые контакты.
                        </p>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="container contacts-layout">
                    <article class="contacts-info" data-reveal>
                        <h2>Контактные данные</h2>
                        <ul class="contacts-list">
                            <li>
                                <span>Телефон</span>
                                <a href="tel:+73412900000">+7 (3412) 90-00-00</a>
                            </li>
                            <li>
                                <span>Почта</span>
                                <a href="mailto:hello@mastersport.ru">hello@mastersport.ru</a>
                            </li>
                            <li>
                                <span>VK-группа</span>
                                <a href="https://vk.com/mastersport" target="_blank" rel="noopener noreferrer">
                                    vk.com/mastersport
                                </a>
                            </li>
                            <li>
                                <span>Адрес</span>
                                <p>г. Ижевск, ул. Пушкинская, 268</p>
                            </li>
                        </ul>
                    </article>

                    <aside class="contacts-map" data-reveal>
                        <h2>Карта</h2>
                        <div class="map-frame">
                            <iframe
                                title="Карта магазина Master Sport в Ижевске"
                                src="https://www.google.com/maps?q=%D0%98%D0%B6%D0%B5%D0%B2%D1%81%D0%BA%2C%20%D1%83%D0%BB.%20%D0%9F%D1%83%D1%88%D0%BA%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%2C%20268&z=16&output=embed"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                    </aside>
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
