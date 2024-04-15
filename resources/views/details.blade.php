@extends('layouts.app')

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>

                    <span>{{ $movie->genres->implode('name', ', ') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Anime Section Begin -->
<section class="anime-details spad">
    <div class="container">
        <div class="anime__details__content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="anime__details__pic set-bg" data-setbg="{{ $movie->avatar ? asset('img/anime/'.$movie->avatar) : asset('img/default-avatar.jpg') }}">
                        <div class="comment"><i class="fa fa-comments"></i> 11</div>
                        <div class="view"><i class="fa fa-eye"></i> {{ $movie->views }}</div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="anime__details__text">
                        <div class="anime__details__title">
                            <h3>{{ $movie->name }}</h3>
                            <span>{{ $movie->name_call }}</span>
                        </div>
                        <div class="anime__details__rating">

                            <div class="rating">
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star-half-o"></i></a>
                            </div>
                            <span>{{ $movie->scores }} Lượt đánh giá</span>
                        </div>

                    </div>
                    <p>{{ $movie->description }}</p>
                    <div class="anime__details__widget">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <ul>
                                    <li><span>Loại:</span> {{ $movie->filmformat->name }}</li>
                                    <li><span>Hãng làm phim:</span> {{ $movie->studio->name }}</li>
                                    <li><span>Ngày phát sóng:</span> {{ $movie->date_aired }}</li>
                                    <li><span>Trạng thái:</span> {{ $movie->status->name }}</li>
                                    <li><span>Thể loại:</span> {{ $movie->genres->implode('name', ', ') }}</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <ul>
                                    <li><span>Điểm:</span> {{ $movie->scores }}</li>
                                    <li><span>Xếp hạng:</span> {{ $movie->rating }} / 10</li>
                                    <li><span>Thời lượng:</span> {{ $movie->duration }} min/ep</li>
                                    <li><span>Chất lượng:</span> {{ $movie->quality->name }}</li>
                                    <li><span>Lượt xem:</span> {{ $movie->views }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="anime__details__btn">
                        <a href="#" class="follow-btn"><i class="fa fa-heart-o"></i> Theo dõi</a>
                        <a href="{{ route('movies.watching', ['id' => $movie->id]) }}" class="watch-btn"><span>Xem ngay</span> <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="anime__details__review">
                    <div class="section-title">
                        <h5>Đánh giá</h5>
                    </div>
                    @if(isset($movie->comments) && $movie->comments->count() > 0)
                    @foreach($movie->comments as $comment)
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <img src="{{ $comment->user->avatar ? asset('img/anime/' .$comment->user->avatar) : asset('img/anime/review-3.jpg') }}" alt="Avatar" id="avatar-preview">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>{{ $comment->user->name }} - <span>{{ $comment->created_at->diffForHumans() }}</span></h6>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                    @endforeach
                    @else
                    @endif


                </div>
                @if(auth()->check())
                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Bình luận của bạn</h5>
                    </div>
                    <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <textarea id="comment-content" name="content" placeholder="Bình luận của bạn"></textarea>
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <button type="submit"><i class="fa fa-location-arrow"></i> Đánh giá</button>
                    </form>
                </div>
                @endif


            </div>
            <div class="col-lg-4 col-md-4">
                <div class="anime__details__sidebar">
                    <div class="section-title">
                        <h5>bạn có thể thích...</h5>
                    </div>
                    <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-1.jpg') }}">
                        <div class="ep">18 / ?</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div>
                        <h5><a href="#">Boruto: Naruto next generations</a></h5>
                    </div>
                    <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-2.jpg') }}">
                        <div class="ep">18 / ?</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div>
                        <h5><a href="#">The Seven Deadly Sins: Wrath of the Gods</a></h5>
                    </div>
                    <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-3.jpg') }}">
                        <div class="ep">18 / ?</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div>
                        <h5><a href="#">Sword art online alicization war of underworld</a></h5>
                    </div>
                    <div class="product__sidebar__view__item set-bg" data-setbg="{{ asset('img/sidebar/tv-4.jpg') }}">
                        <div class="ep">18 / ?</div>
                        <div class="view"><i class="fa fa-eye"></i> 9141</div>
                        <h5><a href="#">Fate/stay night: Heaven's Feel I. presage flower</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
        // Xử lý khi form được submit và comment được thêm thành công
        $(document).on('submit', '#comment-form', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của form
            var formData = $(this).serialize(); // Lấy dữ liệu từ form

            // Gửi yêu cầu tạo comment mới
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#comment-content').val(''); // Xóa nội dung của form sau khi comment được thêm thành công
                    reloadComments(); // Load lại phần khung comments
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi khi thêm comment
                }
            });
        });

        // Load lại phần khung comments khi cần
        function reloadComments() {
            $.ajax({
                url: window.location.href + ' .anime__details__review', // Chỉ load phần khung comments
                success: function(data) {
                    $('.anime__details__review').html($(data).find('.anime__details__review').html());
                }
            });
        }
    });
    });

    // Xử lý khi form được submit và comment được thêm thành công
</script>

<!-- Anime Section End -->
@endsection