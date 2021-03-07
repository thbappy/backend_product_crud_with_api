@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-lg-8 col-md-10 ml-auto mr-auto">
                @if ($message = Session::get('success'))
                    <div class="alert alert-primary" role="alert">
                        {{ $message }}
                    </div>
                @endif
                @if ($message = Session::get('failed'))
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <h4><small>Update Product</small></h4>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ route('home') }}" class="btn btn-success float-right">List</a>
                    </div>
                </div>

                <form class="form-horizontal" action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="product_title">Product Title</label>
                            <div class="col-md-12">
                                <input type="text" id="product_title" value="{{ $product->title }}" name="title" placeholder="Product Title" class="form-control input-md">
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-12 control-label" for="product_title">Product Price</label>
                            <div class="col-md-12">
                                <input type="number" value="{{ $product->price }}" id="product_title" name="price" placeholder="Product Price" class="form-control input-md" >
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            </div>
                        </div>
                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-12 control-label" for="product_description">PRODUCT DESCRIPTION</label>
                            <div class="col-md-12">
                                <textarea class="form-control" id="product_description" placeholder="Enter Description" name="description">{{ $product->description }}</textarea>
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <div class="col-md-4">
                                <!-- File Button -->
                                <div class="form-group">
                                    <label class="col-md-12 control-label" for="filebutton">Product Image</label>
                                    <div class="col-md-12">
                                        <img src="{{ asset($product->image) }}" style="widht:100px;height: 50px" alt=""><br>
                                        <input id="filebutton" name="img" class="input-file" type="file">
                                        <span class="text-danger">{{ $errors->first('img') }}</span>
                                    </div>
                                </div>


                                <!-- Button -->
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>

        </div>
    </div>
@endsection
