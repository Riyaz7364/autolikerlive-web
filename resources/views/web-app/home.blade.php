@extends('web-app.master')
@section('title', 'FBSUB - Home')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Dashboard
      </h3>
    </div>
    <div class="row">


      <div class="col-12 stretch-card grid-margin">
        <div class="card">
            <div class="cart-header"><div class="alert alert-warning text-center">Alert! You have Low Coins to get Likes &amp; Followers you have to earn at least 30 coins.</div></div>
          <div class="card-body">

            <h4 class="font-weight-normal mb-3">Online Visitors  <i class="mdi mdi-account float-right"></i>
            </h4>
            <h2 class="mb-5">40</h2>
            <h4 class="font-weight-normal mb-3">Credits: <span class="mdi-24px float-right"> 500</span>
            </h4>

            <button type="button" class="btn btn-social-icon-text btn-facebook btn-block"><i class="mdi mdi-database"></i>Earn Credits</button>

          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <button type="button" class="btn btn-social-icon-text btn-facebook btn-block m-2"><i class="mdi mdi-plus"></i>Add Order</button>
            <button type="button" class="btn btn-social-icon-text btn-linkedin btn-block m-2"><i class="mdi mdi-format-list-bulleted-type"></i>Order List</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
