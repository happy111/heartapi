<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Intervention\Image\Facades\Image as Image;
use App\level;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;

class levelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    
     /**
     * @SWG\Get(
     *     path="/colorsoflife/api/v1/levels/",
     *     summary=" levels",
     *     tags={"levels"},
     *     description="Show all Levels",
     *     operationId="levels",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     
     * @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string",
     *          default = "Bearer nR3ISGBIL3IQHINNVEcKRU7uQeRHRAqVZpSabEFK",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * 
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",    
     *         
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     */
    
    public function index()
    {
        
        
         $level = level::all();
       return response()->json($level);
     
        
        
        
    }



/**
     * @SWG\Post(
     *     path="/heartapi/api/v1/levels/create",
     *      summary=" levels",
     *     tags={"levels"},
     *     description="Level create",
     *     operationId="levels",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     *     
     * @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         description="Authorization Token",
     *         required=true,
     *         type="string",
     *          default = "Bearer nR3ISGBIL3IQHINNVEcKRU7uQeRHRAqVZpSabEFK",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *
     ** @SWG\Parameter(
    *         name="level_name",
    *         in="formData",
    *         description="Level Name",
    *         required=true,
    *         type="string",
    *         @SWG\Items(type="string"),
    *         collectionFormat="multi"
    *     ),
    * @SWG\Parameter(
    *         name="weight",
    *         in="formData",
    *         description="Weight",
    *         required=true,
    *         type="string",
    *         @SWG\Items(type="string"),
    *         collectionFormat="multi"
    *     ),
    * @SWG\Parameter(
    *         name="color",
    *         in="formData",
    *         description="Color",
    *         required=true,
    *         type="string",
    *         @SWG\Items(type="string"),
    *         collectionFormat="multi"
    *     ),
    * @SWG\Parameter(
    *         name="image",
    *         in="formData",
    *         description="Image",
    *         required=true,
    *         type="string",
    *         @SWG\Items(type="string"),
    *         collectionFormat="multi"
    *     ),
     * 
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",    
     *         
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     )
     * )
     */

    public function store(Request $request)
    {
		//return "ssdf";  die;
    //    $levels =$request->json()->all();
		
		      $levels =$request->json()->all();
		
         $level = array
		   (
            "weight" => $levels['weight'],
            );
		 $levelss = level::create($level);
         return response()->json($levelss);
    }
  public function create(Request $request)
    {
		
    //    $levels =$request->json()->all();
		
		      $levels =$request->all();
			  
			  
			  print_r($levels);  die;
		
         $level = array
		   (
            "weight" => $levels['weight'],
            );
		 $levelss = level::create($level);
         return response()->json($levelss);
    }

    
    
    
    
    
}
