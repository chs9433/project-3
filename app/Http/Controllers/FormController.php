<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App;

class FormController extends Controller
{
    //


    public function index(REQUEST $request,$title='AutoPilot')
    {
        $arrSearchResults=$request->input('arrSearchResults', null);
        $styleResultsDiv = $request->input('styleResultsDiv', 'display: none');
        $styleResultsTable = $request->input('styleResultsTable', 'display: none');
        $varStreetAddress = $request->input('varStreetAddress', null);
        $varZipCode = $request->input('varZipCode', null);
        $varSicCode = $request->input('varSicCode', null);
        $resultsCount = $request->input('resultsCount', 0);
        $varSearchRadius = $request->input('varSearchRadius', null);
        $srcMap=$request->input('srcMap',null);
//return view('form.index')->withInput();

        return view('form.index')->with(
            ['title' => $title,
            'styleResultsTable'=>$styleResultsTable,
            'styleResultsDiv'=>$styleResultsDiv,
            'arrSearchResults'=>$arrSearchResults,
            'varStreetAddress'=>$varStreetAddress,
            'varZipCode'=>$varZipCode,
            'varSicCode'=>$varSicCode,
            'varSearchRadius'=>$varSearchRadius,
            'resultsCount'=>$resultsCount,
            'srcMap'=>$srcMap
        ]);

    }

    public function searchProcess(Request $request,$title='AutoPilot')
    {
        # Validate the request data
        $validationRules=([
        'varStreetAddress' => 'required|string',
        'varSicCode' => 'required|not_in:0',
        'varZipCode' => 'required|digits:5',
        'varSearchRadius' => 'required|integer|between:1,10'
        ]);

        $errorMessages=([
        'varStreetAddress.required' => 'The "Street Address" field is required.',
        'varSicCode.required' => 'The "Vehicle Service Station" field is required.',
        'varZipCode.required' => 'The "Zip Code" field is required.',
        'varSearchRadius.required' => 'The "Search Radius" field is required.',
        'varStreetAddress.string' => 'The "Street Address" must be a string.',
        'varSicCode.digits:6' => 'The "Vehicle Service Station" field is required.',
        'varZipCode.digits:5' => 'The "Zip Code" field must be 5 digits (i.e. "12345").',
        'varSearchRadius.integer' => 'The "Search Radius" field must be an integer.',
        'varSearchRadius.integer' => 'The "Search Radius" field must be between 1 and 10 (miles).',
        ]);

        $request->validate($validationRules,$errorMessages);

        $arrGetReq=[];
        $arrSearchResults=[];
        $arrResults=[];
        $jsonSearchResults="";

        $varStreetAddress = $request->input('varStreetAddress', null);
        $varZipCode = $request->input('varZipCode', null);
        $varSicCode = $request->input('varSicCode', null);
        $varSearchRadius = $request->input('varSearchRadius', null);

        $arrGetReq=$request->all();
        $varMapquestApiKey='IriKNa9PzduxFw0DNM33MWGCwlXgkwqA';
        $varOrigin=$varStreetAddress.',+'.$varZipCode;
        $arrData = array('origin'=>$varOrigin,
        'radius'=>$varSearchRadius,
        'maxMatches'=>'10',
        'ambiguities'=>'ignore',
        'hostedData'=>'mqap.ntpois|group_sic_code=?|'.$varSicCode,
        'outFormat'=>'json',
        'key'=>$varMapquestApiKey
        );
        $q=http_build_query($arrData);
        $url='https://www.mapquestapi.com/search/v2/radius?'.$q;
        $arrResults = json_decode(file_get_contents($url,TRUE));
        $jsonSearchResults = json_encode($arrResults,JSON_PRETTY_PRINT);
        $arrSearchResults = json_decode($jsonSearchResults,true);


        $resultsCount=$arrSearchResults['resultsCount'];
        $srcMap=NULL;
        $poiLocations='';
        $arrPOIs=array();
        $arrMap=array();
        $srcMap="https://www.mapquestapi.com/staticmap/v4/getmap?";
        if($resultsCount==0)
        {
            $styleResultsDiv='display:initial';
            $styleResultsTable='display:none';
            $arrSearchResults=NULL;
        }
        else
        {
            $styleResultsDiv='display:initial';
            $styleResultsTable='display:initial';
            $arrPOIs[0]['lat']=$arrSearchResults['origin']['latLng']['lat'];
            $arrPOIs[0]['lng']=$arrSearchResults['origin']['latLng']['lng'];

            for($x=1;$x<$resultsCount-1;$x++)
            {
                $arrPOIs[$x]['lat']=$arrSearchResults['searchResults'][$x]['fields']['lat'];
                $arrPOIs[$x]['lng']=$arrSearchResults['searchResults'][$x]['fields']['lng'];
                $poiLocations .='purple-'.$arrSearchResults['searchResults'][$x]['resultNumber'].',';
                $poiLocations .=$arrSearchResults['searchResults'][$x]['fields']['lat'].',';
                $poiLocations .= $arrSearchResults['searchResults'][$x]['fields']['lng'].'|';
            }

            $arrMap=array(
                'size'=>'440,435',
                'key'=>$varMapquestApiKey,
                'type'=>'map',
                'imagetype'=>'JPEG',
                'pois'=>$poiLocations,
                'scenter'=>$arrPOIs[0]['lat'].','.$arrPOIs[0]['lng'],
                'zoom'=>7,
                'traffic'=>'flow',
                'scalebar'=>'true'
            );
            $srcMap .=http_build_query($arrMap);
        }


        return view('form.index')->with([
            'title'=>$title,
            'styleResultsTable'=>$styleResultsTable,
            'styleResultsDiv'=>$styleResultsDiv,
            'arrSearchResults'=>$arrSearchResults,
            'varStreetAddress'=>$varStreetAddress,
            'varZipCode'=>$varZipCode,
            'varSicCode'=>$varSicCode,
            'varSearchRadius'=>$varSearchRadius,
            'srcMap'=>$srcMap,
            'arrSearchResults'=>$arrSearchResults,
            'resultsCount'=>$resultsCount
        ]);



    }
}
