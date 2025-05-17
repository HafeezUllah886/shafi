<?php

use App\Models\products;
use App\Models\purchase_details;
use App\Models\ref;
use App\Models\sale_details;
use App\Models\stock;
use Carbon\Carbon;

function getRef(){
    $ref = ref::first();
    if($ref){
        $ref->ref = $ref->ref + 1;
    }
    else{
        $ref = new ref();
        $ref->ref = 1;
    }
    $ref->save();
    return $ref->ref;
}

function firstDayOfMonth()
{
    $startOfMonth = Carbon::now()->startOfMonth();

    return $startOfMonth->format('Y-m-d');
}
function lastDayOfMonth()
{

    $endOfMonth = Carbon::now()->endOfMonth();

    return $endOfMonth->format('Y-m-d');
}

function createStock($id, $cr, $db, $date, $notes, $ref, $warehouse)
{
    stock::create(
        [
            'productID'     => $id,
            'cr'            => $cr,
            'db'            => $db,
            'date'          => $date,
            'notes'         => $notes,
            'refID'         => $ref,
            'warehouseID'   => $warehouse,
        ]
    );
}
function getStock($id){
    $stocks  = stock::where('productID', $id)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->cr;
        $balance -= $stock->db;
    }

    return $balance;
}

function getStockByWarehouse($id, $warehouse){
    $stocks  = stock::where('productID', $id)->where('warehouseID', $warehouse)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->cr;
        $balance -= $stock->db;
    }

    return $balance;
}

function getStockCr($id){
    $stocks  = stock::where('productID', $id)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->cr;
    }

    return $balance;
}
function getWarehouseProductCr($id, $warehouse){
    $stocks  = stock::where('productID', $id)->where('warehouseID', $warehouse)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->cr;
    }

    return $balance;
}

function getStockDb($id){
    $stocks  = stock::where('productID', $id)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->db;
    }

    return $balance;
}
function getWarehouseProductDb($id, $warehouse){
    $stocks  = stock::where('productID', $id)->where('warehouseID', $warehouse)->get();
    $balance = 0;
    foreach($stocks as $stock)
    {
        $balance += $stock->db;
    }

    return $balance;
}

function avgSalePrice($from, $to, $id)
{
    $sales = sale_details::where('productID', $id);
    if($from != 'all' && $to != 'all')
    {
        $sales->whereBetween('date', [$from, $to]);
    }
    $sales_amount = $sales->sum('amount');
    $sales_qty = $sales->sum('qty');

    if($sales_qty > 0)
    {
        $sale_price = $sales_amount / $sales_qty;
    }
    else
    {
        $sale_price = 0;
    }

    return $sale_price;
}

function avgPurchasePrice($from, $to, $id)
{
    $purchases = purchase_details::where('productID', $id);
    if($from != 'all' && $to != 'all')
    {
        $purchases->whereBetween('date', [$from, $to]);
    }
    $purchase_amount = $purchases->sum('amount');
    $purchase_qty = $purchases->sum('qty');

    if($purchase_qty > 0)
    {
        $purchase_price = $purchase_amount / $purchase_qty;
    }
    else
    {
        $purchase_price = 0;
    }

    return $purchase_price;
}

function stockValue()
{
    $products = products::all();

    $value = 0;
    foreach($products as $product)
    {
        $value += productStockValue($product->id);
    }

    return $value;
}

function productStockValue($id)
{
    $stock = getStock($id);
    $price = avgPurchasePrice('all', 'all', $id);

    return $price * $stock;
}

function warehouseProductStockValue($id, $warehouse)
{
    $stock = getStockByWarehouse($id, $warehouse);
    $price = avgPurchasePrice('all', 'all', $id);

    return $price * $stock;
}

function projectName()
{
    return "ALBAYT BBQ";
}
function projectNameShort()
{
    return "BBQ";
}

