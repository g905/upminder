<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\LessonRequest;
use App\Models\Application;
use App\Models\ApplicationType;
use App\Models\CategoryTag;
use App\Models\Language;
use App\Models\Mentor;
use App\Models\MentorCategory;
use App\Models\MentorTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $mentor_id = $request->get('mentor_id');
        $applications = Application::when($mentor_id, function ($query) use ($mentor_id) {
            return $query->where('mentor_id', $mentor_id);
        })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->appends(['mentor_id' => $mentor_id]);
        
        return view('admin.applications.index', [
            'page_title' => 'Все Заявка',
            'mentors' => Mentor::all(),
            'applications' => $applications,
        ]);
    }
    
    
    public function create()
    {
        return view('admin.applications.add', [
            'page_title' => 'Добавить заявку',
            'applications_types' => ApplicationType::all(),
            'mentors' => Mentor::all(),
            'languages' => Language::all(),
            'category_tags' => CategoryTag::all(),
            'mentor_categories' => MentorCategory::where('parent_id', '!=', null)
                ->get(),
            'mentor_parent_categories' => MentorCategory::where('parent_id', null)
                ->get(),
        ]);
    }
    
    
    public function store(ApplicationRequest $request)
    {
        $application_type = ApplicationType::find($request->get('app_type'));
        if (!$application_type) {
            return redirect()
                ->back()
                ->with('error', 'Вы делаете что то не так!');
        }
        
        $application = new Application();
        $application->fill($request->all());
        $application->application_type_id = $application_type->id;
        if ($request->file('resume')) {
            $fileName = 'resume_' . uniqid(time()) . '.' . $request->resume->extension();
            $uploadedFile = $request->file('resume');
            $file_name = Storage::putFileAs('resume', $uploadedFile, $fileName);
            if ($file_name)
                $application->resume = $fileName;
        }
        
        
        if ($application->save()) {
            if ($request->get('mentor_tag_id')) {
                $application->mentor_tags()
                    ->sync($request->get('mentor_tag_id'));
            }
            
            if ($request->get('return')) {
                return redirect()
                    ->route('admin.applications.index')
                    ->with('success', 'Заявка успешно добавлена!');
            }
            return redirect()
                ->back()
                ->with('success', 'Заявка успешно добавлена!');
        }
        return redirect()
            ->back()
            ->with('error', 'Возникла ошибка!');
    }
    
    
    public function edit(Application $application)
    {
        $application->touch();
        return view('admin.applications.edit', [
            'page_title' => 'Редактировать заявку',
            'application' => $application,
            'applications_types' => ApplicationType::where('id', $application->application_type_id)
                ->get(),
            'mentors' => Mentor::all(),
            'languages' => Language::all(),
            'category_tags' => CategoryTag::all(),
            'mentor_categories' => MentorCategory::where('parent_id', '!=', null)
                ->get(),
            'mentor_parent_categories' => MentorCategory::where('parent_id', null)
                ->get(),
        ]);
    }
    
    
    public function update(ApplicationRequest $request, Application $application)
    {
        $application_type = ApplicationType::find($request->get('app_type'));
        if (!$application_type) {
            return redirect()
                ->back()
                ->with('error', 'Вы делаете что то не так!');
        }
        $old_file = $application->resume;
        
        $application->fill($request->all());
        $application->application_type_id = $application_type->id;
        if ($request->file('resume')) {
            
            $fileName = 'resume_' . uniqid(time()) . '.' . $request->resume->extension();
            $uploadedFile = $request->file('resume');
            $file_name = Storage::putFileAs('resume', $uploadedFile, $fileName);
            if ($file_name) {
                $application->resume = $fileName;
                Storage::delete('resume/' . $old_file);
            }
        }
        
        if ($application->save()) {
            if ($request->get('mentor_tag_id')) {
                $application->mentor_tags()
                    ->sync($request->get('mentor_tag_id'));
            }
            
            if ($request->get('return')) {
                return redirect()
                    ->route('admin.applications.index')
                    ->with('success', 'Заявка успешно изменена!');
            }
            return redirect()
                ->back()
                ->with('success', 'Заявка успешно изменена!');
        }
        return redirect()
            ->back()
            ->with('error', 'Возникла ошибка!');
    }
    
    public function downloadResume($path)
    {
        /* Скачать файл */
        return Response::download(Storage::path('resume/' . $path));
        /* Скачать файл */
    }
    
    public function destroy(Application $application)
    {
        if ($application->count()) {
            $application->delete();
            return redirect()
                ->route('admin.applications.index')
                ->with('success', 'Заявка успешно удалено!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка');
    }
}
