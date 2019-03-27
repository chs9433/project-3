<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BookController extends Controller {

    /**
    * GET /books
    */
    public function index()
    {
        # Work that was previously happening in the routes file is now happening here
        return 'Here are all the books...';
    }
    public function edit($title=null)
    {
        dump($title);
        return view('books.edit');
    }

    /**
    * GET /books/{title}
    */

    public function show($title)
{
    return view('books.show')->with(['title' => $title]);
}


}
