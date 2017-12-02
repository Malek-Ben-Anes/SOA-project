<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Auth::routes();

Route::resource('task', 'TaskController');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/flanci', function() {
    return view('welcome');
});

Route::get('register-freelancer', [
    function() {
        return view('auth.registerFreelancer');
    },
    'as' => 'freelancer.register'
]);

Route::get('register-enterprise', [
    function() {
        return view('auth.registerEnterprise');
    },
    'as' => 'enterprise.register'
]);

// the registration route for web
Route::post('register-freelancer', ['uses' => 'Auth\RegisterController@registerFreelancer', 'as' => 'freelancer.register']);

// the registration route for web
Route::post('register-enterprise', ['uses' => 'Auth\RegisterController@registerEnterprise', 'as' => 'enterprise.register']);







/*
  |--------------------------------------------------------------------------
  | Web Services Just set api/v1/url
  |--------------------------------------------------------------------------
  |
 */



Route::group(['prefix' => 'api/v1/'], function() {

    /*
      | These controllers handle the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

// Route::abort(404, 'The resource you are looking for could not be found');




    Route::resource('freelancer', 'FreelancerController');

    Route::get('login', function() {
        return view('auth.login');
    });

    // the login route for api
    Route::post('login', ['uses' => 'Auth\LoginController@loginUser', 'as' => 'api.login']);
    // the route for logout method api
    Route::get('logout', ['uses' => 'Auth\LoginController@logoutUser', 'as' => 'api.logout']);

    // the registration route for apiet-notifications
    Route::post('register-freelancer', ['uses' => 'Auth\RegisterController@registerFreelancer', 'as' => 'api.registerFreelancer']);

// the registration route for api
    Route::post('register-enterprise', ['uses' => 'Auth\RegisterController@registerEnterprise', 'as' => 'api.registerEnterprise']);



    Route::get('/showUsers/{id}', ['uses' => 'Auth\LoginController@showProfile', 'as' => 'api.user']);

    Route::get('/get-all-notifications/{user_id}', ['uses' => 'NotificationController@getAllNotifications', 'as' => 'api.notification'])->where('user_id', '[0-9]+');


    Route::get('/get-all-messages/{user_id}', ['uses' => 'MessageController@getAllMessages', 'as' => 'api.message'])->where('user_id', '[0-9]+');

    Route::get('/get-discussion/{receiver_id}/with/{sender_id}', ['uses' => 'MessageController@getDiscussion', 'as' => 'api.discussion'])->where('receiver_id', '[0-9]+');





    /**
     * all routes for freelancers
     * get all freelancers
     * get freelancer by user_id
     * get freelancer by freelancer_id
     * update freelancer
     */
    Route::get('/get-all-freelancers', 'FreelancerController@getAllFreelancers');

    Route::get('/get-freelancer-by-id/{freelancer_id}', 'FreelancerController@getFreelancerById')->where('freelancer_id', '[0-9]+');

    Route::post('/update-freelancer', 'FreelancerController@changeFreelancerProfile');

    Route::post('/update-freelancer-with-cv', 'FreelancerController@changeFreelancerCV');

    Route::post('/update-freelancer-image', 'FreelancerController@changeFreelancerImage');


    Route::post('/update-only-freelancer-image', 'FreelancerController@changeOnlyFreelancerImage');

    Route::post('/update-freelancer-background-image', 'FreelancerController@changeFreelancerImage');










    /**
     * all routes for freelancers
     * get all freelancers
     * get freelancer by user_id
     * get freelancer by freelancer_id
     * update freelancer
     */
    Route::get('/get-all-enterprises', 'EnterpriseController@getAllEnterprises');

    Route::get('/get-enterprise-by-id/{enterprise_id}', 'EnterpriseController@getEnterpriseById')->where('enterprise_id', '[0-9]+');

    Route::get('/get-all-enterprise-projects/{enterprise_id}/by-user-id/{freelancer_id}', 'EnterpriseController@getAllEnterpriseProjects')->where('enterprise_id', '[0-9]+');

    Route::get('/get-enterprise-by-name/{enterprise_name}', 'EnterpriseController@getEnterpriseByName');

    Route::get('/get-projects-by-skills/{skill_name}/by-user-id/{freelancer_id}', 'ProjectController@getProjectsBySkillName');



    Route::resource('task', 'TaskController');


    /**
     * all routes for skills
     * get all skills
     * get freelancer by user_id
     * get freelancer by freelancer_id
     * update freelancer
     */
    Route::get('/get-all-skills', 'SkillController@getAllSkills');


    Route::get('/get-all-suggestions-by-name/{skill_name}', 'SkillController@getAllSkillsByName');

    Route::get('/search-for-freelancer-by-skills/{skill_name}', 'SkillController@searchForFreelancerBySkills');


    Route::get('/get-freelancer-skills/{freelancer_id}', 'FreelancerController@getFreelancerSkills')->where('freelancer_id', '[0-9]+');

    Route::post('/update-freelancer-skills', ['uses' => 'FreelancerController@updateFreelancerSkills', 'as' => 'api.UpdateFreelancerSkills']);


    Route::post('/update-freelancer-skills', ['uses' => 'FreelancerController@updateFreelancerSkills', 'as' => 'api.UpdateFreelancerSkills']);

    Route::get('/get-all-challenges-by-skills/{skill_name}', 'ChallengeController@showChallengesSkills');


    Route::get('/add-skill-by-id/{skill_id}', 'SkillController@addFreelancerSkill')->where('skill_id', '[0-9]+');

    Route::get('/delete-skill-by-id/{skill_id}', 'SkillController@deleteFreelancerSkill')->where('skill_id', '[0-9]+');

    Route::get('/add-project/{project_id}/skill/{skill_id}', 'SkillController@addProjectSkill')->where('skill_id', '[0-9]+');

  Route::get('/delete-project/{project_id}/skill/{skill_id}', 'SkillController@deleteProjectSkill')->where('skill_id', '[0-9]+');

    Route::get('/get-project-skills/{project_id}', 'ProjectController@getProjectSkills')->where('project_id', '[0-9]+');

    Route::get('/unlock-freelancer/{freelancer_id}', ['uses' => 'EnterpriseController@unlockFreelancer', 'as' => 'freelancer.unlock'])->where('freelancer_id', '[0-9]+');



    /**
     * all routes for skills
     * get all skills
     * get freelancer by user_id
     * get freelancer by freelancer_id
     * update freelancer
     */
    Route::get('/get-all-projects', 'ProjectController@getAllProjects');
    Route::get('/get-all-projects-by-id/{freelancer_id}', 'ProjectController@getAllProjectsWithInterestAndParticipation')->where('project_id', '[0-9]+');

    Route::get('/get-all-projects-freelancer-interested-in-by-id/{freelancer_id}', 'ProjectController@getAllInterestingProjects')->where('freelancer_id', '[0-9]+');

    Route::get('/get-all-challenges-freelancer-participated-in-by-id/{freelancer_id}', 'ProjectController@getAllParticipatedInProjects')->where('freelancer_id', '[0-9]+');



    Route::get('/get-challenges-by-project-id/{project_id}', 'ProjectController@getAllProjectChallenges')->where('project_id', '[0-9]+');

    // Route::get('/get-all-project-details','ProjectController@getAllProjects');
// web service :interest for web 
    Route::get('/get-interested-in-project/{project_id}', 'ProjectController@getInterestedThroughWeb')->where('project_id', '[0-9]+');

    Route::get('/get-interested/{freelancer_id}/project/{project_id}', 'ProjectController@getInterested')->where('freelancer_id', '[0-9]+');


// web service :notification for web 
    Route::get('/get-notifications', 'NotificationController@getAllNotificationWeb');

// web service :interest for web 
    Route::get('/get-disinterested-in-project/{project_id}', 'ProjectController@getDisinterestedThroughWeb')->where('project_id', '[0-9]+');


    Route::get('/get-disinterested/{freelancer_id}/project/{project_id}', 'ProjectController@getDisinterested')->where('freelancer_id', '[0-9]+');

    Route::post('/send-notification', 'NotificationController@sendNotification');

    Route::post('/send-message', 'MessageController@send');

    Route::post('/send-comment', 'UserController@sendComment');

    Route::get('/get-all-challenges', 'ChallengeController@getAllChallenges');

    Route::get('/get-all-comments/{project_id}', 'ProjectController@getAllComments');

    Route::post('/freelancer-participation', 'ProjectController@saveFreelancerParticipation');

    Route::get('/get-freelancer-participation/{freelancer_id}/project/{project_id}', 'ProjectController@getFreelancerParticipation');

    Route::get('/get-all-packs', 'PackController@getAllPacks');

    Route::get('/get-all-transactions/{user_id}', 'PackController@getAllTransactions');

    Route::post('/save-transaction', 'PackController@saveTransaction');

    Route::get('/get-all-features', 'PackController@getAllFeatures');

    Route::get('/unlock-freelancer-profile/{freelancer_id}/by-user-id/{user_id}', 'FreelancerController@unlockFreelancerProfile');

    Route::get('/get-freelancer-profile/{freelancer_id}/by-user-id/{user_id}', 'FreelancerController@getFreelancerProfile');

    Route::get('/get-all-freelancers-unlocked-profiles-by-user-id/{freelancer_id}', 'FreelancerController@getFreelancersUnlockedProfiles');
});








/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */






Route::resource('enterprise', 'EnterpriseController');
Route::resource('freelancer', 'FreelancerController');
Route::resource('project', 'ProjectController');
Route::resource('challenge', 'ChallengeController');
Route::resource('device', 'DeviceController');
Route::resource('skill', 'SkillController');
Route::resource('criterion', 'CriterionController');
Route::resource('comment', 'CommentController');
Route::resource('pack', 'PackController');
// Route::resource('notification', 'NotificationController');
Route::resource('participation', 'ParticipationController');


Route::get('/get-enterprise/{enterprise_id}/project', 'EnterpriseController@indexProject')->where('enterprise_id', '[0-9]+');

Route::get('/search-for-projects', ['uses' => 'HomeController@search', 'as' => 'project.search']);

Route::get('/get-enterprise/{enterprise_id}/project/{project_id}', 'EnterpriseController@indexProject');

Route::get('/get-enterprise-profiles-deblocked/{enterprise_id}', ['uses' => 'EnterpriseController@deblocked', 'as' => 'enterprise.deblocked']);


Route::get('/get-all-projects-freelancer-interested-in', ['uses' => 'FreelancerController@showInterestedProject', 'as' => 'freelancer.interested']);

Route::get('/get-all-challenges-freelancer-participated-in', ['uses' => 'FreelancerController@showParticipatedChallenge', 'as' => 'freelancer.participated']);

Route::get('/get-all-challenge-mark-grid/{challenge_id}', ['uses' => 'CriterionController@showByChallenge', 'as' => 'marks.show'])->where('challenge_id', '[0-9]+');


Route::put('/update-only-freelancer-image', ['uses' => 'FreelancerController@changeOnlyFreelancerImageWeb', 'as' => 'freelancer.image']);


// Route::get('/get-freelancer/{freelancer_id}/challenge-marks-details/{challenge_id}',['uses' => 'FreelancerController@showParticipatedChallenge', 'as' => 'freelancer.participated']);



Route::get('/upload-freelancer-work', ['uses' => 'ChallengeController@show', 'as' => 'challenge.upload']);

Route::post('/upload-freelancer-work', ['uses' => 'ChallengeController@upload', 'as' => 'challenge.upload']);

Route::get('/freelancer-challenge/{challenge_id}/work/{participation_id}', ['uses' => 'ParticipationController@show', 'as' => 'showParticipation'])->where('challenge_id', '[0-9]+');


Route::post('send-operator-code', ['uses' => 'PackController@firstApiWebService', 'as' => 'billing.firstWebService']);

Route::post('send-operator-location', ['uses' => 'PackController@secondApiWebService', 'as' => 'billing.secondWebService']);


Route::get('show-transactions', ['uses' => 'PackController@showTransactions', 'as' => 'billing.transactions']);

Route::post('sponsorize-project', ['uses' => 'ProjectController@sponsorizeProject', 'as' => 'project.sponsored']);

Route::put('publish-project', ['uses' => 'ProjectController@publish', 'as' => 'project.publish']);

// Route::post('execute-transaction', ['uses' => 'PackController@thirdApiWebService', 'as' => 'billing.thirdWebService']);

//http://esbenp.github.io/2016/04/11/modern-rest-api-laravel-part-1/;