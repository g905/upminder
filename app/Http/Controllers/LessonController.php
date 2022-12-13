<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Models\Mentor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    
    public function index(Request $request)
    {
        $mentor_id = $request->get('mentor_id');
        $lessons = Lesson::when($mentor_id, function ($query) use ($mentor_id) {
            return $query->where('mentor_id', $mentor_id);
        })
            ->paginate(12)->appends(['mentor_id' => $mentor_id]);;
        return view('admin.lessons.index', [
            'page_title' => 'Все занятия',
            'mentors' => Mentor::all(),
            'lessons' => $lessons,
        ]);
    }
    
    
    public function create()
    {
        return view('admin.lessons.add', [
            'page_title' => 'Добавить занятие',
            'mentors' => Mentor::all(),
        ]);
    }
    
    
    public function store(LessonRequest $request)
    {
        $date_start = $this->parseDateAndTime($request->date_start, $request->time_start);
        $date_end = $this->parseDateAndTime($request->date_end, $request->time_end);
        $lesson = new Lesson();
        $lesson->fill($request->all());
        $lesson->date_start = $date_start;
        $lesson->date_end = $date_end;
        if ($lesson->save()) {
            if ($request->has('return')) {
                return redirect()
                    ->route('admin.lessons.index')
                    ->with('success', 'Занятие успешно создано!');
            }
            return redirect()
                ->back()
                ->with('success', 'Занятие успешно создано!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка')
            ->withInput();
    }
    
    
    public function edit(Lesson $lesson)
    {
        
        return view('admin.lessons.edit', [
            'lesson' => $lesson,
            'page_title' => 'Добавить занятие',
            'mentors' => Mentor::all(),
        ]);
    }
    
    
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $date_start = $this->parseDateAndTime($request->date_start, $request->time_start);
        $date_end = $this->parseDateAndTime($request->date_end, $request->time_end);
        $lesson->fill($request->all());
        $lesson->date_start = $date_start;
        $lesson->date_end = $date_end;
        if ($lesson->save()) {
            if ($request->has('return')) {
                return redirect()
                    ->route('admin.lessons.index')
                    ->with('success', 'Занятие успешно обновлено!');
            }
            return redirect()
                ->back()
                ->with('success', 'Занятие успешно обновлено!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка')
            ->withInput();
    }
    
    public function destroy(Lesson $lesson)
    {
        if ($lesson->count()) {
            $lesson->delete();
            return redirect()
                ->route('admin.lessons.index')
                ->with('success', 'Занятие успешно удалено!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка');
    }
    
    
}
