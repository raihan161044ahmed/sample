@extends('layouts.app')

@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
    <form action="" method="get" class="card-header">
        <div class="form-row justify-content-between">
            <div class="col-md-2">
                <input type="text" name="title" placeholder="Product Title" value="{{Request::get('title')}}" class="form-control">
            </div>
            <div class="col-md-2">
                <select name="variant" id="" class="form-control" aria-label="Select variant">
                    <option value="">Select Variant</option>

                    @foreach($vari->pluck('variant')->unique() as $variant)
                    <option value="{{ $variant }}" {{ $request->variant == $variant ? 'selected' : '' }}>{{ $variant }}</option>

                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" name="price_from" aria-label="First name" placeholder="From" value="{{ request('price_from') }}" class="form-control">
                    <input type="text" name="price_to" aria-label="Last name" placeholder="To" value="{{ request('price_to') }}" class="form-control">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" value="{{Request::get('date') ?? date('Y-m-d')}}" class="form-control">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $key => $product)

                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->title}} <br>Created at: {{$product->created_at}}</td>
                        <td>{{$product->description}}</td>
                        <td>

                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 pb-0">

                                    <!-- @php
                                    $variants = [];
                                    $variantArr = explode(' ', $product->variant);
                                    foreach ($variantArr as $vari) {
                                    $variants[$vari][] = $vari;
                                    }
                                    @endphp
                                    @foreach ($variants as $variant => $values)
                                    {{ $variant}}
                                    @endforeach -->

                                    {{ $product->variant}}

                                    

                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">Price : {{ $product->price}}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ $product->stock }}</dd>
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        <div class="row justify-content-between">
            <div class="col-md-6">
                {{$products->links()}}
            </div>

        </div>
    </div>
</div>

@endsection