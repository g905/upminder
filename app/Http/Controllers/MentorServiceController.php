<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\MentorCategory;
use App\Models\MentorService;
use App\Http\Requests\StoreMentorServiceRequest;
use App\Http\Requests\UpdateMentorServiceRequest;

class MentorServiceController extends Controller
{
   
    public function index()
    {
        
        return view('admin.mentor_services.index',[
            'page_title' => 'Список услуг',
            'services' => MentorService::orderByDesc('created_at')->paginate(15),
        ]);
    }

   
    public function create()
    {
        
        return view('admin.mentor_services.add', [
            'page_title' => 'Добавить услугу',
            'service_types' => MentorService::getTypes(),
        ]);
    }

    
    public function store(StoreMentorServiceRequest $request)
    {
        if (MentorService::create($request->validated())) {
        
            if ($request->get('return')) {
                return redirect()
                    ->route('admin.mentor_services.index')
                    ->with('success', 'Услуга успешно добавлена!');
            }
            return redirect()
                ->back()
                ->with('success', 'Услуга успешно добавлена!');
        }
    }


    public function edit(MentorService $mentorService)
    {
        return view('admin.mentor_services.edit',[
            'page_title' => 'Добавить услугу',
            'service_types' => MentorService::getTypes(),
            'mentor_service' => $mentorService
        ]);
    }

   
    public function update(StoreMentorServiceRequest $request, MentorService $mentorService)
    {
        $mentorService->fill($request->validated());
        if ($mentorService->save()) {
        
            if ($request->get('return')) {
                return redirect()
                    ->route('admin.mentor_services.index')
                    ->with('success', 'Услуга успешно изменена!');
            }
            return redirect()
                ->back()
                ->with('success', 'Услуга успешно изменена!');
        }
    }

    public function destroy(MentorService $mentorService)
    {
        if ($mentorService->count()) {
            $mentorService->delete();
            return redirect()
                ->route('admin.mentor_services.index')
                ->with('success', 'Услуга успешно удалена!');
        }
        return redirect()
            ->back()
            ->withErrors('Возникла ошибка');
    }
}
