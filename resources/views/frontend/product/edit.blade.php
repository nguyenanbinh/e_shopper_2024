@extends('frontend.layouts.app')
@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Update product</h2>
    <div id="form" class="signup-form">
        <!--profile-form-->
        <form action="{{ route('account.update-product', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" name="name" value="{{ $product->name }}" placeholder="name" class="@error('name') is-invalid @enderror" />

                @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="price" value="{{ $product->price }}" placeholder="price" class="@error('price') is-invalid @enderror" />

                @error('price')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <select name="category_id"
                    class="form-control form-control-line @error('category_id') is-invalid @enderror">
                    @if(isset($categories) && $categories->count())
                        <option value="-1">Please choose category</option>
                        @foreach ($categories as $category)
                            @if($product->category_id == $category->id)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    @else
                        <option>No data</option>
                    @endif
                </select>
                @error('category_id')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <select name="brand_id" class="form-control form-control-line @error('brand_id') is-invalid @enderror">
                    @if(isset($brands) && $brands->count())
                        <option value="-1">Please choose brand</option>
                        @foreach ($brands as $brand)
                            @if($product->brand_id == $brand->id)
                                <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                            @else
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endif
                        @endforeach
                    @else
                        <option>No data</option>
                    @endif
                </select>
                @error('brand_id')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <select name="status" class="form-control form-control-line @error('status') is-invalid @enderror">
                    <option value="-1">Please choose status</option>
                    <option value="0" @if($product->status == 0) selected @endif>New</option>
                    <option value="1" @if($product->status == 1) selected @endif>Sale</option>
                </select>
                @error('status')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="sale" value="{{ $product->sale }}" placeholder="Sale price"
                    class="hidden @error('company') is-invalid @enderror" />

                @error('sale')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" name="company" value="{{ $product->company }}"  placeholder="company profile"
                    class="@error('company') is-invalid @enderror" />

                @error('company')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="file" name="image[]" class="@error('image') is-invalid @enderror" multiple />

                @error('image')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="row">
                @foreach (json_decode($product->image) as $key => $image)
                <div class="col-md-3">
                    <div class="custom-control custom-checkbox image-checkbox">
                        <label class="custom-control-label" for="ck1a">
                            <img src="{{ asset('upload/product/'. auth()->id(). '/' . $image) }}" alt="#" class="img-fluid" width="120" height="120">
                        </label>
                        <input type="checkbox" name="imgCkb[]" value="{{ $key }}" class="custom-control-input" id="ck1a">
                    </div>
                </div>
                @endforeach

            </div>

            <div class="form-group">
                <textarea name="detail" {{ $product->detail }} placeholder="Detail" id="" cols="10"
                    class="@error('detail') is-invalid @enderror"></textarea>
                @error('detail')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-default">Update</button>
        </form>
    </div>
</div>
<!--/profile-form-->
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        var saleInp = $('input[name="sale"]');
        var statusOpt = $('select[name="status"] option');

        if(statusOpt.filter(':selected').val() == '1') {
            saleInp.removeClass('hidden');
        }

        $('select[name="status"]').on('change', function() {
            if(this.value == '1') {
                saleInp.removeClass('hidden');
            } else {
                saleInp.val(0);
                saleInp.hasClass('hidden') || saleInp.addClass('hidden');
            }
        });
    });

</script>
@endpush
