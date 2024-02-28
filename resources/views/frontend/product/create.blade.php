@extends('frontend.layouts.app')
@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Add product</h2>
    <div id="form" class="signup-form">
        <!--profile-form-->
        <form action="{{ route('account.add-product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" name="name" placeholder="name" class="@error('name') is-invalid @enderror" />

                @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="price" placeholder="price" class="@error('price') is-invalid @enderror" />

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
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
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
                    <option value="0">New</option>
                    <option value="1">Sale</option>
                </select>
                @error('status')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="number" name="sale" value="0" placeholder="Sale price"
                    class="hidden @error('company') is-invalid @enderror" />

                @error('sale')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <input type="text" name="company" placeholder="company profile"
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
            <div class="form-group">
                <textarea name="detail" placeholder="Detail" id="" cols="10"
                    class="@error('detail') is-invalid @enderror"></textarea>
                @error('detail')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-default">Create</button>
        </form>
    </div>
</div>
<!--/profile-form-->
@endsection

@push('scripts')
<script>
    $('select[name="status"]').on('change', function() {
        var saleInp = $('input[name="sale"]');
        if(this.value == '1') {
            saleInp.removeClass('hidden');
        } else {
            saleInp.val(0);
            saleInp.hasClass('hidden') || saleInp.addClass('hidden');
        }
});
</script>
@endpush
