@extends('layout.popups')
@section('content')
        <div class="row justify-content-center">
            <div class="col-xxl-9">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end d-print-none p-2 mt-4">
                                <a href="javascript:window.print()" class="btn btn-success ml-4"><i class="ri-printer-line mr-4"></i> Print</a>
                            </div>
                            <div class="card-header border-bottom-dashed p-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h1>{{projectName()}}</h1>
                                    </div>
                                    <div class="flex-shrink-0 mt-sm-0 mt-3">
                                        <h3>Warehouse Report</h3>
                                    </div>
                                </div>
                            </div>
                            <!--end card-header-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Warehouse</p>
                                        <h5 class="fs-14 mb-0">{{ $warehouse->name }}</h5>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                    <div class="col-lg-3 col-4">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Printed On</p>
                                        <h5 class="fs-14 mb-0"><span id="total-amount">{{ date("d M Y") }}</span></h5>
                                        {{-- <h5 class="fs-14 mb-0"><span id="total-amount">{{ \Carbon\Carbon::now()->format('h:i A') }}</span></h5> --}}
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col" class="text-start">Code</th>
                                                <th scope="col" class="text-start">Product</th>
                                                <th scope="col" class="text-start">Category</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Stock In</th>
                                                <th scope="col">Stock Out</th>
                                                <th scope="col">Current Stock</th>
                                                <th scope="col">Stock Value</th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @php
                                                $ser = 0;
                                            @endphp
                                        @foreach ($products as $key => $product)
                                            <tr>
                                                @if ($product->stock > 0)
                                                @php
                                                    $ser++;
                                                @endphp
                                                <td>{{ $ser}}</td>
                                                <td class="text-start">{{ $product->code }}</td>
                                                <td class="text-start">{{ $product->name }}</td>
                                                <td class="text-start">{{ $product->category->name }}</td>
                                                <td class="text-start">{{ $product->pprice }}</td>
                                                <td class="text-end">{{ number_format($product->stock_cr, 2) }}</td>
                                                <td class="text-end">{{ number_format($product->stock_db, 2) }}</td>
                                                <td class="text-end">{{ number_format($product->stock, 2) }}</td>
                                                <td class="text-end">{{ number_format($product->stock_value, 2) }}</td>
                                                @endif
                                                
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        
                                    </table><!--end table-->
                                </div>

                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

@endsection



