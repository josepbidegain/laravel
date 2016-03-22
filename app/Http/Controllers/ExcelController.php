<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function export()
	{
        switch ($_GET['formato']) {
            case 'excel':
                $formato='xls';
                break;
            case 'pdf':
                $formato='pdf';
                break;
            case 'csv':
                $formato='csv';
                break;           
            default:
                # code...
                break;
        }
        Excel::create('Laravel Excel', function($excel) {

        	$excel->setTitle('Titulo del documento');
        	/*
			// Chain the setters
			    $excel->setCreator('Maatwebsite')
			          ->setCompany('Maatwebsite');

			    // Call them separately
			    $excel->setDescription('A demonstration to change the file properties');
        	*/
 
            $excel->sheet('Usuarios', function($sheet) {
 
                $users = User::all();
 
                $sheet->fromArray($users);
 
            });
        })->export("$formato");
        /*->export('xlsx');
 		  ->download('xls');
 		  ->export('csv');
		  ->download('csv');
		  ->export('pdf');
		  ->store('xls');
		  ->store('xls')->export('xls');
		*/
	}

	public function import()
    {
    	Excel::load('books.csv', function($reader) {
 
     		foreach ($reader->get() as $book) {
     			Book::create([
     				'name' => $book->title,
     				'author' =>$book->author,
     				'year' =>$book->publication_year
     			]);
      		}
		});
		return Book::all();
    }
}
