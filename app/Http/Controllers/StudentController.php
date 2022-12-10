<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorestudentRequest;
use App\Http\Requests\UpdatestudentRequest;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Student::class);

        $query = Student::selectedFields()
                    ->joinStudentLoginCredential()
                    ->withRelations()
                    ->sortable()
                    ->searchable()

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorestudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorestudentRequest $request, StudetnProcess $process)
    {
        $this->authorize('create', Student::class);

        $process->create();

        activity()
            ->performedOn($process->student())
            ->withProperties($process->student())
            ->log('Student has been created');

        return $process->student();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $this->authorize('view', $student);

        return Student::withRelations()
                ->where('student_id', $student->student_id)
                ->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatestudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatestudentRequest $request, Student $student)
    {
        $this->authorize('update', $student);

        $process->find($student->student_id)
                ->update();

        activity()
            ->performedOn($process->student())
            ->withProperties($process->student())
            ->log('Student has been updated');

        return $process->student();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $this->authorize('delete', $student);

        $student->delete();

        activity()
            ->performedOn($student)
            ->withProperties($student)
            ->log('Student has been deleted');

        return $student;
    }
}
