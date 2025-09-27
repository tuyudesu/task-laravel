<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // 検索パラメータ取得
        $name        = $request->input('name');
        $nameExact   = (bool)$request->input('name_exact');   // 完全一致フラグ
        $email       = $request->input('email');
        $emailExact  = (bool)$request->input('email_exact');  // 完全一致フラグ
        $gender      = $request->input('gender');             // 'all' | 1 | 2 | 3
        $categoryId  = $request->input('category_id');        // 'all' | id
        $dateFrom    = $request->input('date_from');          // Y-m-d
        $dateTo      = $request->input('date_to');            // Y-m-d

        $query = Contact::query()->with('category');

        // 名前（姓・名・フルネーム検索）
        if (filled($name)) {
            $query->where(function ($q) use ($name, $nameExact) {
                if ($nameExact) {
                    $q->where('last_name', $name)
                      ->orWhere('first_name', $name)
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$name]);
                } else {
                    $like = '%' . $name . '%';
                    $q->where('last_name', 'like', $like)
                      ->orWhere('first_name', 'like', $like)
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$like]);
                }
            });
        }

        // メール
        if (filled($email)) {
            if ($emailExact) {
                $query->where('email', $email);
            } else {
                $query->where('email', 'like', '%' . $email . '%');
            }
        }

        // 性別（全て or 1/2/3）
        if (filled($gender) && $gender !== 'all') {
            $query->where('gender', (int)$gender);
        }

        // お問い合わせ種類（全て or id）
        if (filled($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', (int)$categoryId);
        }

        // 日付（created_at）
        if (filled($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if (filled($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // ページネーション（7件）
        $contacts   = $query->latest()->paginate(7)->withQueryString();
        $categories = Category::orderBy('id')->get();

        return view('admin.index', compact('contacts', 'categories'))
            ->with([
                'filters' => [
                    'name'        => $name,
                    'name_exact'  => $nameExact,
                    'email'       => $email,
                    'email_exact' => $emailExact,
                    'gender'      => $gender ?? 'all',
                    'category_id' => $categoryId ?? 'all',
                    'date_from'   => $dateFrom,
                    'date_to'     => $dateTo,
                ],
            ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('status', '削除しました');
    }

    // CSVエクスポート（検索条件を反映）
    public function export(Request $request)
    {
        // index と同じ条件を適用
        $name        = $request->input('name');
        $nameExact   = (bool)$request->input('name_exact');
        $email       = $request->input('email');
        $emailExact  = (bool)$request->input('email_exact');
        $gender      = $request->input('gender');
        $categoryId  = $request->input('category_id');
        $dateFrom    = $request->input('date_from');
        $dateTo      = $request->input('date_to');

        $query = Contact::query()->with('category');

        if (filled($name)) {
            $query->where(function ($q) use ($name, $nameExact) {
                if ($nameExact) {
                    $q->where('last_name', $name)
                      ->orWhere('first_name', $name)
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) = ?", [$name]);
                } else {
                    $like = '%' . $name . '%';
                    $q->where('last_name', 'like', $like)
                      ->orWhere('first_name', 'like', $like)
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$like]);
                }
            });
        }
        if (filled($email)) {
            $emailExact ? $query->where('email', $email)
                        : $query->where('email', 'like', '%' . $email . '%');
        }
        if (filled($gender) && $gender !== 'all') {
            $query->where('gender', (int)$gender);
        }
        if (filled($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', (int)$categoryId);
        }
        if (filled($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if (filled($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($query) {
            $handle = fopen('php://output', 'w');
            // 文字化け対策（Excel想定ならBOMを付与）
            fwrite($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // ヘッダ
            fputcsv($handle, [
                'ID', '姓', '名', '性別', 'メール', '電話', '住所', '建物', 'お問い合わせ種類', '内容', '作成日',
            ]);

            // データ
            $mapGender = [1 => '男性', 2 => '女性', 3 => 'その他'];
            $query->orderBy('id')->chunk(200, function ($rows) use ($handle, $mapGender) {
                foreach ($rows as $r) {
                    fputcsv($handle, [
                        $r->id,
                        $r->last_name,
                        $r->first_name,
                        $mapGender[$r->gender] ?? '',
                        $r->email,
                        $r->tel,
                        $r->address,
                        $r->building,
                        optional($r->category)->content,
                        $r->detail,
                        optional($r->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}
