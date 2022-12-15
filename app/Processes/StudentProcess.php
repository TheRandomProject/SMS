<?php

namespace App\Processes;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentProcess
{
    protected $request, $student;

    /**
     * Create a new process instance.
     *
     * @return void
     */
	public function __construct($request = null)
	{
		$this->request = $request ? (object) $request : request();
	}

	/**
     * Execute find process.
     *
     * @return void
    */
    public function find($id)
    {
    	$this->student = Student::findOrFail($id);

    	return $this;
    }

    /**
     * Retrive Student.
     *
     * @return
    */
    public function student()
    {
    	return $this->student;
    }

	/**
     * Execute create process.
     *
     * @return void
    */
    public function create()
    {
    	DB::transaction(function(){
    		$this->createStudent();
    	});
    }

    /**
     * Execute update process.
     *
     * @return void
    */
    public function update()
    {
    	DB::transaction(function(){
            $this->updateStudent();
        });
    }

    /**
     * Create Student.
     *
     * @return void
    */
    private function createStudent()
    {
    	$this->student = Student::create([
    		'firstname'     => Str::ucfirst($this->request->firstname),
            'lastname'      => Str::ucfirst($this->request->lastname),
            'middlename'    => Str::ucfirst($this->request->middlename),
            'suffixname'    => Str::ucfirst($this->request->suffixname),
            'gender'        => Str::ucfirst($this->request->gender),
            'birthday'      => Str::ucfirst($this->request->birthday)
    	]);

    	return $this;
    }

    /**
     * Update Student.
     *
     * @return void
    */
    private function updateStudent()
    {
    	$this->student->update([
    		'firstname'     => Str::ucfirst($this->request->firstname),
            'lastname'      => Str::ucfirst($this->request->lastname),
            'middlename'    => Str::ucfirst($this->request->middlename),
            'suffixname'    => Str::ucfirst($this->request->suffixname),
            'gender'        => Str::ucfirst($this->request->gender),
            'birthday'      => Str::ucfirst($this->request->birthday)
    	]);

    	return $this;
    }
}
