<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\country;
use App\state;
use App\cities;
use App\User;
use App\customer;
use Input;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;
use Session;
use LucaDegasperi\OAuth2Server\Authorizer;
class customerController extends Controller {
  

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */

    /**
     * @SWG\Post(
     *     path="/api/v1/register",
     *     summary="Create a customer",
     *     tags={"Users"},
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
     *         name="fname",
     *         in="formData",
     *         description="Users First Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
     * 
     * *  @SWG\Parameter(
     *         name="lname",
     *         in="formData",
     *         description="Users Last Name",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * *  @SWG\Parameter(
     *         name="mname",
     *         in="formData",
     *         description="Users Middle Name",
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),
	 * *  @SWG\Parameter(
     *         name="dob",
     *         in="formData",
     *         description="Users Date Of Birth",
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
	 * * @SWG\Parameter(
     *         name="facebook",
     *         in="formData",
     *         description="Facebook ID",
     *         required=true,
     *         type="string",
     *         @SWG\Items(type="string"),
     *         collectionFormat="multi"
     *     ),


  
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
	 
        $customer = $request->all();
		
		//print_r($customer); die;
		
        $customer_role = customer::where('email', $customer['email'])
                ->where('mobile', $customer['mobile'])->first();
				
			
        if (count($customer_role) == '')
		{
           //return(count($customer_role)); 
            $password = $customer['Password'];  
            $user_table_data = array(
                'fname' => $customer['First_Name'], 
				'lname' => $customer['Last_Name'],
				'mname' => $customer['Middle_Name'], 
				'dob' => $customer['Date_Of_Birth'], 
                'email' => $customer['email'],
                "mobile" => $customer['mobile'],
				"facebook" => $customer['Facebook_ID'],
                'password' => bcrypt($password),
                'is_customer' => '1'
            );

            $user_data = \App\User::create($user_table_data);
           $rowId = $user_data->id;  
            $coustomer_data = array(
                "user_id" => $rowId,
				'fname' => $customer['First_Name'], 
            	'lname' => $customer['Last_Name'],
				'mname' => $customer['Middle_Name'], 
				'dob' => $customer['Date_Of_Birth'], 
                'email' => $customer['email'],
                "mobile" => $customer['mobile'],
				"facebook" => $customer['Facebook_ID'],
                'pass' => bcrypt($password)
            );
            $customers = \App\customer::create($coustomer_data);
            
            //return ($customers);
    
            $customer_registration = array(
                "Success" => true,
                "message" => 'Customer Registered Successfully'
            );
   

            return response()->json($customer_registration);
        } else {

            $customer_registration = array(
                "Success" => false,
                "message" => 'Customer Already Registered'
            );
            
            

            return response()->json($customer_registration);
        }
    }

    /**
     * @SWG\Get(
     *     path="/heartapi/v1/profile/",
     *     summary=" Users Profile",
     *     tags={"Users"},
     *     description="Show Profile Details of a Users",
     *     operationId="users",
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
    public function show() 
	{
		  $user = \App\User::all();
          return response()->json($user);
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
