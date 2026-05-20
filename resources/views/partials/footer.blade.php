<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <strong>Master Sport</strong>
            <p>Спортивная одежда на каждый день: футболки, шорты, худи и сезонные коллекции.</p>
        </div>

        <div class="footer-links">
            <a href="{{ route('catalog') }}">Каталог</a>
            <a href="{{ route('stocks.index') }}">Акции</a>
            @auth
                <a href="{{ route('cart.index') }}">Корзина</a>
            @else
                <a href="{{ route('login') }}">Корзина</a>
            @endauth
            <a href="{{ route('contacts') }}">Контакты</a>
            @auth
                <a href="{{ route('dashboard') }}">ЛК</a>
            @else
                <a href="{{ route('register') }}">Регистрация</a>
            @endauth
        </div>
    </div>
</footer>
