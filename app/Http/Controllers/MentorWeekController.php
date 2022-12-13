<?php

namespace App\Http\Controllers;

use App\Http\Requests\MentorWeekRequest;
use App\Models\Mentor;
use App\Models\MentorCategory;
use App\Models\MentorWeek;
use Illuminate\Http\Request;

class MentorWeekController extends Controller
{
    
    public function index()
    {
        
        return view('admin.mentor_week.index', [
            'mentors' => Mentor::all(),
            'page_title' => 'Менторы недели',
            'mentor_week' => MentorWeek::orderByDesc('created_at')
                ->paginate(12),
        ]);
    }
    
    
    public function create()
    {
        return view('admin.mentor_week.add', [
            'mentors' => Mentor::all(),
            'categories' => MentorCategory::getMainCategories()
                ->get(),
            'page_title' => 'Добавить ментора недели',
        ]);
    }
    
    
    public function store(MentorWeekRequest $request)
    {
        $date_start = $this->parseDateAndTime($request->date_start, $request->time_start);
        $date_end = $this->parseDateAndTime($request->date_end, $request->time_end);
        
        if (MentorWeek::where('mentor_id', $request->get('mentor_id'))
            ->where('category_id', $request->get('category_id'))
            ->where('is_active', true)
            ->where(function ($query) use ($date_start, $date_end) {
                return $query->where(function ($query) use ($date_start, $date_end) {
                    return $query->where('date_start', '>', $date_start)
                        ->where('date_start', '<', $date_end);
                })
                    ->orWhere(function ($query) use ($date_start, $date_end) {
                        return $query->where('date_start', '<', $date_start)
                            ->where('date_end', '>', $date_end);
                    });
            })
            ->count()) {
            return redirect()
                ->back()
                ->with('error', 'Время для ментора в этой категории пересекается с уже добавленным')
                ->withInput();
        }
        $mentor_week = new MentorWeek();
        $mentor_week->fill($request->all());
        $mentor_week->date_start = $date_start;
        $mentor_week->date_end = $date_end;
        if ($mentor_week->save()) {
            return redirect()
                ->route('admin.mentor_week.index')
                ->with('success', 'Ментор недели успешно создан');
        }
    }
    
    public function show(MentorWeek $mentorWeek)
    {
    
    }
    
    
    public function edit(MentorWeek $mentorWeek)
    {
        return view('admin.mentor_week.edit', [
            'mentorWeek' => $mentorWeek,
            'mentors' => Mentor::all(),
            'categories' => MentorCategory::getMainCategories()
                ->get(),
            'page_title' => 'редактировать ментора недели',
        ]);
    }
    
    public function update(MentorWeekRequest $request, MentorWeek $mentorWeek)
    {
        $date_start = $this->parseDateAndTime($request->date_start, $request->time_start);
        $date_end = $this->parseDateAndTime($request->date_end, $request->time_end);
        
        if (MentorWeek::where('mentor_id', $request->get('mentor_id'))
            ->where('id', '!=', $mentorWeek->id)
            ->where('category_id', $request->get('category_id'))
            ->where('is_active', true)
            ->where(function ($query) use ($date_start, $date_end) {
                return $query->where(function ($query) use ($date_start, $date_end) {
                    return $query->where('date_start', '>', $date_start)
                        ->where('date_start', '<', $date_end);
                })
                    ->orWhere(function ($query) use ($date_start, $date_end) {
                        return $query->where('date_start', '<', $date_start)
                            ->where('date_end', '>', $date_end);
                    });
            })
            ->count()) {
            return redirect()
                ->back()
                ->with('error', 'Время для ментора в этой категории пересекается с другим')
                ->withInput();
        }
        $mentorWeek->fill($request->all());
        $mentorWeek->date_start = $date_start;
        $mentorWeek->date_end = $date_end;
        if ($mentorWeek->save()) {
            if ($request->get('return')) {
                return redirect()
                    ->route('admin.mentor_week.index')
                    ->with('success', 'Заявка успешно изменена!');
            }
            return redirect()
                ->back()
                ->with('success', 'Ментор недели успешно изменён');
        }
    }
    
    public function destroy(MentorWeek $mentorWeek)
    {
        if ($mentorWeek->count()) {
            $mentorWeek->delete();
            return redirect()
                ->route('admin.mentor_week.index')
                ->with('success', 'Ментор недели успешно удален!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка');
    }
}
