@extends('layouts.layout')

@section('content')
    <div class="page-header clearfix">
        <h2>Create Order</h2>
    </div>

    <form role="form" action="" method="post">
        <input type="hidden" name="_token" value="<?= csrf_token(); ?>">

        <div class="form-group">
            <label for="customer_id">Customer:</label>
            <select class="form-control" name="customer[id]" id="customer_id">
                <option value=""></option>
                <?php foreach ($customers as $customer): ?>
                <option value="{{{ $customer->getId() }}}"<?=
                        !is_null($order->getCustomer()) &&
                        $order->getCustomer()->getId() == $customer->getId() ?
                                ' selected="selected"' : '' ?>>
                    {{{ $customer->getName() }}}
                </option>
                <?php endforeach; ?>
            </select>
            @include('validation-errors', ['name' => 'customer.id', 'errors' => isset($error) ? $error : []])
        </div>
        <div class="form-group">
            <label for="orderNumber">Order Number:</label>
            <input type="text" class="form-control" name="orderNumber"
                   id="order_number" placeholder="Enter Order Number"
                   value="{{{ $order->getOrderNumber() }}}">
            @include('validation-errors', ['name' => 'orderNumber', 'errors' => isset($error) ? $error : []])
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" name="description"
                   id="description" placeholder="Enter Description"
                   value="{{{ $order->getDescription() }}}">
            @include('validation-errors', ['name' => 'description', 'errors' => isset($error) ? $error : []])
        </div>
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="text" class="form-control" name="total"
                   id="total" placeholder="Enter Total"
                   value="{{{ $order->getTotal() }}}">
            @include('validation-errors', ['name' => 'total', 'errors' => isset($error) ? $error : []])
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@stop
