<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRequest;
use App\Nrna\Models\User;
use App\Nrna\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    protected $user;

    protected $roles = ['admin' => 'Admin', 'editor' => 'Editor', 'contributor' => 'Contributor'];

    /**
     * UserController constructor.
     * @param UserService $user
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(15);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->roles;

        return view('user.create', compact('roles'));
    }


    /**
     * @param UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->user->save($request->all());

        return redirect('user')->with('success', 'user successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $user = $this->user->find($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = $this->roles;

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int        $id
     * @param UserRequest $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, UserRequest $request)
    {
        $this->user->update($id, $request->all());

        return redirect('user')->with('success', 'user successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->user->destroy($id);

        return redirect('user')->with('success', 'user successfully deleted!');
    }

}
