<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $guarded = ['id_number'];

    public function index(Request $request)
    {
        $students = Student::latest();
        if ($request->has('keyword')) {
            $students = $students->where('id_number', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('name', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('department', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('section', 'LIKE', '%'.$request->keyword.'%')
                        ->orWhere('email', 'LIKE', '%'.$request->keyword.'%');
        }

        $students = $students->paginate(10);

        return view('users.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.students.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|unique:students',
            'name' => 'required|string',
            'department' => 'required|string',
            'year_level' => 'required|numeric',
            'section' => 'required',
            'contact_number' => 'required|numeric|min:10',
            'email' => 'required|email',

        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $student = new Student;
        $student->id_number = $request->id_number;
        $student->name = $request->name;
        $student->department = Str::upper($request->department);
        $student->year_level = $request->year_level;
        $student->section = $request->section;
        $student->contact_number = $request->contact_number;
        $student->email = $request->email;
        $student->save();

        $student = User::create([
            'username' => $student->id_number,
            'password' => bcrypt('1234'),
            'user_id' => $student->id,
            'account_type' => 2,
        ]);

        return redirect(route('students.index'))->with('success', 'New Student has been added to the database.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($student)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        return view('users.students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_number' => 'required|exists:students,id_number',
            'name' => 'required|string',
            'department' => 'required|string',
            'year_level' => 'required|numeric',
            'section' => 'required',
            'contact_number' => 'required|numeric|min:10',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $student = Student::find($id);
        if (! $student) {
            abort(404);
        }

        $student->update([
            'name' => $request->name,
            'department' => Str::upper($request->department),
            'year_level' => $request->year_level,
            'section' => $request->section,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
        ]);

        return redirect(route('students.index'))->with('success', 'Student has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        if (! $student) {
            abort(404);
        }

        $user = User::where('user_id', $id)->where('account_type', 2)->first();
        $student->delete();
        $user->delete();

        return redirect(route('students.index'))->with('success', 'Student has been successfully deleted.');
    }

    /**
     * Display qrcode the student
     */
    public function qrcode(Student $student)
    {
        $qrcode = Crypt::encryptString($student->id.'-2');

        return view('users.qr', [
            'qrcode' => $qrcode,
            'user' => $student,
        ]);
    }

    public function attendance(Student $student)
    {
        $attendances = Event::leftJoin('event_participants', 'event_participants.event_id', '=', 'events.id')
            ->where('user_id', $student->id)
            ->where('user_type', 2)
            ->select([
                'events.id',
                'events.title',
                'events.date',
                'events.time_start',
                'events.time_end',
                'event_participants.time_in',
                'event_participants.time_out',
                'is_present',
            ])
            ->withoutTrashed('events.deleted_at')
            ->get();

        return view('users.students.attendance', compact('attendances'));
    }

    public function attendanceReport(Request $request)
    {
        $student = Student::where('id_number', $request->student_id)
            ->first();

        $attendances = EventParticipant::where('user_id', $student?->id)
            ->where('user_type', 2)
            ->leftJoin('events', 'events.id', '=', 'event_participants.event_id')
            ->withoutTrashed('events.deleted_at')
            ->get();

        return view('reports.student', compact('student', 'attendances'));
    }
}
