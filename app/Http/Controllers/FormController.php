<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class FormController extends Controller
{
    //
    public function index(REQUEST $request,$title=NULL,$htmlSearchResults=NULL,$tblDisplayStyle='none')
    {
        $title='Vehicle Buddy';
        $varStreetAddress = $request->input('varStreetAddress', null);
        $varZipCode = $request->input('varZipCode', null);
        $varSicCode = $request->input('varSicCode', null);
        $varSearchRadius = $request->input('varSearchRadius', null);
        return view('form.index')->with(['title' => $title,'tblDisplayStyle'=>$tblDisplayStyle,'htmlSearchResults'=>$htmlSearchResults,'varStreetAddress'=>$varStreetAddress]);
    }

    public function searchProcess(Request $request,$title=NULL,$tblDisplayStyle='initial')
    {
        $title='Vehicle Buddy';
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
            $htmlSearchResults='<p>No stations found.</p>';
        }

        else
        {
            $boolShowTable=false;

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
        $tblDisplayStyle='initial';

        return view('form.index')->with(
            ['title' => $title,
            'varStreetAddress' =>$varStreetAddress,
            'varZipCode'=>$varZipCode,
            'varSicCode'=>$varSicCode,
            'varSearchRadius'=>$varSearchRadius,
            'tblDisplayStyle'=>$tblDisplayStyle,
            'htmlSearchResults'=>$htmlSearchResults]);
    }
}
