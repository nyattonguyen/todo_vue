<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 


class StudentController extends Controller
{
    public function index() 
    {
        $student = Student::all();
        if($student->count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $student
            ], 200);

        }else {
            return response()->json([
                'status' => 404,
                'message' => "No Records Found"
            ],404);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',

        ]);
        
        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        }
        
        else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
                
            ]);
            print($student);
            if($student) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student created succesfully'
                ],200);
            }else {
                return response()->json([
                    'status' => 500,
                    'message' => "something went wrong"
                ], 500);
            }

        }


    }

    public function show($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'message' => $student
            ],200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => "No such student found!"
            ],404);
        }
    }

    public function edit($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'message' => $student
            ],200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => "No such student found!"
            ],404);
        }
    }

    public function update(Request $request, int $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',

        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ],422);
        }

        else {
            $student = Student::find($id);
            
            if($student) {
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
    
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Student update succesfully'
                ,200]);
            }else {
                return response()->json([
                    'status' => 404,
                    'message' => "No such student found"
                ], 404);
            }

        }
    }

    public function destroy($id) {
        $student = Student::find($id);
        
        if($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Delete student successfull"
            ]);
        }else {
            return response()->json([
                'status' => 404,
                'message' => "No such student found"
            ]);
        }
    }
}
