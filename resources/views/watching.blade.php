@extends('layouts.app')

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Trang Chủ</a>
                    <span>{{ $movie->genres->implode('name', ', ') }}</span>
                    <span>{{ $movie->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Anime Section Begin -->
<section class="anime-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="anime__video__player">
                    <video id="player" playsinline controls data-poster="{{ asset('./videos/anime-watch.jpg') }}">
                        <!-- Mặc định sẽ load video từ tập đầu tiên -->
                        <source id="video-source" src="{{ asset('videos/'.$movie->episodes->first()->pivot->link) }}" type="video/mp4" />
                        <!-- Captions are optional -->
                        <track kind="captions" label="English captions" src="#" srclang="en" default />
                    </video>
                </div>
                <div class="anime__details__episodes">
                    <div class="section-title">
                        <h5>Danh sách tập phim</h5>
                    </div>
                    @foreach($movie->episodes as $episode)
                    <!-- Sử dụng data-attribute để lưu đường dẫn video của mỗi tập -->
                    <a href="#" class="episode-link" data-src="{{ asset('videos/'.$episode->pivot->link) }}">{{ $episode->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
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
        </div>
    </div>
</section>
<!-- Anime Section End -->
<script>
    // Lắng nghe sự kiện click trên mỗi tập
    var episodeLinks = document.querySelectorAll('.episode-link');
    episodeLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var videoSource = document.getElementById('video-source');
            // Lấy đường dẫn video của tập được chọn
            var src = this.getAttribute('data-src');
            // Cập nhật đường dẫn video
            videoSource.src = src;
            // Tải lại video
            var player = document.getElementById('player');
            player.load();
        });
    });
</script>
@endsection