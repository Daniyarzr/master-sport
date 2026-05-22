@extends('layouts.admin')
@section('title', 'Модерация отзывов')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>📝 Отзывы на модерации</h4>
    <span class="badge bg-warning text-dark">{{ $reviews->total() }} всего</span>
</div>

<!-- Фильтры -->
<form method="GET" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Все статусы</option>
            <option value="pending" {{ request('status')==='pending'?'selected':'' }}>На модерации</option>
            <option value="approved" {{ request('status')==='approved'?'selected':'' }}>Одобренные</option>
            <option value="rejected" {{ request('status')==='rejected'?'selected':'' }}>Отклонённые</option>
            <option value="spam" {{ request('status')==='spam'?'selected':'' }}>Спам</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="text" name="search" class="form-control form-control-sm" 
               placeholder="Поиск..." value="{{ request('search') }}" onchange="this.form.submit()">
    </div>
</form>

<!-- Таблица -->
<form method="POST" action="{{ route('admin.reviews.bulk') }}" id="bulkForm">
    @csrf
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input type="checkbox" id="checkAll" class="form-check-input">
                <label for="checkAll" class="form-check-label">Выбрать все</label>
            </div>
            <div class="btn-group btn-group-sm">
                <button type="submit" name="action" value="approve" class="btn btn-success" onclick="return confirm('Одобрить выбранные?')">✓ Одобрить</button>
                <button type="submit" name="action" value="reject" class="btn btn-danger" onclick="return confirm('Отклонить выбранные?')">✗ Отклонить</button>
                <button type="submit" name="action" value="spam" class="btn btn-warning">🚫 Спам</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="40"><input type="checkbox" class="form-check-input"></th>
                        <th>Товар</th>
                        <th>Автор</th>
                        <th>Текст отзыва</th>
                        <th>⭐</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th width="150">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="{{ $review->status === 'pending' ? 'table-warning' : '' }}">
                            <td><input type="checkbox" name="review_ids[]" value="{{ $review->id }}" class="form-check-input review-check"></td>
                            <td>
                                <a href="{{ route('catalog.show', $review->product->slug) }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($review->product->name, 35) }}
                                </a>
                            </td>
                            <td>{{ $review->getAuthorName() }}</td>
                            <td>{{ Str::limit($review->content, 80) }}</td>
                            <td>{{ str_repeat('★', $review->rating) }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'pending' => ['class' => 'warning', 'text' => 'На модерации'],
                                        'approved' => ['class' => 'success', 'text' => 'Одобрен'],
                                        'rejected' => ['class' => 'danger', 'text' => 'Отклонён'],
                                        'spam' => ['class' => 'secondary', 'text' => 'Спам']
                                    ];
                                    $badge = $badges[$review->status] ?? ['class' => 'light', 'text' => $review->status];
                                @endphp
                                <span class="badge bg-{{ $badge['class'] }}">{{ $badge['text'] }}</span>
                            </td>
                            <td>{{ $review->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if($review->status === 'pending')
                                    <div class="btn-group-vertical btn-group-sm">
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="d-inline mb-1">
                                            @csrf
                                            <button class="btn btn-outline-success btn-sm">✓ Одобрить</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="d-inline">
                                            @csrf 
                                            <button class="btn btn-outline-danger btn-sm">✗ Отклонить</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                @if(request()->hasAny(['status','search']))
                                    Ничего не найдено. <a href="{{ route('admin.reviews.index') }}">Сбросить фильтры</a>
                                @else
                                    Отзывов для модерации нет 🎉
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $reviews->withQueryString()->links() }}
        </div>
    </div>
</form>

<script>
document.getElementById('checkAll')?.addEventListener('change', function() {
    document.querySelectorAll('.review-check').forEach(cb => cb.checked = this.checked);
});

document.getElementById('bulkForm')?.addEventListener('submit', function(e) {
    const checked = document.querySelectorAll('.review-check:checked');
    if(!checked.length) {
        e.preventDefault();
        alert('Выберите хотя бы один отзыв');
        return false;
    }
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'review_ids[]';
        input.value = cb.value;
        this.appendChild(input);
    });
});
</script>
@endsection