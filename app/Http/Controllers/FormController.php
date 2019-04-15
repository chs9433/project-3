<?php

namespace App\Http\Controllers;

//use Validator;
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
        $jsonSearchResults = $request->input('jsonSearchResults', null);
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
            'jsonSearchResults'=>$jsonSearchResults
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
/*
        $request->validate([
        'varStreetAddress' => 'required|string',
        'varSicCode' => 'required|digits:6',
        'varZipCode' => 'required|digits:5',
        'varSearchRadius' => 'required|integer|between:1,10'
        ]);
        $request->messages(['varStreetAddress.required' => 'This field is required Chris.']);
*/
$request->validate($validationRules,$errorMessages);

        $arrGetReq=[];
        $jsonSearchResults=[];
        $arrSearchResults=[];
        $searchResults=[];
        $htmlSearchResults="";


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
        $rslt="";

        $resultsCount=$arrSearchResults['resultsCount'];

        if($resultsCount==0)
        {
            $styleResultsDiv='display:initial';
            $styleResultsTable='display:none';
            $arrSearchResults=NULL;
            $htmlSearchResults=NULL;
            $jsonSearchResults=NULL;
        }
        else
        {
            $styleResultsDiv='display:initial';
            $styleResultsTable='display:initial';
            for($x=0;$x<$resultsCount;$x++)
            {
                $htmlSearchResults .='<tr>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['resultNumber'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['distance'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['name'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['fields']['address'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['fields']['city'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['fields']['state'].'</td>';
                $htmlSearchResults.='<td>'.$arrSearchResults['searchResults'][$x]['fields']['postal_code'].'</td>';
                $htmlSearchResults .='<td>'.$arrSearchResults['searchResults'][$x]['fields']['phone'].'</td>';
                $htmlSearchResults .='</tr>';

            }
        }


        return view('form.index')->with(
            ['title'=>$title,
                'styleResultsTable'=>$styleResultsTable,
            'styleResultsDiv'=>$styleResultsDiv,
            'arrSearchResults'=>$arrSearchResults,
            'varStreetAddress'=>$varStreetAddress,
            'varZipCode'=>$varZipCode,
            'varSicCode'=>$varSicCode,
            'varSearchRadius'=>$varSearchRadius,
            'jsonSearchResults'=>$jsonSearchResults,
            'arrSearchResults'=>$arrSearchResults,
            'resultsCount'=>$resultsCount
        ]);



    }
}
