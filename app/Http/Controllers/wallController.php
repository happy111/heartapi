<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\country;
use App\state;
use App\cities;
use App\User;
use App\customer;
use App\wall;
use Input;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;
use Session;
use LucaDegasperi\OAuth2Server\Authorizer;
class wallController extends Controller {
    protected $authorizer;
    public function __construct(Authorizer $authorizer) {
        $this->authorizer = $authorizer;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */

    /**
     * @SWG\Post(
     *     path="/api/v1/wall",
     *     summary="Create a wall",
     *     tags={"Users"},
     *     description="Send the Parameters in POST Methods",
     *     operationId="wall",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     * * @SWG\Parameter(
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
     *    
     * @SWG\Parameter(
     *         name="Wall_Name",
     *         in="formData",
     *         description="Wall_Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * 
     * *  @SWG\Parameter(
     *         name="Temp_Name",
     *         in="formData",
     *         description="Temp_Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * *  @SWG\Parameter(
     *         name="Temp_ID",
     *         in="formData",
     *         description="Temp_ID",
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * *  @SWG\Parameter(
     *         name="Deceased_Name",
     *         in="formData",
     *         description="Deceased_Name",
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *  @SWG\Parameter(
     *         name="Deceased_Father_Name",
     *         in="formData",
     *         description="Deceased_Father_Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="Deceased_Husband_Name",
     *         in="formData",
     *         description="Deceased_Husband_Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="Relation_With_Deceased",
     *         in="formData",
     *         description="Relation_With_Deceased",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * * @SWG\Parameter(
     *         name="DOB_Of_Deceased",
     *         in="formData",
     *         description="DOB_Of_Deceased",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * * @SWG\Parameter(
     *         name="DOB_Of_Deceased",
     *         in="formData",
     *         description="DOB_Of_Deceased",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="Deceased_Photo",
     *         in="formData",
     *         description="Deceased_Photo",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * * @SWG\Parameter(
     *         name="Demise_Message",
     *         in="formData",
     *         description="Demise_Message",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="Is_Shareable",
     *         in="formData",
     *         description="Is_Shareable",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     )
  
     * 
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
        $wall = $request->all();
        $wall_name = wall::where('Wall_Name', $wall['Wall_Name'])->first();
        if (count($wall_name) == '')
		{
          //return($wall); 
		  $dt =date('d-m-Y');
          $wall_table_data = array(
                'Wall_Name' => $wall['Wall_Name'], 
				'Temp_Name' => $wall['Temp_Name'],
				'Temp_ID' => $wall['Temp_ID'], 
				'Deceased_Name' => $wall['Deceased_Name'], 
                'Deceased_Father_Name' => $wall['Deceased_Father_Name'],
                "Deceased_Husband_Name" => $wall['Deceased_Husband_Name'],
				"Relation_With_Deceased" => $wall['Relation_With_Deceased'],
                'DOB_Of_Deceased' =>$wall['DOB_Of_Deceased'],
				'DOD_Of_Deceased' => $wall['DOD_Of_Deceased'],
                "Deceased_Photo" => $wall['Deceased_Photo'],
				"Demise_Message" => $wall['Demise_Message'],
                'Is_Shareable' => $wall['Is_Shareable'],
                'created_at' => $dt
            );
			
			
	    //   print_r($wall_table_data); die;		
           $wall_data = \App\Wall::create($wall_table_data);
           $wall_datas = array(
                "Success" => true,
                "message" => 'Wall Saved Successfully'
            );
   

            return response()->json($wall_datas);
        } else {

            $wall_datas = array(
                "Success" => false,
                "message" => 'Wall Already Saved'
            );
            return response()->json($wall_datas);
        }
    }

    /**
     * @SWG\Get(
     *     path="/colorsoflife/api/v1/profile/",
     *     summary=" Customer Profile",
     *     tags={"Customers"},
     *     description="Show Profile Details of a Customer",
     *     operationId="customers",
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show() {



        $id = $this->authorizer->getResourceOwnerId();


        $customer = customer::where('user_id', $id)->get();
//return($customer);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */

    /**
     * @SWG\Post(
     *     path="/colorsoflife/api/v1/profile/update",
     *     summary="Update customer profile",
     *     tags={"Customers"},
     *     description="Send the Parameters in POST Methods",
     *     operationId="customers",
     *     consumes={"application/json"},
     *     produces={"application/json"},
     * * @SWG\Parameter(
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
     *    
     * @SWG\Parameter(
     *         name="first",
     *         in="formData",
     *         description="Customers Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * 
     * *  @SWG\Parameter(
     *         name="last",
     *         in="formData",
     *         description="lastname",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     *  @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Email address",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="pass",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * * @SWG\Parameter(
     *         name="mobile",
     *         in="formData",
     *         description="Mobile number ",
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
    public function update(Request $request) {

        $data = $request->json()->all();
       //return ($data);
        $userid = $this->authorizer->getResourceOwnerId();
        
       if (isset($data['name'])) {
                $coustomer_data['name'] = $data['name'];
                //return ($company_data['name']);
            }
             if (isset($data['mobile'])) {
                $coustomer_data['mobile'] = $data['mobile'];
                //return ($company_data['name']);
            }
            if (isset($data['email'])) {
                $coustomer_data['email'] = $data['email'];
                //return ($company_data['name']);
            }
            
             if (Input::hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = base_path() . '/public/uploads/customer_profile';
                $url_path = url('/public/uploads/customer_profile');
                $photo = $image->move($destinationPath, $image->getClientOriginalName());
                $coustomer_data['image'] = $url_path . '/' . $request->file('image')->getClientOriginalName();
                //return($coustomer_data['image']);
            }

        //return ($coustomer_data);
        

       // $customer = customer::where('user_id', $userid)->first();

       // $customer->update($coustomer_data);

        
        $customer = customer::where('user_id', $userid)->update($coustomer_data);

        
          if ($customer) {
                        $returndata['success'] = true;
                    } else {
                        $returndata['error'] = true;
                    }
        $user_data = array(
            "id" => $userid,
            
            
        );
        
        
        if (isset($name)) {
                $user_data['name'] = $name;
                //return ($company_data['name']);
            }
            if (isset($data['pass'])) {
                $user_data['pass'] =bcrypt($password);
                //return ($company_data['name']);
            }
             
            if (isset($data['email'])) {
                $user_data['email'] = $data['email'];
                //return ($company_data['name']);
            }

        $user = \App\User::where('id', $userid)->first();
        
       
        $user->update($user_data);
        
      

       // return response()->json('Record Update');
      
                    return response()->json($returndata);
                
        
        
    }

}
