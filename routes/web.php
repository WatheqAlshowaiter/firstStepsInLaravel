<?php

use App\Country;
use App\OneToOnAddress;
use App\OneToOneUser;
use App\Photo;
use Illuminate\Support\Facades\Route;
use App\User;
use App\Post;
use App\Tag;
use Faker\Provider\ar_JO\Address;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/contact', function () {
//     return "contact page";
// });

// Route::get('/posts/{name}/{id}', function ($name, $id) {
//     return "This is post's name: $name, witch his id is $id";
// });

// // Naming routes
// Route::get('/admin/posts/edit', ['as' => 'admin.edit', function () {
//     $url = route('admin.edit');
//     return "This url is $url";
// }]);

// Route::get('admin/posts/{id}', 'PostsController@index');

Route::resource('posts', 'PostsController');

Route::get('/contact', 'PostsController@contact');

// Route::get('/post/{id}/{title}', 'PostsController@post');

Route::get('/insert', function () {
    DB::insert("INSERT into posts SET title=:title, content=:content ", ['php titles', 'some content']);
});

Route::get('/read', function () {
    $result = DB::select('Select * from posts where id = :id', [1]);
    foreach ($result as $post) {
        return $post->title . ", " . $post->content;
    }
});
Route::get('/update', function () {
    return DB::update('UPDATE posts SET title= "updated title" where id =:id', [1]);
});

Route::get('/delete', function () {
    return DB::update('DELETE FROM posts where id =:id', [3]);
});

// Route::get('/insert',function(){
//     DB::insert("INSERT into posts SET title=:title, content=:content ",['php titles', 'some content']);
// });

// Route::get('/read',function(){
//     $result = DB::select('Select * from posts where id = :id',[1]);
//     foreach($result as $post){ return $post->title .", " .$post->content;}
// });
// Route::get('/update',function(){
//     return DB::update('UPDATE posts SET title= "updated title" where id =:id',[1]);
// });

// Route::get('/delete',function(){
//     return DB::update('DELETE FROM posts where id =:id',[3]);
// });


/**
 * Elequent ORM
 */

//  Read
Route::get('/findall', function () {
    $posts = Post::all();
    foreach ($posts as $post) {
        echo $post->title . "<br>";
    }
});
Route::get('/find', function () {
    $post = Post::find(1);
    return $post->title;
});

Route::get('/findwhere', function () {
    return Post::where('id', 1)->orderBy('id', 'desc')->take(1)->get();
});

Route::get('/findfail', function () {
    return Post::findOrFail(3); // 3 is not inserted
});

Route::get('/findwhere2', function () {
    $posts =  Post::where('id', '>', 1)->orderBy('content', 'desc')->get();
    return $posts;
});

Route::get('/basicinsert', function () {
    $post = new Post;
    $post->title = 'inserted title';
    $post->content = 'inserted contents inserted contents';
    $post->save();
});

Route::get('/basicupdate', function () {
    $post = Post::find(5);
    $post->title = 'updated title';
    $post->content = 'updated contents updated contents';
    $post->save();
});

Route::get('/create', function () {
    Post::create([
        'title' => 'new created title',
        'content' => 'new created content'
    ]);
});

Route::get('/update', function () {
    Post::where('id', 2)->where('is_admin', 0)->update(['title' => 'NEW TITLE ELequont', 'content' => 'NEW CONTENT ELequont']);
});

Route::get('/delete1', function () {
    $post = Post::find(4);
    $post->delete();
});

Route::get('/delete2', function () {
    Post::destroy([1, 2]);
});
Route::get('/delete3', function () {
    Post::where('id', 8)->where('is_admin', 0)->delete();
});

Route::get('/softdelete', function () {
    Post::find(6)->delete();
});

Route::get('/readsoftdelete', function () {
    // return Post::withTrashed()->where('id',6)->get(); // all (soft deleted or not)
    return Post::onlyTrashed()->where('id', 6)->get(); // only soft deletd items
});

Route::get('/restoresoftdelete', function () {
    Post::onlyTrashed()->where('id', 6)->restore(); // restore soft deleted rows to the normal state
});

Route::get('/forcedelete', function () {
    Post::onlyTrashed()->where('id', 6)->forceDelete(); // Hard delete (permenantely)
});

/**
 * Relationships
 */

// one to one relationship between users and posts
Route::get('/user/{id}/post', function ($id) {
    return User::find(1)->post->title;
});

// inverse realtionship
Route::get('/post/{id}/user', function ($id) {
    return Post::find($id)->user->email;
});

// One to Many Relationship
Route::get('/posts', function () {
    $user = User::find(1);
    foreach ($user->posts as $post) {
        echo $post->title . "<br>";
    }
});


// Many to Many Relationship (Pivot Table)
Route::get('/user/{id}/role', function ($id) {
    return $user = User::find($id)->roles()->orderBy('id', 'desc')->get();
    // foreach ($user->roles as $role) {
    //     echo $role->name;
    // }
});

Route::get('/user/pivot', function () {
    $user = User::find(1);
    foreach ($user->role as $r) {
        return $r;
    }
});

// User/Country
Route::get('/user/country', function () {
    $country = Country::find(2);
    foreach ($country->posts as $post) {
        return $post->title;
    }
});

// Polymorphic Relationship

Route::get('/post/photos', function () {
    $post = Post::find(1);
    foreach ($post->photos as $photo) {
        return $photo->path;
    }
});

Route::get('/post/{id}/photos', function ($id) {
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
});


// Polymorphic Many to Many
Route::get('/post/tag', function ($id) {
    $post = Post::find(1);
    foreach ($post->tags as $tag) {
        echo $tag->name;
    }
});

Route::get('/tag/post', function ($id) {
    $tag = Tag::find(1);
    foreach ($tag->posts as $post) {
        return $post->title;
    }
});


/*
|--------------------------------------------------------------------------
| Tinker Routes
|--------------------------------------------------------------------------
|
*/

Route::get('tinkercreate', function () {
});


/*
|--------------------------------------------------------------------------
| One To One Relationship
|--------------------------------------------------------------------------
*/

// insert
Route::get('/onetoone/insert', function () {
    $user = OneToOneUser::findOrFail(1);
    $address = new OneToOnAddress(['name' => 'Alsab3een, 45th St.']);

    $user->address()->save($address);
});

// update
Route::get('/onetoone/update', function () {
    $address = OneToOnAddress::whereUserId(1)->first();
    $address->name = "Bait Bous, 45th St.";
    $address->save();
});


// read
Route::get('/onetoone/read', function () {
    $user = OneToOneUser::findOrFail(1);
    echo $user->address->name;
});

// delete
Route::get('/onetoone/delete', function () {
    $user = OneToOneUser::findOrFail(1);
    $user->address()->delete();
    return "deleted successfully";
});


/*
|--------------------------------------------------------------------------
| One To Many Relationship
|--------------------------------------------------------------------------
*/

use App\OneToManyPost;
use App\OneToManyUser;

// create / insert data
Route::get('/onetomany/create', function () {
    // get user
    $user = OneToManyUser::findOrFail(2);
    // get post
    $post = OneToManyPost::create(['title' => 'tile number 3', 'body' => 'body number 3']);
    // insert with relationship
    $user->posts()->save($post);
});

// read data
Route::get('/onetomany/read/', function () {
    // get user
    $user = OneToManyUser::find(1);
    // loop over the object then echo data
    foreach ($user->posts as $post) {
        echo "<b>title:</b> " . $post->title . " | <b>content:</b>" . $post->body .  '<br>';
    }
});

// update data

Route::get('/onetomany/update/', function () {
    // get user
    $user = OneToManyUser::find(1);
    // update
    $user->posts()->where("id", 2)->update(['title' => 'updated title', 'body' => 'updated body']);
});

// delet data

Route::get('/onetomany/delete/', function () {
    // get user
    $user = OneToManyUser::find(2);
    // update
    $user->posts()->where("id", 4)->delete();
});


/*
|--------------------------------------------------------------------------
| Many To Many Relationship
|--------------------------------------------------------------------------
*/


use App\ManyToManyUser;
use App\ManyToManyRole;


// create / insert data
Route::get('/manytomany/create', function () {
    $user = ManyToManyUser::find(1);
    $user->roles()->save(new ManyToManyRole(['name' => 'admin']));
});

// read data
Route::get('/manytomany/read/', function () {
    $user = ManyToManyUser::find(1);
    foreach ($user->roles as $role) {
        echo $role . '<br>';
    }
});

// update data
Route::get('/manytomany/update/', function () {
    $user = ManyToManyUser::find(1);
    if ($user->has('roles')) {
        foreach ($user->roles as $role) {
            if ($role == "Administrator") {
                $role->name = "subscriber";
                $role->save();
            }
        }
    }
});

// delet data
Route::get('/manytomany/delete/', function () {
    $user = ManyToManyUser::findOrFail(1);
    $user->roles->delete();
});

// attach
Route::get('/manytomany/atach/', function () {
    $user = ManyToManyUser::findOrFail(1);
    $user->roles()->attach(2);
});

// detach
Route::get('/manytomany/detach/', function () {
    $user = ManyToManyUser::findOrFail(1);
    $user->roles()->detach(2);
});

// sync (and delete all others)
Route::get('/manytomany/sync/', function () {
    $user = ManyToManyUser::findOrFail(1);
    $user->roles()->sync([6,7]);
});
