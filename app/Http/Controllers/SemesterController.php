<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SemesterStoreUpdateRequest;
use App\Http\Resources\SemesterResource;
use App\Models\Semester;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SemesterController extends Controller
{
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd('hi');
        $searchParams = $request->all();
        $semesterQuery = Semester::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $semesterQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return SemesterResource::collection($semesterQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemesterStoreUpdateRequest $request)
    {
        try {
            $input = $request->only('name', 'year');
            $semester = Semester::create($input);
            return new SemesterResource($semester);
        } catch (Exception $ex) {
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SemesterStoreUpdateRequest $request, $id)
    {
        try {
            $input = $request->only('name', 'year');
            $semester = Semester::find($id);
            $semester->fill($input)->update();
            return new SemesterResource($semester);
        } catch (Exception $ex) {
            return response()->json( new \Illuminate\Support\MessageBag(['catch_exception'=>$ex->getMessage()]), 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $semester = Semester::find($id);
            $semester->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }

    public function getStudents($id)
    {
        $all_students = Student::select('id', 'name')->get();
        $semester_student_ids = Semester::find($id)->students->pluck('id');
        $result = [
            'all_students' => $all_students,
            'semester_student_ids' => $semester_student_ids
        ];
        return response()->json($result);
        // $semester_students = Student::select('id', 'name')->get();
    }

    public function assignStudents(Request $request)
    {
        $semester = Semester::with('students')->find($request->id);
        // dd($request->all(), $semester);
        $students = $semester->students()->sync($request->students);
        $all_students = Student::select('id', 'name')->get();
        $result = [
            'all_students' => $all_students,
            'students' => $students
        ];
        return response()->json($result);
    }
}
