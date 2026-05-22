<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewModerationController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user', 'moderator'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('content', 'like', '%'.$request->search.'%')
                  ->orWhereHas('product', fn($qq) => $qq->where('name', 'like', '%'.$request->search.'%'));
            });
        }

        $reviews = $query->paginate(20)->withQueryString();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => Review::STATUS_APPROVED,
            'approved_at' => now(),
            'moderated_at' => now(),
            'moderated_by' => Auth::id(),
        ]);
        return back()->with('success', 'Отзыв одобрен.');
    }

    public function reject(Review $review, Request $request)
    {
        $review->update([
            'status' => Review::STATUS_REJECTED,
            'moderated_at' => now(),
            'moderated_by' => Auth::id(),
            'moderator_note' => $request->note,
        ]);
        return back()->with('info', 'Отзыв отклонён.');
    }

    public function markSpam(Review $review)
    {
        $review->update([
            'status' => Review::STATUS_SPAM,
            'moderated_at' => now(),
            'moderated_by' => Auth::id(),
        ]);
        return back()->with('warning', 'Отзыв помечен как спам.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,spam,delete',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);

        $count = 0;
        foreach ($request->review_ids as $id) {
            $review = Review::find($id);
            if (!$review) continue;

            match ($request->action) {
                'approve' => $review->update([
                    'status' => Review::STATUS_APPROVED,
                    'approved_at' => now(),
                    'moderated_at' => now(),
                    'moderated_by' => Auth::id(),
                ]),
                'reject' => $review->update([
                    'status' => Review::STATUS_REJECTED,
                    'moderated_at' => now(),
                    'moderated_by' => Auth::id(),
                ]),
                'spam' => $review->update([
                    'status' => Review::STATUS_SPAM,
                    'moderated_at' => now(),
                    'moderated_by' => Auth::id(),
                ]),
                'delete' => $review->delete(),
            };
            $count++;
        }

        return back()->with('success', "Обработано отзывов: {$count}");
    }
}