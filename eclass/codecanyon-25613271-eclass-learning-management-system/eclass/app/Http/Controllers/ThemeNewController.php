<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeNewController extends Controller
{
    public function index()
{
    // Fetch data from the database or any other data source
    $themes = []; // Replace this with the logic to fetch themes from your data source
    
    // Pass the data to the view
    return view('admin.themenew.index', compact('themes'));
}


    public function update(Request $request)
    {
        // Retrieve the selected theme from the request
        $theme = $request->input('theme');

        // Perform the necessary actions to update the theme settings based on the selected theme
        // Example: Update the theme setting in the database or configuration file

        // Return a response or redirect back to a page
        return redirect()->route('themenew.index')->with('success', 'Theme settings updated successfully');
    }
}
