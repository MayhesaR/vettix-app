@extends('layouts.app')

@section('title', 'Review')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - Edit Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { border-radius: 15px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-vettix { background-color: #00c2cb; color: white; border: none; }
        .btn-vettix:hover { background-color: #00a8af; color: white; }
        .rating-stars {
            display: flex;
            gap: 10px;
            font-size: 2rem;
        }
        .rating-stars input[type="radio"] {
            display: none;
        }
        .rating-stars label {
            cursor: pointer;
            color: #ddd;
            transition: color 0.2s;
        }
        .rating-stars input[type="radio"]:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #fbbf24;
        }
        .rating-stars {
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
    </style>
</head>
@section('title')
<div class="d-flex align-items-center mb-0">
        <div>
            <h4 class="fw-bold text-dark mb-0">Edit Review</h4>
            <h4 class="text-muted small mb-0" style="font-size: 15px; height: 7px;">Ubah detail review</h4>
        </div>

        <div class="ms-auto">
            <button class="btn btn-light btn-sm"><i class="fa-regular fa-bell"></i></button>
            <button class="btn btn-light btn-sm"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
@endsection
@section('content')
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card form-card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <a href="{{ route('reviews.index') }}" class="btn btn-light btn-sm me-3">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <h4 class="fw-bold mb-0">Edit Review Event</h4>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Event <span class="text-danger">*</span></label>
                            <select name="event_id" class="form-select" required>
                                <option value="">-- Pilih Event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ $review->event_id == $event->id ? 'selected' : '' }}>
                                        {{ $event->nama_event }} - {{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="participant_name" class="form-control" value="{{ $review->participant_name }}" placeholder="Masukkan nama peserta" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating <span class="text-danger">*</span></label>
                            <div class="rating-stars">
                                <input type="radio" name="rating" value="5" id="star5" {{ $review->rating == 5 ? 'checked' : '' }} required>
                                <label for="star5">★</label>
                                <input type="radio" name="rating" value="4" id="star4" {{ $review->rating == 4 ? 'checked' : '' }}>
                                <label for="star4">★</label>
                                <input type="radio" name="rating" value="3" id="star3" {{ $review->rating == 3 ? 'checked' : '' }}>
                                <label for="star3">★</label>
                                <input type="radio" name="rating" value="2" id="star2" {{ $review->rating == 2 ? 'checked' : '' }}>
                                <label for="star2">★</label>
                                <input type="radio" name="rating" value="1" id="star1" {{ $review->rating == 1 ? 'checked' : '' }}>
                                <label for="star1">★</label>
                            </div>
                            <small class="text-muted">Klik bintang untuk memberikan rating (1-5)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Komentar <span class="text-danger">*</span></label>
                            <textarea name="komentar" class="form-control" rows="5" placeholder="Tulis komentar/feedback Anda tentang event ini..." required>{{ $review->komentar }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('reviews.index') }}" class="btn btn-light w-50">Batal</a>
                            <button type="submit" class="btn btn-vettix w-50">
                                <i class="fa-solid fa-save"></i> Update Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checked = document.querySelector('.rating-stars input:checked');
            const stars = document.querySelectorAll('.rating-stars label');

            if (checked) {
                const checkedIndex = Array.from(stars).findIndex(s => s.getAttribute('for') === checked.id);
                stars.forEach((s, i) => {
                    s.style.color = i >= checkedIndex ? '#fbbf24' : '#ddd';
                });
            }

            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', () => {
                    stars.forEach((s, i) => {
                        if (i >= index) {
                            s.style.color = '#fbbf24';
                        }
                    });
                });

                star.addEventListener('mouseleave', () => {
                    const checked = document.querySelector('.rating-stars input:checked');
                    if (checked) {
                        const checkedIndex = Array.from(stars).findIndex(s => s.getAttribute('for') === checked.id);
                        stars.forEach((s, i) => {
                            s.style.color = i >= checkedIndex ? '#fbbf24' : '#ddd';
                        });
                    } else {
                        stars.forEach(s => s.style.color = '#ddd');
                    }
                });
            });
        });
    </script>
</body>
@endsection
</html>
