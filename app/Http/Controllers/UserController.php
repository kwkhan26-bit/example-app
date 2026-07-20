<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    // GET /api/users/export
    public function export() 
    {
        // Downloads the User table as an Excel file
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    // POST /api/users/import
    public function import(Request $request) 
    {
        // Validate that the uploaded file is an Excel or CSV document
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        // Process the import
        Excel::import(new UsersImport, $request->file('file'));
        
        return response()->json(['message' => 'Users imported successfully']);
    }
}