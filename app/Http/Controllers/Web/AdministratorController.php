<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdministratorRequest;
use App\Http\Requests\LoginAdminRequest;
use App\Administrator;
use App\Column;
use App\Contract;
use App\Evaluation;
use App\Example;
use App\Painter;
use App\Request as RequestModel;
use App\User;
use App\Mail\Approve;
use Mail;

class AdministratorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['login', 'inquiry']);
    }

    /**
     * Get the guard.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Administrator::withTrashed()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(config('const.template.admin.entry'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AdministratorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        $admin = new Administrator();

        $admin->username = $request->username;
        $admin->password = $request->password;

        $admin->save();

        return redirect()->route('admin.list');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Administrator::destroy($id);

        if ($id == $this->guard()->id()) {
            // ログイン中の管理者を削除した場合はログアウト
            $this->guard()->logout();

            return redirect()->route('top');
        }

        return Administrator::withTrashed()->get();
    }

    /**
     * 管理者データ復活
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function administrator_restore($id)
    {
        Administrator::withTrashed()->find($id)->restore();

        return Administrator::withTrashed()->get();
    }

    /**
     * ログインページ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            // バリデーション
            $request->validate([
                'username' => 'required|string|max:256|alpha_dash',
                'password' => 'required|string|min:8|max:256|alpha_dash',
            ]);

            // 認証処理
            $credentials = $request->only('username', 'password');

            if ($this->guard()->attempt($credentials)) {
                return redirect()->to(config('const.prefix.admin') . '/administrator_list');
            } else {
                return back()->with('status', '認証に失敗しました。');
            }
        }

        return view(config('const.template.admin.login'));
    }

    /**
     * ログアウトページ
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $this->guard()->logout();

        return redirect()->route('admin.login');
    }

    /**
     * 業者会員データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function painters()
    {
        $args = request()->query('args');
        $order = request()->query('order') == 0 ? 'asc' : 'desc';

        if ($args) {
            $keyword1 = '%' . mb_convert_kana($args, 'aCKV') . '%';
            $keyword2 = '%' . $args . '%';

            return Painter::withTrashed()
                            ->where(function($q) use ($keyword1, $keyword2) {
                                $q->where('email', 'like', $keyword1)
                                  ->orWhere('email', 'like', $keyword2)
                                  ->orWhere('name', 'like', $keyword1)
                                  ->orWhere('name', 'like', $keyword2)
                                  ->orWhere('kana', 'like', $keyword1)
                                  ->orWhere('kana', 'like', $keyword2)
                                  ->orWhere('ceo_name', 'like', $keyword1)
                                  ->orWhere('ceo_name', 'like', $keyword2)
                                  ->orWhere('charge_name1', 'like', $keyword1)
                                  ->orWhere('charge_name1', 'like', $keyword2)
                                  ->orWhere('charge_name2', 'like', $keyword1)
                                  ->orWhere('charge_name2', 'like', $keyword2)
                                  ->orWhere('charge_kana1', 'like', $keyword1)
                                  ->orWhere('charge_kana1', 'like', $keyword2)
                                  ->orWhere('charge_kana2', 'like', $keyword1)
                                  ->orWhere('charge_kana2', 'like', $keyword2);
                            })->orderBy('id', $order)->paginate(10);
        } else {
            return Painter::withTrashed()->orderBy('id', $order)->paginate(10);
        }
    }

    /**
     * 管理者用業者会員詳細ページ
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function painter_detail($id)
    {
        return view(config('const.template.painter.detail'), ['painter' => Painter::withTrashed()->find($id)]);
    }

    /**
     * 業者会員データ承認
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function painter_approve($id)
    {
        $painter = Painter::withTrashed()->find($id);

        $painter->rank = 1;

        $painter->save();

        Mail::to($painter->email)->send(new Approve());

        return Painter::withTrashed()->get();
    }

    /**
     * 業者会員データ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function painter_del($id)
    {
        Painter::destroy($id);

        return Painter::withTrashed()->get();
    }

    /**
     * 業者会員データ復活
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function painter_restore($id)
    {
        Painter::withTrashed()->find($id)->restore();

        return Painter::withTrashed()->get();
    }

    /**
     * 個人会員データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $args = request()->query('args');
        $order = request()->query('order') == 0 ? 'asc' : 'desc';

        if ($args) {
            $keyword1 = '%' . mb_convert_kana($args, 'aCKV') . '%';
            $keyword2 = '%' . $args . '%';

            return User::withTrashed()
                         ->where(function($q) use ($keyword1, $keyword2) {
                             $q->where('email', 'like', $keyword1)
                               ->orWhere('email', 'like', $keyword2)
                               ->orWhere('name1', 'like', $keyword1)
                               ->orWhere('name1', 'like', $keyword2)
                               ->orWhere('name2', 'like', $keyword1)
                               ->orWhere('name2', 'like', $keyword2)
                               ->orWhere('kana1', 'like', $keyword1)
                               ->orWhere('kana1', 'like', $keyword2)
                               ->orWhere('kana2', 'like', $keyword1)
                               ->orWhere('kana2', 'like', $keyword2)
                               ->orWhere('nickname', 'like', $keyword1)
                               ->orWhere('nickname', 'like', $keyword2);
                         })->orderBy('id', $order)->paginate(10);
        } else {
            return User::withTrashed()->orderBy('id', $order)->paginate(10);
        }
    }

    /**
     * 管理者用個人会員詳細ページ
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_detail($id)
    {
        return view(config('const.template.user.detail'), ['user' => User::withTrashed()->find($id)]);
    }

    /**
     * 個人会員データ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_del($id)
    {
        User::destroy($id);

        return User::withTrashed()->get();
    }

    /**
     * 個人会員データ復活
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function user_restore($id)
    {
        User::withTrashed()->find($id)->restore();

        return User::withTrashed()->get();
    }

    /**
     * コラムデータ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function columns()
    {
        $args = request()->query('args');

        return $this->get_columns($args);
    }

    /**
     * 管理者用コラム詳細ページ
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function column_detail($id)
    {
        return view(config('const.template.column.detail'), ['column' => Column::withTrashed()->find($id)]);
    }

    /**
     * コラムデータ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function column_del($id)
    {
        Column::destroy($id);

        return $this->get_columns();
    }

    /**
     * 施工事例データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function examples()
    {
        $args = request()->query('args');

        return $this->get_examples($args);
    }

    /**
     * 管理者用施工事例詳細ページ
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function example_detail($id)
    {
        return view(config('const.template.example.detail'), ['example' => Example::withTrashed()->find($id)]);
    }

    /**
     * 施工事例データ削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function example_del($id)
    {
        Example::destroy($id);

        return $this->get_examples();
    }

    /**
     * 依頼データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function requests()
    {
        return view(config('const.template.admin.request_list'), ['requests' => RequestModel::withTrashed()->paginate(10)]);
    }

    /**
     * 契約データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function contracts()
    {
        return view(config('const.template.admin.contract_list'), ['contracts' => Contract::withTrashed()->paginate(10)]);
    }

    /**
     * 口コミ・評価データ全件取得
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluations()
    {
        $args = request()->query('args');

        return $this->get_evaluations($args);
    }

    public function get_columns($args = null)
    {
        $query = Column::withTrashed()
                       ->join('painters', 'columns.painter_id', '=', 'painters.id')
                       ->select('columns.*', 'painters.name');

        if ($args) {
            $keyword1 = '%' . mb_convert_kana($args, 'aCKV') . '%';
            $keyword2 = '%' . $args . '%';

            $query = $query->where(function($q) use ($keyword1, $keyword2) {
                               $q->where('painters.name', 'like', $keyword1)
                                 ->orWhere('painters.name', 'like', $keyword2)
                                 ->orWhere('columns.title', 'like', $keyword1)
                                 ->orWhere('columns.title', 'like', $keyword2);
                             });
        }

        $query = $query->orderBy('columns.painter_id', 'asc')
                       ->orderBy('columns.id', 'asc');

        return $query->paginate(10);
    }

    public function get_examples($args = null)
    {
        $query = Example::withTrashed()
                        ->join('painters', 'examples.painter_id', '=', 'painters.id')
                        ->join('contracts', function ($join) {
                            $join->on('examples.contract_id', '=', 'contracts.id')
                                 ->where('contracts.user_id', '0')
                                 ->where('contracts.request_id', '0');
                        })
                        ->join('properties', function ($join) {
                            $join->on('contracts.property_id', '=', 'properties.id')
                                 ->where('properties.user_id', '0');
                        })
                        ->select('examples.*', 'painters.name as painter_name', 'properties.name as property_name');

        if ($args) {
            $keyword1 = '%' . mb_convert_kana($args, 'aCKV') . '%';
            $keyword2 = '%' . $args . '%';

            $query = $query->where(function($q) use ($keyword1, $keyword2) {
                               $q->where('painters.name', 'like', $keyword1)
                                 ->orWhere('painters.name', 'like', $keyword2)
                                 ->orWhere('properties.name', 'like', $keyword1)
                                 ->orWhere('properties.name', 'like', $keyword2);
                             });
        }

        $query = $query->orderBy('examples.painter_id', 'asc')
                       ->orderBy('examples.id', 'asc');

        return $query->paginate(10);
    }

    public function get_evaluations($args = null)
    {
        $query = Evaluation::withTrashed()
                           ->join('painters', 'evaluations.painter_id', '=', 'painters.id')
                           ->join('contracts', 'evaluations.contract_id', '=', 'contracts.id')
                           ->join('users', 'contracts.user_id', '=', 'users.id')
                           ->select('evaluations.*', 'painters.name', 'users.name1', 'users.name2');

        if ($args) {
            $keyword1 = '%' . mb_convert_kana($args, 'aCKV') . '%';
            $keyword2 = '%' . $args . '%';

            $query = $query->where(function($q) use ($keyword1, $keyword2) {
                               $q->where('painters.name', 'like', $keyword1)
                                 ->orWhere('painters.name', 'like', $keyword2)
                                 ->orWhere('users.name1', 'like', $keyword1)
                                 ->orWhere('users.name1', 'like', $keyword2)
                                 ->orWhere('users.name2', 'like', $keyword1)
                                 ->orWhere('users.name2', 'like', $keyword2);
                             });
        }

        $query = $query->orderBy('evaluations.painter_id', 'asc')
                       ->orderBy('contracts.user_id', 'asc')
                       ->orderBy('evaluations.id', 'asc');

        return $query->paginate(10);
    }
}
