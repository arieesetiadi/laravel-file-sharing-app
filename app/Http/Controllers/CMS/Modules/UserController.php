<?php

namespace App\Http\Controllers\CMS\Modules;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\User\StoreRequest;
use App\Http\Requests\CMS\User\UpdateRequest;
use App\Services\UserRoleService;
use App\Services\UserService;
use App\Traits\HasWebResponses;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    use HasWebResponses;

    /**
     * Default service class.
     */
    protected UserService $userService;

    /**
     * User role service class.
     */
    protected UserRoleService $userRoleService;

    /**
     * Controller module path.
     */
    private string $module;

    /**
     * Controller module titles.
     */
    private array $titles;

    /**
     * Initiate resource service class.
     */
    public function __construct(UserService $userService, UserRoleService $userRoleService)
    {
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
        $this->module = 'cms.modules.users';
        $this->titles = [
            'singular' => 'User',
            'plural' => 'Users',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = $this->userService->all(limit: 50);
        $view = $this->module . '.index';
        $data = [
            'titles' => $this->titles,
            'users' => $users,
        ];

        return view($view, $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $view = $this->module . '.create-or-edit';
        $data = [
            'titles' => $this->titles,
            'roles' => $this->userRoleService->all(),
            'edit' => false,
        ];

        return view($view, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        // Store user data
        $result = $this->userService->create($request->credentials());

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $user = $this->userService->find($id);
        $view = $this->module . '.detail';
        $data = [
            'titles' => $this->titles,
            'roles' => $this->userRoleService->all(),
            'user' => $user,
        ];

        return view($view, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $user = $this->userService->find($id);
        $view = $this->module . '.create-or-edit';
        $data = [
            'titles' => $this->titles,
            'roles' => $this->userRoleService->all(),
            'user' => $user,
            'edit' => true,
        ];

        return view($view, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        // Update user data
        $result = $this->userService->update($id, $request->credentials());

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Delete user data
        $result = $this->userService->delete($id);

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.users.index'));
    }

    /**
     * Change the specified resource status.
     */
    public function toggle(string $id): RedirectResponse
    {
        // Toggle user status
        $result = $this->userService->toggleStatus($id);

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.users.index'));
    }

    /**
     * Export as Excel.
     */
    public function excel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new UsersExport(), 'export-users-' . now()->timestamp . '.xlsx');
    }
}
