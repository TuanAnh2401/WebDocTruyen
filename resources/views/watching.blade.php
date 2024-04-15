@extends('layouts.app')

@section('content')
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <a href="./categories.html">Categories</a>
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
                        <h5>List EP</h5>
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
                        <h5>Reviews</h5>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-1.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Chris Curry - <span>1 Hour ago</span></h6>
                            <p>whachikan Just noticed that someone categorized this as belonging to the genre
                                "demons" LOL</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-2.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Lewis Mann - <span>5 Hour ago</span></h6>
                            <p>Finally it came out ages ago</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-3.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Louis Tyler - <span>20 Hour ago</span></h6>
                            <p>Where is the episode 15 ? Slow update! Tch</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-4.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Chris Curry - <span>1 Hour ago</span></h6>
                            <p>whachikan Just noticed that someone categorized this as belonging to the genre
                                "demons" LOL</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-5.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Lewis Mann - <span>5 Hour ago</span></h6>
                            <p>Finally it came out ages ago</p>
                        </div>
                    </div>
                    <div class="anime__review__item">
                        <div class="anime__review__item__pic">
                            <<img src="{{ asset('img/anime/review-6.jpg') }}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>Louis Tyler - <span>20 Hour ago</span></h6>
                            <p>Where is the episode 15 ? Slow update! Tch</p>
                        </div>
                    </div>
                </div>
                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Your Comment</h5>
                    </div>
                    <form action="#">
                        <textarea placeholder="Your Comment"></textarea>
                        <button type="submit"><i class="fa fa-location-arrow"></i> Review</button>
                    </form>
                </div>
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