<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('welcome');
});
// ----One To One Relationship---------
Route::get('/create_user', function () {
    $user = User::create([
        'name' => 'Admin2',
        'email' => 'admin2@gmail.com',
        'password' => Hash::make('123123'),
    ]);
    return $user;
});


Route::get('/create_profile', function () {
//     $profile = Profile::create([
//     	'user_id' => 1,
//     	'phone' => '123456',
//     	'address' => 'Dhaka',
//     ]);
//     return $profile;


    $user = User::find(2);
    $user->profile()->create([
        'phone' => '923743242',
        'address' => 'Jakata2',
    ]);
    return $user;
});


Route::get('/create_user_profile', function () {
    $user = User::find(1);

    $profile = new Profile([
        'phone' => '1233333',
        'address' => 'Uttra'
    ]);
    $user->profile()->save($profile);

    return $user;
});


Route::get('/read_user', function () {
    $user = User::find(1);
    // return $user->profile->address;
    $data = [
        'name' => $user->name,
        'phone' => $user->profile->phone,
        'address' => $user->profile->address,
    ];
    return $data;
});


Route::get('read_profile', function () {
    $profile = Profile::where('address', 'Jakata2')->first();
    // return $profile->user->name;
    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->phone,
        'address' => $profile->address,
    ];


    return $data;
});


Route::get('/update_profile', function () {
    $user = User::find(1);


    // $user->profile()->update([
    // 	'phone' => '0987654',
    // 	'address' => 'Shariatpur',
    // ]);


    $data = [
        'phone' => '435345345',
        'address' => 'Pabna',
    ];


    $user->profile()->update($data);

    return $user;
});


Route::get('/delete_profile', function () {
    $user = User::find(3);


    $user->profile()->delete();


    return $user;
});
