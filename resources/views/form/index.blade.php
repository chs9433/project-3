@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}

@endsection

@section('content')
<h2>{{ $title }}</h2>
<p>Search for vehicle-specific service stations by address.</p>
<hr>
<!--Main Form -->
<form method='POST' action='/form' enctype='multipart/form-data'>
    {{ csrf_field() }}
  <div class="form-group">
    <label for="varStreetAddress"><b>Street Address</b></label>
    <input type="text" class="form-control" id="varStreetAddress" name="varStreetAddress" placeholder="1234 Sesame Street" value="{{ $varStreetAddress }}">
  </div>
  <div class="form-group">
    <label for="varZipCode"><b>Zip Code</b></label>
    <input type="text" class="form-control" id="varZipCode" name="varZipCode" placeholder="123456" pattern="[0-9]{5}">
  </div>
  <div class="form-group">
    <label for="varSicCode"><b>Vehicle Service Station</b></label>
    <select class="form-control" id="varSicCode" name="varSicCode">
      <option value="none">---Select---</option>
      <option value="554101">Gas Station</option>
      <option value="554112">Electric Charging Station</option>
      <option value="753201">Auto Body Shop</option>
      <option value="754201">Car Wash</option>
    </select>
  </div>
  <div class="form-group">
    <label for="varSearchRadius"><b>Search Radius (1 to 10 miles)</b></label>
    <input type="number" class="form-control" id="varSearchRadius" name="varSearchRadius" min="0" max="10">
  </div>
  <input class="btn btn-success" type="submit" value="Search" style="float:right;margin:auto;">
  <br>
  <br>
  <hr>
</form>
<br>
@endsection

@section('results')
      <div id="tblSearchResults" name="tblSearchResults" class="container" style="display:{{ $tblDisplayStyle }}">
      <h2>Search Results</h2>
      <table class="table tbl-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Distance (miles)</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip Code</th>
            <th>Phone</th>
          </tr>
        </thead>
        <tbody>
            {{!! html_entity_decode($htmlSearchResults) !!}}
        </tbody>
      </table>
    </div>
@endsection
