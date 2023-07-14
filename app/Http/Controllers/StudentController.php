<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    use ImageTrait;
    const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $studentQuery = Student::with('department', 'image');
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($keyword)) {
            $studentQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return StudentResource::collection($studentQuery->orderBy('id', 'asc')->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreUpdateRequest $request)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'email', 'number', 'department_id', 'guardian_number');
            DB::beginTransaction();
            $student = Student::create($input);
            if($request->hasFile('image')){
                $filename = $request->image->getClientOriginalName();
                $image_upload_path = public_path('\uploads\students');
                $request->image->move($image_upload_path, $filename);
                $this->createImage($filename,$student);
//                dd($request->all(), $request->file(), $request->image, $filename, public_path(), $extension, $image_upload_path);
            }
            DB::commit();
            return new StudentResource($student);
        } catch (Exception $ex) {
            DB::rollBack();
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
        $student = Student::find($id);
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentStoreUpdateRequest $request, $id)
    {
        // dd($request->all());
        try {
            $input = $request->only('name', 'email', 'number', 'department_id', 'guardian_number');
            $student = Student::find($id);
            DB::beginTransaction();
            $student->fill($input)->update();
            dd($input, $request->all(), $request->hasFile('image'), $student->image);
            //Only deleting image when new image is selected.
            // When no new image is selected, image remains the same, that means no delete option for image only.
            if($request->hasFile('image')){
                $prev_image =  $student->image;
                if($prev_image){
                    $path = public_path('\uploads\students\\').$prev_image->filename;
                    if(file_exists($path)) {
                        unlink($path);
                        $prev_image->delete();
                    }
                }
                $filename = $request->image->getClientOriginalName();
                $image_upload_path = public_path('\uploads\students');
                $request->image->move($image_upload_path, $filename);
                $this->createImage($filename,$student);
            }
            DB::commit();
            return new StudentResource($student);
        } catch (Exception $ex) {
            DB::rollBack();
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
            $student = Student::find($id);
            $image =  $student->image;
            if($image){
                $path = public_path('\uploads\students\\').$image->filename;
                if(file_exists($path)) {
                    unlink($path);
                    $image->delete();
                }
            }
            $student->delete();
            return response()->json(null, 204);
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }
    }
}
