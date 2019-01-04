
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
        <label  class="col-md-4 control-label">Name</label>
        <div class="col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="@if(old('name')){{ old('name')}}@else{{ $product->name or ''}}@endif" required autofocus>
        @if ($errors->has('name'))
            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
        @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Description</label>
        <div class="col-md-6">
        <textarea id="description" class="form-control" name="description">@if(old('description')){{ old('description')}}@else{{ $product->description or ''}}@endif</textarea>
        </div>
        </div>

    <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Category</label>
        <div class="col-md-6">
        <select id="category" name="category" class="form-control">
            <option value='' >--Select--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if(old('category') == $category->id ) selected @else @if(isset($product) && $product->category_id==$category->id) selected @endif @endif>{{ $category->name }}</option>
            @endforeach
        </select>



        @if ($errors->has('category'))
            <span class="help-block">
                <strong>{{ $errors->first('category') }}</strong>
            </span>
        @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('brand') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Brand</label>
        <div class="col-md-6">
        <select id="brand" name="brand" class="form-control">
            <option value='' >--Select--</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @if(old('brand') == $brand->id ) selected @else @if(isset($product) && $product->brand_id==$brand->id) selected @endif @endif>{{ $brand->name }}</option>
            @endforeach
        </select>


        @if ($errors->has('brand'))
            <span class="help-block">
                                        <strong>{{ $errors->first('brand') }}</strong>
            </span>
        @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('published') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Published</label>
        <div class="col-md-6">
        <select id="published" name="published" class="form-control">
            <option value='' >--Select--</option>
            <option value="Y" @if(old('published') == 'Y' ) selected @else @if(isset($product) && $product->published=='Y') selected @endif @endif>Yes</option>
            <option value="N" @if(old('published') == 'N' ) selected @else @if(isset($product) && $product->published=='N') selected @endif @endif>No</option>
        </select>


        @if ($errors->has('published'))
            <span class="help-block">
                                        <strong>{{ $errors->first('published') }}</strong>
            </span>
        @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('uom') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">UOM</label>
        <div class="col-md-6">
        <select id="uom" name="uom" class="form-control">
            <option value='' >--Select--</option>
            <option value="1" @if(old('uom') == '1' ) selected @else @if(isset($product) && $product->uom=='1') selected @endif @endif>Square Feet</option>
            <option value="2" @if(old('uom') == '2' ) selected @else @if(isset($product) && $product->uom=='2') selected @endif @endif>Linear Length</option>
        </select>


        @if ($errors->has('uom'))
            <span class="help-block">
                                        <strong>{{ $errors->first('v') }}</strong>
            </span>
        @endif
    </div>
    </div>

    <div class="form-group {{ $errors->has('unitprice') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Unit Price</label>
        <div class="col-md-6">
        <input id="unitprice" type="text" class="form-control" name="unitprice" value="@if(old('unitprice')){{ old('unitprice')}}@else{{ $product->unit_price or ''}}@endif" required autofocus>
        @if ($errors->has('unitprice'))
            <span class="help-block">
                                        <strong>{{ $errors->first('unitprice') }}</strong>
                                    </span>
        @endif
        </div>
    </div>

    <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Image</label>
        <div class="col-md-6">
    <input type="file" class="form-control" id="image" name="image" onchange="readURL(this);">
    @if ($errors->has('image'))
        <span class="help-block">
            <strong id="imageerror">{{ $errors->first('image') }}</strong>
        </span>
    @endif
        </div>

    </div>

    @if(!isset( $product->image ))

        <div class="form-group">

            <label class="col-md-4 control-label"></label>
            <div class="col-md-6">
            <img id="blah" src="" height="150" width="150" alt="your image"/>
            </div>

        </div>

    @endif

    @if(isset( $product->image ))

    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-6">
    <img id="blah" src="{{ url("/images/products/".$product->image.'?'.str_random())}}" height="150" width="150" alt="your image"/>
        </div>
    </div>

    @endif

    <div class="form-group">
        <label class="col-md-4 control-label" ></label>
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">
                <span class="glyphicon glyphicon-plus"></span>
                {{ $submitButtonText }}
            </button>
            <button type="reset" class="btn btn-danger pull-right">
                <span class="glyphicon glyphicon-remove-sign"></span>
                Clear
            </button>
        </div>

    </div>



    <script>

        function readURL(input) {
            $('imageerror').text('');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>

