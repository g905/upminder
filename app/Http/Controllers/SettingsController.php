<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'page_title' => 'Настройки',
            'settings' => Setting::paginate(12),
        ]);
    }
    
    public function update(Request $request, $id)
    {
        
        $key = $request->get('settings')['s_key'];
        $value = $request->get('settings')['s_value'];
        
        Setting::setValue($key, $value);
        
        return back()->with('success', 'Настройки сохранены');
    }
    
    public function destroy($id)
    {
        if (!Setting::where('id', $id)
            ->count())
            return redirect()
                ->back()
                ->with('error', 'Что ты хотел?');
        
        if (Setting::find($id)
            ->delete()) {
            return redirect()
                ->back()
                ->with('success', 'Изменения сохранены');
        }
        return redirect()
            ->back()
            ->with('error', 'Какая то ошибка');
    }
}
