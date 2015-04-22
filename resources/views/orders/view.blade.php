@extends('layouts.layout')

@section('content')
    <div class="page-header clearfix">
        <h2>Order #{{{ $order->getOrderNumber() }}}</h2>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th colspan="2">Order Details</th>
        </tr>
        </thead>
        <tr>
            <th>Customer:</th>
            <td>
                <a href="/customers/edit/{{{ $order->getCustomer()->getId() }}}">
                    {{{ $order->getCustomer()->getName() }}}</a>
            </td>
        </tr>
        <tr>
            <th>Description:</th>
            <td>{{{ $order->getDescription() }}}</td>
        </tr>
        <tr>
            <th>Total:</th>
            <td>$ {{{ number_format($order->getTotal(), 2) }}}</td>
        </tr>
    </table>
@stop
