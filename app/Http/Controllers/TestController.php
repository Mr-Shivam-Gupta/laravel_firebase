<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Services\FirebaseService;

class TestController extends Controller
{
    private $database;

    public function __construct()
    {
        $this->database = FirebaseService::connect();
    }
    public function index()
    {
        return response()->json($this->database->getReference()->getValue());
    }

    public function create(Request $request)
    {
        // Get a reference to the 'blogs' table
        $blogsRef = $this->database->getReference('test/blogs');
    
        // Push a new entry with auto-incrementing ID
        $newBlogRef = $blogsRef->push([
            'title' => $request['title'],
            'content' => $request['content']
        ]);
    
        // Get the auto-generated key (ID) of the new entry
        $newBlogKey = $newBlogRef->getKey();
    
        // Return the ID of the created blog
        return response()->json('Blog with ID: ' . $newBlogKey . ' has been created.');
    }
    
      public function edit(Request $request)
    {
        // Get the ID of the blog to edit
        $blogId = $request['id'];

        // Get a reference to the specific blog entry
        $blogRef = $this->database->getReference('test/blogs/' . $blogId);

        // Update the content of the blog entry
        $blogRef->update([
            'content' => $request['content']
        ]);

        return response()->json('Blog with ID: ' . $blogId . ' has been edited');
    }

     public function delete(Request $request)
    {
        // Get the ID of the blog to delete
        $blogId = $request['id'];

        // Get a reference to the specific blog entry
        $blogRef = $this->database->getReference('test/blogs/' . $blogId);

        // Remove the blog entry
        $blogRef->remove();

        return response()->json('Blog with ID: ' . $blogId . ' has been deleted');
    }


}
