<?php
 public function postCreate(Request $request)
  {
      /*$rules = array(

        'name' => 'required',
        'cover_image'=>'required|image'

    );*/

      $rules = ['name' => 'required', 'cover_image'=>'required|image' , 'date' => 'required', 'prix' => 'required', 'nbpart' => 'required', 'description' => 'required'];

      $input = ['name' => null];

      //Validator::make($input, $rules)->passes(); // true

      $validator = Validator::make($request->all(), $rules);
      if($validator->fails()){
        // return Redirect::route('create_album_form') ;
        return redirect()->route('create_album_form')->withErrors($validator)->withInput();
      }

      // $file = Input::file('cover_image');
      $file = $request->file('cover_image');
      $random_name = str_random(8);
      $destinationPath = 'albums/';
      $extension = $file->getClientOriginalExtension();
      $filename=$random_name.'_cover.'.$extension;
      $uploadSuccess = $request->file('cover_image')->move($destinationPath, $filename);

      
      $album = Evenement::create(array(
                  	    'date' => $request->get('date'),
                  		'description' => $request->get('description'),
                  		'cover_image' => $filename,
                  		'nbpart' => $request->get('nbpart'),
                          'name' => $request->get('name'),
                  		'prix' => $request->get('prix')      
      ));
	  
	  $tasks=Evenement::all();
       return view('evenement',compact('tasks'));

     // return redirect()->route('show_album',['id'=>$album->id]);
	// return redirect()->route('show_album',['id'=>$album->id]);
  }
