@extends('layouts.app')

@section('title', 'Master Sport | Контакты')
@section('description', 'Контакты магазина Master Sport в Ижевске.')

@section('content')
    @php
        $address = $siteContactsByKey->get('address_main')?->value;
        $mapQuery = rawurlencode($address ?: 'Ижевск, ул. Пушкинская, 268');
    @endphp

    <section class="section">
        <div class="container contacts-grid">
            <article class="panel">
                <h1>Контакты</h1>
                <p>Если нужен подбор размера или информация по заказу, удобнее всего писать в почту или звонить.</p>

                <ul class="contact-list">
                    @forelse ($siteContacts as $contact)
                        <li>
                            <span>{{ $contact->label }}</span>
                            @if ($contact->resolved_href)
                                <a href="{{ $contact->resolved_href }}">{{ $contact->value }}</a>
                            @else
                                <b>{{ $contact->value }}</b>
                            @endif
                        </li>
                    @empty
                        <li>
                            <span>Контакты</span>
                            <b>Контакты пока не добавлены.</b>
                        </li>
                    @endforelse
                </ul>
            </article>

            <article class="panel">
                <h2>Как добраться</h2>
                <p>Магазин находится в центре. Можно подъехать на личном авто или общественном транспорте.</p>
                <div class="map-box">
                    <iframe
                        title="Карта Master Sport"
                        src="https://yandex.ru/map-widget/v1/?text={{ $mapQuery }}&z=16"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen="true"
                    ></iframe>
                </div>
            </article>
        </div>
    </section>
@endsection
