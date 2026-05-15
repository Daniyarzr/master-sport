<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Master Sport | Каталог</title>
        <meta
            name="description"
            content="Каталог Master Sport: фильтрация по коллекциям, полу и цене. Подбери спортивный образ под свой стиль."
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
            $loginUrl = route('login');
            $cabinetUrl = auth()->check() && auth()->user()->isAdmin()
                ? route('admin.dashboard')
                : route('login');

            $products = [
                ['name' => 'Aero Fit Tee Blue', 'collection' => 'run', 'collection_label' => 'Running Core', 'gender' => 'unisex', 'gender_label' => 'Унисекс', 'price' => 3690, 'tone' => 'tone-blue', 'badge' => 'new', 'badge_class' => 'new', 'meta' => 'Дышащая футболка Dry Flow для темповых тренировок.'],
                ['name' => 'Flex Hoodie Graphite', 'collection' => 'urban', 'collection_label' => 'Urban Flex', 'gender' => 'male', 'gender_label' => 'Мужское', 'price' => 4490, 'tone' => 'tone-graphite', 'badge' => 'hit', 'badge_class' => 'hit', 'meta' => 'Худи oversize с мягким футером и плотным капюшоном.'],
                ['name' => 'Sprint Shorts Orange', 'collection' => 'gym', 'collection_label' => 'Gym Motion', 'gender' => 'female', 'gender_label' => 'Женское', 'price' => 2990, 'tone' => 'tone-orange', 'badge' => 'new', 'badge_class' => 'new', 'meta' => 'Эластичные шорты с внутренней компрессией.'],
                ['name' => 'Storm Shell Night', 'collection' => 'outdoor', 'collection_label' => 'Outdoor Shift', 'gender' => 'unisex', 'gender_label' => 'Унисекс', 'price' => 5290, 'tone' => 'tone-night', 'badge' => 'drop', 'badge_class' => 'drop', 'meta' => 'Легкая влагозащитная ветровка для города и трека.'],
                ['name' => 'Pulse Bra Mint', 'collection' => 'gym', 'collection_label' => 'Gym Motion', 'gender' => 'female', 'gender_label' => 'Женское', 'price' => 2590, 'tone' => 'tone-mint', 'badge' => 'new', 'badge_class' => 'new', 'meta' => 'Спортивный топ со средней поддержкой и мягкой посадкой.'],
                ['name' => 'Velocity Joggers', 'collection' => 'urban', 'collection_label' => 'Urban Flex', 'gender' => 'male', 'gender_label' => 'Мужское', 'price' => 4190, 'tone' => 'tone-graphite', 'badge' => 'hit', 'badge_class' => 'hit', 'meta' => 'Джоггеры с анатомичным кроем и водоотталкивающим слоем.'],
                ['name' => 'Track Longsleeve Air', 'collection' => 'run', 'collection_label' => 'Running Core', 'gender' => 'unisex', 'gender_label' => 'Унисекс', 'price' => 3390, 'tone' => 'tone-blue', 'badge' => 'drop', 'badge_class' => 'drop', 'meta' => 'Лонгслив с защитой от солнца и термобалансом.'],
                ['name' => 'Core Leggings Black', 'collection' => 'gym', 'collection_label' => 'Gym Motion', 'gender' => 'female', 'gender_label' => 'Женское', 'price' => 3890, 'tone' => 'tone-night', 'badge' => 'hit', 'badge_class' => 'hit', 'meta' => 'Высокая посадка, эластичный пояс и мягкая компрессия.'],
                ['name' => 'Urban Vest Slate', 'collection' => 'urban', 'collection_label' => 'Urban Flex', 'gender' => 'unisex', 'gender_label' => 'Унисекс', 'price' => 4890, 'tone' => 'tone-graphite', 'badge' => 'drop', 'badge_class' => 'drop', 'meta' => 'Легкий жилет с несколькими карманами и clean-дизайном.'],
                ['name' => 'Trail Wind Jacket', 'collection' => 'outdoor', 'collection_label' => 'Outdoor Shift', 'gender' => 'male', 'gender_label' => 'Мужское', 'price' => 6390, 'tone' => 'tone-mint', 'badge' => 'new', 'badge_class' => 'new', 'meta' => 'Компактная куртка с вентиляцией для активных выходов.'],
                ['name' => 'Motion Crop Top', 'collection' => 'gym', 'collection_label' => 'Gym Motion', 'gender' => 'female', 'gender_label' => 'Женское', 'price' => 2390, 'tone' => 'tone-orange', 'badge' => 'new', 'badge_class' => 'new', 'meta' => 'Кроп-топ из мягкой ткани с эффектом second skin.'],
                ['name' => 'Reflective Run Cap', 'collection' => 'run', 'collection_label' => 'Running Core', 'gender' => 'unisex', 'gender_label' => 'Унисекс', 'price' => 1990, 'tone' => 'tone-blue', 'badge' => 'hit', 'badge_class' => 'hit', 'meta' => 'Кепка с перфорацией и светоотражающей вставкой.'],
            ];
        @endphp

        <div class="top-ribbon">
            Каталог обновлен сегодня: новый дроп + restock по размерам <strong>XS-XXL</strong>
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
                        <a class="is-active" href="{{ route('catalog') }}">Каталог</a>
                        <a href="{{ route('home') }}#collections">Коллекции</a>
                        <a href="{{ route('contacts') }}">Контакты</a>
                    </nav>

                    <div class="nav-actions">
                        <a class="btn btn-outline" href="{{ $loginUrl }}">Вход</a>
                        <a class="btn btn-primary" href="{{ $cabinetUrl }}">Личный кабинет</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="catalog-main">
            <section class="section">
                <div class="container">
                    <article class="catalog-hero-card" data-reveal>
                        <span class="eyebrow">Каталог Master Sport</span>
                        <h1>Подбери экипировку под цель, стиль и бюджет.</h1>
                        <p>
                            Фильтруй товары по коллекциям, полу и цене. Введи название в поиск и быстро собери комплект
                            для тренировки, города или активного отдыха.
                        </p>
                        <div class="hero-actions">
                            <a class="btn btn-primary" href="{{ route('home') }}#new">Смотреть новинки</a>
                            <span class="count-pill">Фильтры работают прямо на странице</span>
                        </div>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="container catalog-shell">
                    <aside class="filters" data-reveal>
                        <h2>Фильтры</h2>

                        <div class="filter-group">
                            <label for="catalogSearch">Поиск по товарам</label>
                            <input
                                id="catalogSearch"
                                class="search-input"
                                type="search"
                                placeholder="Например: худи, шорты, куртка..."
                            >
                        </div>

                        <div class="filter-group">
                            <label for="collectionFilter">Коллекция</label>
                            <select id="collectionFilter" class="select-input">
                                <option value="all">Все коллекции</option>
                                <option value="run">Running Core</option>
                                <option value="gym">Gym Motion</option>
                                <option value="urban">Urban Flex</option>
                                <option value="outdoor">Outdoor Shift</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Пол</label>
                            <div class="filter-chips" id="genderFilter">
                                <button type="button" class="chip is-active" data-gender="all">Все</button>
                                <button type="button" class="chip" data-gender="male">Мужское</button>
                                <button type="button" class="chip" data-gender="female">Женское</button>
                                <button type="button" class="chip" data-gender="unisex">Унисекс</button>
                            </div>
                        </div>

                        <div class="filter-group">
                            <label>Цена, ₽</label>
                            <div class="price-inputs">
                                <input
                                    id="priceFrom"
                                    class="search-input"
                                    type="number"
                                    min="0"
                                    step="100"
                                    placeholder="От"
                                >
                                <input
                                    id="priceTo"
                                    class="search-input"
                                    type="number"
                                    min="0"
                                    step="100"
                                    placeholder="До"
                                >
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline" id="resetFilters">Сбросить фильтры</button>
                    </aside>

                    <div class="catalog-content">
                        <div class="catalog-toolbar" data-reveal>
                            <h2>Товары</h2>
                            <span class="count-pill">Найдено: <strong id="catalogCount">0</strong></span>
                        </div>

                        <div class="catalog-grid" id="catalogGrid">
                            @foreach ($products as $product)
                                <article
                                    class="product-card"
                                    data-reveal
                                    data-product-card
                                    data-name="{{ $product['name'] }}"
                                    data-collection="{{ $product['collection'] }}"
                                    data-gender="{{ $product['gender'] }}"
                                    data-price="{{ $product['price'] }}"
                                >
                                    <div class="product-cover {{ $product['tone'] }}"></div>
                                    <div class="product-body">
                                        <div class="product-meta">
                                            <span class="badge {{ $product['badge_class'] }}">{{ $product['badge'] }}</span>
                                            <span class="product-price">{{ number_format($product['price'], 0, ',', ' ') }} ₽</span>
                                        </div>
                                        <h3>{{ $product['name'] }}</h3>
                                        <p>{{ $product['meta'] }}</p>
                                        <div class="pill-row">
                                            <span class="mini-pill">{{ $product['collection_label'] }}</span>
                                            <span class="mini-pill">{{ $product['gender_label'] }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <p class="empty-message" id="emptyState" hidden>
                            По этим фильтрам ничего не найдено. Проверь диапазон цены или выбери другую коллекцию.
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="footer-shell">
                    <span>© 2026 Master Sport. Включай движение в каждом образе.</span>
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
                const cards = Array.from(document.querySelectorAll("[data-product-card]"));
                const searchInput = document.getElementById("catalogSearch");
                const collectionFilter = document.getElementById("collectionFilter");
                const genderButtons = Array.from(document.querySelectorAll("[data-gender]"));
                const priceFrom = document.getElementById("priceFrom");
                const priceTo = document.getElementById("priceTo");
                const resetFilters = document.getElementById("resetFilters");
                const countNode = document.getElementById("catalogCount");
                const emptyState = document.getElementById("emptyState");

                const prices = cards.map((card) => Number(card.dataset.price));
                const minCatalogPrice = Math.min(...prices);
                const maxCatalogPrice = Math.max(...prices);
                let selectedGender = "all";

                const applyFilters = () => {
                    const query = searchInput.value.trim().toLowerCase();
                    const selectedCollection = collectionFilter.value;
                    const fromValue = Number(priceFrom.value);
                    const toValue = Number(priceTo.value);

                    const minPrice = Number.isFinite(fromValue) && fromValue > 0 ? fromValue : minCatalogPrice;
                    const maxPrice = Number.isFinite(toValue) && toValue > 0 ? toValue : maxCatalogPrice;
                    const priceLower = Math.min(minPrice, maxPrice);
                    const priceUpper = Math.max(minPrice, maxPrice);

                    let visibleCount = 0;

                    cards.forEach((card) => {
                        const name = card.dataset.name.toLowerCase();
                        const collection = card.dataset.collection;
                        const gender = card.dataset.gender;
                        const price = Number(card.dataset.price);

                        const byName = !query || name.includes(query);
                        const byCollection = selectedCollection === "all" || selectedCollection === collection;
                        const byGender = selectedGender === "all" || selectedGender === gender;
                        const byPrice = price >= priceLower && price <= priceUpper;

                        const visible = byName && byCollection && byGender && byPrice;
                        card.hidden = !visible;

                        if (visible) {
                            visibleCount += 1;
                        }
                    });

                    countNode.textContent = String(visibleCount);
                    emptyState.hidden = visibleCount > 0;
                };

                const urlParams = new URLSearchParams(window.location.search);
                const collectionFromQuery = urlParams.get("collection");
                if (collectionFromQuery && collectionFilter.querySelector(`option[value="${collectionFromQuery}"]`)) {
                    collectionFilter.value = collectionFromQuery;
                }

                priceFrom.placeholder = `От ${minCatalogPrice}`;
                priceTo.placeholder = `До ${maxCatalogPrice}`;

                searchInput.addEventListener("input", applyFilters);
                collectionFilter.addEventListener("change", applyFilters);
                priceFrom.addEventListener("input", applyFilters);
                priceTo.addEventListener("input", applyFilters);

                genderButtons.forEach((button) => {
                    button.addEventListener("click", () => {
                        selectedGender = button.dataset.gender;
                        genderButtons.forEach((item) => item.classList.remove("is-active"));
                        button.classList.add("is-active");
                        applyFilters();
                    });
                });

                resetFilters.addEventListener("click", () => {
                    searchInput.value = "";
                    collectionFilter.value = "all";
                    selectedGender = "all";
                    priceFrom.value = "";
                    priceTo.value = "";
                    genderButtons.forEach((item) => item.classList.remove("is-active"));
                    const allButton = genderButtons.find((item) => item.dataset.gender === "all");
                    if (allButton) {
                        allButton.classList.add("is-active");
                    }
                    applyFilters();
                });

                applyFilters();

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
