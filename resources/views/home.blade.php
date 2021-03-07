@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">

        <div class="col-lg-8 col-md-10 ml-auto mr-auto">
        <h4><small>Product Lists</small></h4>
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('product.create') }}" class="btn btn-success float-right">Add</a>
                </div>
            </div>
            <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th class="text-right">Description</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                @if(!$products->count())
                    <p>No Product Found</p>
                @else
                <tbody>
                @foreach($products as $key => $product)
                    <tr>
                        <td class="text-center">{{ ++$key }}</td>
                        <td>{{ $product->title }}</td>
                        <td><img src="{{ asset($product->image)}}" style="width:50px;height: 50px;border-radius: 10px" alt=""></td>
                        <td>{{ $product->price }}</td>
                        <td class="text-right">{{ $product->description }}</td>
                        <td class="td-actions text-right">
                            <a href="{{ route('product.edit',$product->id) }}" rel="tooltip" class="btn btn-success btn-just-icon btn-sm" data-original-title="" title="">
                                <i class="material-icons">Edit</i>
                            </a>
                            <form action="{{ route('product.delete', $product->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <button type="submit" onclick="return confirm(' you want to delete?');" rel="tooltip" class="btn btn-danger btn-just-icon btn-sm" data-original-title="" title="">
                                <i class="material-icons">Delete</i>
                            </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                @endif
            </table>
            </div>

        </div>

    </div>
</div>
@endsection
