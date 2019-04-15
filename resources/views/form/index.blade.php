@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}

@endsection

@section('content')
<h2><i class="fas fa-car"></i> {{ $title }}</h2>
<p>Search for vehicle-specific service stations by address.</p>
<hr>
<!--Main Form -->
<form method='POST' action='' enctype='multipart/form-data'>
    {{ csrf_field() }}
    <div class="form-row">
  <div class="form-group col-md-8">
    <label for="varStreetAddress"><b>Street Address</b></label>
    <input type="text" class="form-control" id="varStreetAddress" name="varStreetAddress"  placeholder="1234 Sesame Street" value="{{ old('varStreetAddress') }}">
  </div>
  <div class="form-group col-md-4">
    <label for="varZipCode"><b>Zip Code</b></label>
    <input type="text" class="form-control" id="varZipCode" name="varZipCode" placeholder="12345" value="{{ old('varZipCode') }}">
  </div>
</div>
<div class="form-row">
  <div class="form-group col-md-8">
    <label for="varSicCode"><b>Vehicle Service Station</b></label>
    <select class="form-control" id="varSicCode" name="varSicCode" value="{{ old('varSicCode') }}">
      <option value="">---Select---</option>
      <option value="554101">Gas Station</option>
      <option value="554112">Electric Charging Station</option>
      <option value="753201">Auto Body Shop</option>
      <option value="754201">Car Wash</option>
    </select>
  </div>
  <div class="form-group col-md-4">
    <label for="varSearchRadius"><b>Search Radius (1 to 10 miles)</b></label>
    <input type="number" class="form-control" id="varSearchRadius" name="varSearchRadius" placeholder="5" value="{{ old('varSearchRadius') }}">
  </div>
</div>
  <button class="btn btn-success" type="submit" value="Search" style="float:right;margin:auto;">
      <i class="fas fa-search-location fa-lg"></i>
      Search
  </button>
  <br>
  <br>
  <hr>
</form>
@if(count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong><i class="fas fa-exclamation-triangle"></i> <u>Error(s)</u>:</strong>
<ul>
  @foreach ($errors->all() as $error)
      <li>{{ str_replace("var ","",$error) }}</li>
  @endforeach
</ul>
</div>
@endif
 @endsection

@section('results')
      <div class="container" style="{{ $styleResultsDiv }};margin:0px;padding:1px;width:100%;min-height:475px;max-height:475px;overflow:hidden;left:5px;top:-10px;">
          <div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <h3>Search Results</h3>
      @if($resultsCount == 0)
      <div class="alert alert-info alert-dismissible fade show">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong><i class="fas fa-sad-cry fa-lg"></i> 0 results found. Revise your query and try again.</strong>
      </div>
      @else
      <b>{{ json_decode($jsonSearchResults,TRUE)['resultsCount'] }} </b> results found.</div></div>
      @endif
      <div class="row">
            @if($resultsCount > 0)
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style="align:left;vertical-align:middle;min-width:70%;max-width:70%;margin:auto;padding:1px;float:left;min-height:420px;max-height:420px;left:5px;overflow:auto;">
            <table id="tblSearchResults" name="tblSearchResults" class="table table-small table-striped table-hover table-responsive" style="{{ $styleResultsTable }};align:right;vertical-align:middle;font-size:10px;">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Zip</th>
                  <th>Phone</th>
                  <th>Distance<sub>(miles)</sub></th>
                </tr>
              </thead>
              <tbody>
                  <tr></tr>
                @foreach($arrSearchResults['searchResults'] as $searchResult)
                    <tr style="vertical-align:middle;">
                        <td style="vertical-align:middle"><b>{{ $searchResult['resultNumber'].'.' }}</b></td>
                        <td style="vertical-align:middle">{{ $searchResult['name'] }} </td>
                        <td style="vertical-align:middle">{{ $searchResult['fields']['address'] }} </td>
                        <td style="vertical-align:middle">{{ $searchResult['fields']['city'] }} </td>
                        <td style="vertical-align:middle">{{ $searchResult['fields']['state'] }} </td>
                        <td style="vertical-align:middle">{{ $searchResult['fields']['postal_code'] }} </td>
                        <td style="vertical-align:middle">{{ str_replace('+(1)-',"",$searchResult['fields']['phone']) }}</td>
                        <td style="vertical-align:middle">{{ round($searchResult['distance'],2) }} </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
</div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="align:center;margin:auto;padding;1px;min-width:30%;max-width:30%;min-height:415px;max-height:415px;float:right;overflow:hidden;">
    <img src="https://www.mapquestapi.com/staticmap/v4/getmap?size=300,415&type=map&pois=purple_1-1,33.014963,-96.869322|mcenter,33.014961,-96.86945|&imagetype=JPEG&key=IriKNa9PzduxFw0DNM33MWGCwlXgkwqA" style="float:right;align:right;margin:1px;right:0;"/>
</div>
                  @endif

    </div>
<br><hr>
@endsection
