<div id="vipForm" class="container mt-3">
    <div class="custom-header d-flex justify-content-between align-items-center mb-3">
        <h2 class="mr-auto text-dark">Đăng ký gói VIP</h2>
        <span class="close-button btn btn-danger">&times;</span>
    </div>
    <div class="price-list row">
        @foreach ($prices as $price)
        <div class="col-md-{{ 12 / count($prices) }} mb-3">
            <button class="price-button btn btn-outline-primary w-100" 
                data-detail="{{ $price->detail}}" 
                data-price="{{ $price->price }}"
                data-price-sale="{{ $price->price_sale }}"
                data-price-id="{{ $price->id }}">
                <h3>{{ $price->name }}</h3>
                @if ($price->price_sale)
                    <p class="mb-0 price-info">
                        <del class="original-price">{{ $price->price }}</del>
                        <span class="text-danger sale-price">{{ $price->price_sale }}</span>
                    </p>
                @else
                    <p class="mb-0 price-info">
                        <span class="original-price">{{ $price->price }}</span>
                    </p>
                @endif
            </button>
        </div>
        @endforeach
    </div>
    <div id="priceDetail" class="row mt-3" style="display: none;">
        <div class="col-md-12">
            <div class="price-detail bg-light p-3">
                <p id="priceDetailContent"></p>
            </div>
        </div>
    </div>
    <form id="paymentForm" action="{{ route('payment.vnpay') }}" method="POST">
        @csrf
        <div id="discounts" class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discountCode">Nhập mã giảm giá:</label>
                    <input type="text" class="form-control" id="discountCode" name="discountCode">
                </div>
            </div>
        </div>
        <div class="text-center mt-3">
            <input type="hidden" name="price_id" id="price_id">
            <button type="submit" class="btn btn-success">Đăng ký</button>
        </div>
    </form>
</div>
