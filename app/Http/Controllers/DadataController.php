<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DadataController extends Controller
{
  private $dadata;

  function __construct()
  {
    $this->dadata = new \Dadata\DadataClient(env('DADATA_API_KEY'), env('DADATA_SECRET_KEY'));
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function validateAddress(Request $request)
  {
    return response()->json($this->dadata->clean('address', $request->input('str')));
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function addressGeocode(Request $request)
  {
    return response()
      ->json($this->dadata->geolocate('address', $request->input('lat'), $request->input('ion')));
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function geoIpCity(Request $request)
  {
    return response()->json($this->dadata->iplocate($request->input('ip')));
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function suggestAddress(Request $request)
  {
    return response()->json($this->dadata->suggest('address', $request->input('str')));
  }

  public function getCompanyInfo(Request $request)
  {
    $source = new \Dadata\DadataClient(env('DADATA_API_KEY'), env('DADATA_SECRET_KEY'));
    $info = $source->findById('party', $request->input('inn'), 1);
    return response()->json($info);
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function findById(Request $request)
  {
    return response()->json($this->dadata->findById('party', $request->input('inn'), 1));
  }
}
