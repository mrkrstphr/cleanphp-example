@extends('layouts.layout')

@section('content')
    <div class="page-header clearfix">
        <h2 class="pull-left">Orders</h2>
        <a href="/orders/new" class="btn btn-success pull-right">
            Create Order</a>
    </div>

    <table class="table table-striped clearfix">
        <thead>
        <tr>
            <th>#</th>
            <th>Order Number</th>
            <th>Customer</th>
            <th>Description</th>
            <th class="text-right">Total</th>
        </tr>
        </thead>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td>
                <a href="/orders/view/{{{ $order->getId() }}}">
                    {{{ $order->getId() }}}</a>
            </td>
            <td>{{{ $order->getOrderNumber() }}}</td>
            <td>
                <a href="/customers/edit/{{{ $order->getCustomer()->getId() }}}">
                    {{{ $order->getCustomer()->getName() }}}</a>
            </td>
            <td>{{{ $order->getDescription() }}}</td>
            <td class="text-right">
                $ {{ number_format($order->getTotal(), 2) }}
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
@stop
