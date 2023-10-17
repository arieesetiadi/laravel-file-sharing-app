<?php

namespace App\Http\Controllers\CMS\Modules;

use App\Constants\UserRoleCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Sharing\StoreRequest;
use App\Http\Requests\CMS\Sharing\UpdateRequest;
use App\Services\ShareService;
use App\Services\UserService;
use App\Traits\HasWebResponses;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ShareController extends Controller
{
    use HasWebResponses;

    /**
     * Default service class.
     */
    protected ShareService $shareService;

    /**
     * User service class.
     */
    protected UserService $userService;

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
    public function __construct(ShareService $shareService, UserService $userService)
    {
        $this->shareService = $shareService;
        $this->userService = $userService;
        $this->module = 'cms.modules.shares';
        $this->titles = [
            'singular' => 'Share',
            'plural' => 'Shares',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $shares = $this->shareService->all();
        $view = $this->module . '.index';
        $data = [
            'titles' => $this->titles,
            'shares' => $shares,
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
            'users' => $this->userService->getByRoleCode(UserRoleCode::GENERAL),
            'edit' => false,
        ];

        return view($view, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        // Store file data
        $result = $this->shareService->create($request->credentials());

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.shares.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $file = $this->shareService->find($id);
        $view = $this->module . '.detail';
        $data = [
            'titles' => $this->titles,
            'file' => $file,
        ];

        return view($view, $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $file = $this->shareService->find($id);
        $view = $this->module . '.create-or-edit';
        $data = [
            'titles' => $this->titles,
            'users' => $this->userService->getByRoleCode(UserRoleCode::GENERAL),
            'file' => $file,
            'edit' => true,
        ];

        return view($view, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        // Update file data
        $result = $this->shareService->update($id, $request->credentials());

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.shares.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Delete file data
        $result = $this->shareService->delete($id);

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.shares.index'));
    }

    /**
     * Change the specified resource status.
     */
    public function toggle(string $id): RedirectResponse
    {
        // Toggle file status
        $result = $this->shareService->toggleStatus($id);

        if (!$result) {
            return $this->failed('Sorry, we could not complete the process. Please try again.');
        }

        return $this->success('The process has been completed successfully.', route('cms.shares.index'));
    }
}
