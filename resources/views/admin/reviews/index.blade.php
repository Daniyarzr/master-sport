@extends('layouts.admin')
@section('title', 'Модерация отзывов | Админ')

@section('admin')
    <section class="section">
        <div class="container">
            <article class="panel admin-card">
                <div class="section-head">
                    <h1>Отзывы</h1>
                    <span>Всего: {{ $reviews->total() }}</span>
                </div>

                <form method="GET" action="{{ route('admin.reviews.index') }}" class="filter-actions">
                    <label class="field">
                        <span>Статус</span>
                        <select name="status">
                            <option value="">Все статусы</option>
                            <option value="pending" @selected(request('status') === 'pending')>На модерации</option>
                            <option value="approved" @selected(request('status') === 'approved')>Одобренные</option>
                            <option value="rejected" @selected(request('status') === 'rejected')>Отклонённые</option>
                            <option value="spam" @selected(request('status') === 'spam')>Спам</option>
                        </select>
                    </label>

                    <label class="field">
                        <span>Поиск</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Текст отзыва или товар">
                    </label>

                    <button class="btn btn-orange" type="submit">Применить</button>
                    <a class="btn btn-light" href="{{ route('admin.reviews.index') }}">Сбросить</a>
                </form>

                <form method="POST" action="{{ route('admin.reviews.bulk') }}" id="bulkForm">
                    @csrf
                    <div id="bulkReviewIds"></div>

                    <div class="admin-bulk-actions">
                        <label class="admin-checkbox" for="checkAll">
                            <input type="checkbox" id="checkAll">
                            <span>Выбрать все</span>
                        </label>

                        <div class="admin-inline-actions">
                            <button type="submit" name="action" value="approve" class="btn btn-light admin-btn-small" onclick="return confirm('Одобрить выбранные отзывы?')">Одобрить</button>
                            <button type="submit" name="action" value="reject" class="btn btn-dark admin-btn-small" onclick="return confirm('Отклонить выбранные отзывы?')">Отклонить</button>
                            <button type="submit" name="action" value="spam" class="btn btn-light admin-btn-small" onclick="return confirm('Пометить выбранные отзывы как спам?')">Спам</button>
                        </div>
                    </div>
                </form>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 42px;"></th>
                                <th>Товар</th>
                                <th>Автор</th>
                                <th>Текст</th>
                                <th>Оценка</th>
                                <th>Статус</th>
                                <th>Дата</th>
                                <th style="width: 230px;">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                @php
                                    $statusMap = [
                                        'pending' => ['label' => 'На модерации', 'class' => 'is-pending'],
                                        'approved' => ['label' => 'Одобрен', 'class' => 'is-approved'],
                                        'rejected' => ['label' => 'Отклонён', 'class' => 'is-rejected'],
                                        'spam' => ['label' => 'Спам', 'class' => 'is-spam'],
                                    ];
                                    $statusView = $statusMap[$review->status] ?? ['label' => $review->status, 'class' => ''];
                                @endphp

                                <tr class="admin-review-row {{ $review->status === 'pending' ? 'is-pending' : '' }}">
                                    <td>
                                        <input type="checkbox" value="{{ $review->id }}" class="review-check">
                                    </td>
                                    <td>
                                        @if ($review->product)
                                            <a class="admin-review-product" href="{{ route('catalog.show', $review->product->slug) }}" target="_blank" rel="noopener noreferrer">
                                                {{ Str::limit($review->product->name, 30) }}
                                            </a>
                                        @else
                                            <span class="field-hint">Товар удалён</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->getAuthorName() }}</td>
                                    <td class="admin-review-content">{{ Str::limit($review->content, 120) }}</td>
                                    <td>
                                        <div class="review-stars" aria-label="Оценка {{ $review->rating }} из 5">
                                            @for ($star = 1; $star <= 5; $star++)
                                                <span class="{{ $star <= $review->rating ? 'is-filled' : '' }}">★</span>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        <span class="review-status-badge {{ $statusView['class'] }}">{{ $statusView['label'] }}</span>
                                    </td>
                                    <td>{{ $review->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if ($review->status === 'pending')
                                            <div class="admin-inline-actions">
                                                <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-light admin-btn-small" type="submit">Одобрить</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-dark admin-btn-small" type="submit">Отклонить</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reviews.spam', $review) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="btn btn-light admin-btn-small" type="submit">Спам</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="field-hint">Статус обновлён</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="empty-message">
                                        @if (request()->hasAny(['status', 'search']))
                                            Ничего не найдено. <a href="{{ route('admin.reviews.index') }}">Сбросить фильтры</a>
                                        @else
                                            Отзывов пока нет.
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="pager">
                        {{ $reviews->withQueryString()->links() }}
                    </div>
                @endif
            </article>
        </div>
    </section>

    <script>
        (() => {
            const checkAll = document.getElementById('checkAll');
            const bulkForm = document.getElementById('bulkForm');
            if (!checkAll || !bulkForm) {
                return;
            }

            checkAll.addEventListener('change', () => {
                document.querySelectorAll('.review-check').forEach((checkbox) => {
                    checkbox.checked = checkAll.checked;
                });
            });

            bulkForm.addEventListener('submit', (event) => {
                const checked = document.querySelectorAll('.review-check:checked');
                if (!checked.length) {
                    event.preventDefault();
                    alert('Выберите хотя бы один отзыв.');
                    return;
                }

                const hiddenContainer = document.getElementById('bulkReviewIds');
                if (!hiddenContainer) {
                    return;
                }

                hiddenContainer.innerHTML = '';
                checked.forEach((checkbox) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'review_ids[]';
                    input.value = checkbox.value;
                    hiddenContainer.appendChild(input);
                });
            });
        })();
    </script>
@endsection
