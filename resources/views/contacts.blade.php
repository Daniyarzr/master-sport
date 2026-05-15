@extends('layouts.app')

@section('title', 'Master Sport | Контакты')
@section('description', 'Контакты магазина Master Sport в Ижевске.')

@section('content')
    <section class="section">
        <div class="container contacts-grid">
            <article class="panel">
                <h1>Контакты</h1>
                <p>Если нужен подбор размера или информация по заказу, удобнее всего писать в почту или звонить.</p>

                <ul class="contact-list">
                    <li>
                        <span>Телефон</span>
                        <a href="tel:+73412900000">+7 (3412) 90-00-00</a>
                    </li>
                    <li>
                        <span>Email</span>
                        <a href="mailto:hello@mastersport.ru">hello@mastersport.ru</a>
                    </li>
                    <li>
                        <span>Адрес</span>
                        <b>г. Ижевск, ул. Пушкинская, 268</b>
                    </li>
                    <li>
                        <span>Режим работы</span>
                        <b>Ежедневно с 09:00 до 21:00</b>
                    </li>
                </ul>
            </article>

            <article class="panel">
                <h2>Как добраться</h2>
                <p>Магазин находится в центре. Можно подъехать на личном авто или общественном транспорте.</p>
                <div class="map-box">
                    <iframe
                        title="Карта Master Sport"
                        src="https://yandex.ru/map-widget/v1/?text=%D0%98%D0%B6%D0%B5%D0%B2%D1%81%D0%BA%2C%20%D1%83%D0%BB.%20%D0%9F%D1%83%D1%88%D0%BA%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%2C%20268&z=16"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen="true"
                    ></iframe>
                </div>
            </article>
        </div>
    </section>
@endsection
