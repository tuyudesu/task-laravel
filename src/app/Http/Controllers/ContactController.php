<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(Request $request): View
    {
        $categories = Category::orderBy('id')->get();
        $old = $request->session()->get('contact_input', []);

        return view('contact.create', compact('categories', 'old'));
    }

    public function confirm(ContactRequest $request): View
    {
        
        $data = $request->validated();

        
        $request->session()->put('contact_input', $data);

        // ③表示用ラベル
        $genderMap = [1 => '男性', 2 => '女性', 3 => 'その他'];
        $genderLabel = $genderMap[$data['gender']] ?? '-';
        $categoryLabel = Category::find($data['category_id'])?->content ?? '-';

    
        return view('contact.confirm', compact('data', 'genderLabel', 'categoryLabel'));
    }

    public function back(Request $request): RedirectResponse
    {
        
        $old = $request->session()->get('contact_input', []);

        return redirect()
            ->route('contact.create')
            ->withInput($old);
    }

    public function store(Request $request): RedirectResponse
    {

        $data = $request->session()->get('contact_input');

        if (empty($data)) {
            return redirect()
                ->route('contact.create')
                ->with('error', '入力情報が見つかりません。最初からやり直してください。');
        }

        Contact::create($data);
        $request->session()->forget('contact_input');

        return redirect()->route('contact.thanks');
    }

    public function thanks(): View
    {
        return view('contact.thanks');
    }
}
