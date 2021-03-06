<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Profile;
use App\Post;
use App\Category;
use App\Comment;
use App\Portfolio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
// ----One To Many Relationship---------


Route::get('/create_post',  function(){
    // $user = User::create([
    // 	'name' => 'Sumon',
    // 	'email' => 'sumon@gmail.com',
    // 	'password' => Hash::make('123123'),


    // ]);


    $user = User::findOrFail(1);


    $user->posts()->create([
        'title' => 'Admin 1st post Title',
        'body' => 'Admin 1st Post Body sdfsd sdfsd sdfsdf sdfsdf ',
    ]);
    return 'Success';
});


Route::get('/red_posts', function(){
    $user = User::find(4);
    $posts = $user->posts()->get();


    foreach ($posts as $post) {
        $data[] = [
            'name' => $post->user->name,
            'post_id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
        ];
    }


    // $post = $user->posts()->first();


    // 	$data[] = [
    // 		'name' => $post->user->name,
    // 		'title' => $post->title,
    // 		'body' => $post->body,
    // 	];
    return $data;
});


Route::get('/update_post', function(){
    $user = User::findOrFail(4);
    // $user->posts()->where('id', 1)->update([
    // 	'title' => 'Update Title 2',
    // 	'body' => 'Update Body 2',


    // ]);


    $user->posts()->whereId(2)->update([
        'title' => 'Update Title',
        'body' => 'Update Body',


    ]);
    return 'Success';
});


Route::get('/delete_post', function(){
    $user = User::find(3);


    // $user->posts()->whereId(1)->delete();
    // $user->posts()->where('id', 1)->delete();
    $user->posts()->whereUserId(3)->delete();


    return 'Success';
});
// ----Many To Many Relationship---------
Route::get('/create_categories', function(){
//     $post = Post::findOrFail(1);
//
//
//     $post->categories()->create([
//     	'category' => 'PHP laravel',
//     	'slug' => Str::slug('PHP laravel', '-'),
//
//     ]);
//     return 'Success';


    $user = User::create([
        'name' => 'New Admin',
        'email' => 'newadmin@gmail.com',
        'password' => Hash::make('123123'),
    ]);
    $user->posts()->create([
        'title' => 'New Post Title',
        'body' => 'New Post Body',
    ])->categories()->create([
        'category' => 'New Category',
        'slug' => Str::slug('New Category', '-'),
    ]);
    return 'Success';
});


Route::get('/read_category', function(){
    $post = Post::find(4);
    $categories = $post->categories->where('id', 1);
     foreach ($categories as $category) {
        echo $category->category.'<br>';
    }


    // $category = Category::find(3);
    // $posts = $category->posts;


    // foreach ($posts as $post) {
    // 	echo $post->title . '<br>';
    // }


});


Route::get('/attach', function(){
    $post = Post::find(4);
    $post->categories()->attach([1, 3, 4]);


    return 'Success';
});


Route::get('/detach', function(){
    $post = Post::find(4);
    $post->categories()->detach([3,1]);

    return 'Success';
});


Route::get('/sync', function(){
    $post = Post::find(1);
    $post->categories()->sync([2,4]);

    return 'Success';
});

// ----Has Many Through Relationship---------
Route::get('/country/create', function(){
//    $user = \App\Country::create([
//        'name' => 'USA',
//    ]);
    $country = \App\Country::find(1);


    return $country->posts;
});
// ----Polymorphic Relationship---------
Route::get('/comment/create', function(){
//     $post = Post::find(1);
//     $post->comments()->create([
//     	'user_id' => 1,
//     	'content' => '1st Comments 1st post'
//     ]);
//    $user = User::find(2);
//    $user->portfolios()->create([
//        'title' => '1st Profile title',
//        'body' => '1st Profile Body'
//    ]);
    $portfolio = Portfolio::find(1);
    $portfolio->comments()->create([
        'user_id' => 1,
        'content' => '1st Comments 1st Profile'
    ]);
    return 'Success';
});
Route::get('/comment/read', function(){
//     $post = Post::findOrFail(1);
//     $comments = $post->comments;
//
//
//     foreach ($comments as $comment) {
//     	echo $comment->user->name . '-' . $comment->content . '(' . $comment->commentable->title . ') <br>';
//     }
//
//     exit();

    $portfolio = Portfolio::findOrFail(1);
    $comments = $portfolio->comments;


    foreach ($comments as $comment) {
        echo $comment->user->name . '-' . $comment->content . '(' . $comment->commentable->title . ') <br>';
    }
//    return $comments;
});
Route::get('/comment/update', function(){
//     $post = Post::find(1);
//     $comment = $post->comments()->whereId(1)->first();
//     $comment->update([
//     	'content' => 'Update Comments Data',
//     ]);
//    dd($comment);


    $portfolio = Portfolio::find(1);
    $comment = $portfolio->comments()->where('id', 2)->first();
    $comment->update([
        'content' => 'Update Portfolio Comments Data',
    ]);
    return 'Success';
});
Route::get('/comment/delete', function(){
//     $post = Post::find(1);
//     $comment = $post->comments()->where('id', 1)->delete();
//
//     exit();

    $portfolio = Portfolio::find(1);
    $comment = $portfolio->comments()->where('id', 2)->delete();
    return 'Success';
});
// ----Many to Many Polymorphic Relationship---------
Route::get('/tag/read', function(){
//     $post = Post::find(1);
//     // return $post->tags;
//     foreach ($post->tags as $tag){
//     	echo $tag->name ."<br>";
//     }
    $portfolio = Portfolio::find(1);
    // return $post->tags;
    foreach ($portfolio->tags as $tag){
        echo $tag->name ."<br>";
    }
});
Route::get('/tag/attach', function(){
//    $tag = new \App\Tag();
//    $tag->create([
//        'name' => 'Tag 3',
//    ]);
//    exit();
//     $post = Post::find(1);
//     $post->tags()->attach([1,2]);
    $portfolio = Portfolio::find(1);
    $portfolio->tags()->attach([2]);
    return 'Success';
});
Route::get('/tag/detach', function(){
//     $post = Post::find(1);
//     $post->tags()->detach([2]);
    $portfolio = Portfolio::find(1);
    $portfolio->tags()->detach([3]);
    return 'Success';
});
Route::get('tag/sync', function(){
//     $post = Post::find(1);
//     $post->tags()->sync([3,2]);


    $portfolio = Portfolio::find(1);
    $portfolio->tags()->sync([3]);


    return 'Success';
});
