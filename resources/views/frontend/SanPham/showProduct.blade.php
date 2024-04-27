@isset($SanPham)
    <div class="billing-form ftco-bg-dark ftco-bg-dark-info p-3  d-flex">
        <div class="col-lg-6">
            <img style="width: 300px;height: 300px;" src="{{ asset('uploads/SanPham/' . $SanPham->hinhanh) }}" alt="">
        </div>
        <div class="col-lg-6">
            <h4>{{ $SanPham->tensanpham }}</h4>
            <div class="row mt-4">
                @isset($ChiTietSanPham)
                    @if ($ChiTietSanPham[0] == null)
                        <h3 style="color: red">Sản phẩm này đã bán hết</h3>
                    @else
                        <div class="row row-left">
                            @foreach ($ChiTietSanPham as $stt => $item)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label><input type="radio" class="optradio" name="optradio" class="mr-2" {{ $stt == 0 ? 'checked' : '' }} value="{{ $item->id }}">
                                                {{-- {{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ  (' . $item->tenquycach . ')' }} --}}
                                                @if ($item->muckhuyenmai != null)
                                                    {{ number_format($item->giasanpham * (1 - $item->muckhuyenmai / 100), 0, ',', '.') . ' VNĐ - ' . $item->tenquycach . ' (-' . $item->muckhuyenmai . '%)' }}
                                                @else
                                                    {{ number_format($item->giasanpham, 0, ',', '.') . ' VNĐ - ' . $item->tenquycach }}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{--  --}}
                        <div class="w-100"></div>
                        <form method="POST">
                            @csrf
                            <div class="col-md-8 d-flex mb-3">
                                <input type="number" id="quantity" name="quantity" class="form-control input-number input225w" style="color: #c49b63 !important;font-weight: 700;" value="1" min="1">
                            </div>
                            <div class="col-md-6 d-flex mb-3">
                                <input type="text" name="id_product_details" id="id_product_details" value="{{ $ChiTietSanPham[0]->id }}" hidden>
                                <input type="submit" id="themvao" value="Thêm Vào Giỏ Hàng" class="btn btn-primary py-3 px-5">
                            </div>
                        </form>
                    @endif
                @endisset
            </div>
        </div>
    </div>
@endisset
