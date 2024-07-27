<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;

class StudentController extends Controller
{
    //
    public function index()
    {
        $students = StudentResource::collection(Student::paginate(10));

        return inertia('Students/Index', [
            'students' => $students,
        ]);
    }

    public function create()
    {
        $classes = ClassesResource::collection(Classes::all());

        return inertia('Students/Create', [
            'classes' => $classes,
        ]);
    }
}
