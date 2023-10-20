<?php

namespace App\Http\Controllers\CMS\Modules;

use App\Constants\UserRoleCode;
use App\Events\FilesSharedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Share\StoreRequest;
use App\Services\ShareService;
use App\Services\UploadService;
use App\Services\UserService;
use App\Traits\HasWebResponses;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
     * File Upload service class.
     */
    protected UploadService $uploadService;

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
    public function __construct(ShareService $shareService, UserService $userService, UploadService $uploadService)
    {
        $this->shareService = $shareService;
        $this->userService = $userService;
        $this->uploadService = $uploadService;
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
        DB::transaction(function () use ($request) {
            // Store share
            $share = $request->validatedShare();
            $share = $this->shareService->create($share);

            // Upload files
            foreach ($request->file('files') as $file) {
                $fileData['name'] = $this->uploadService->file(file: $file, directory: 'shares');
                $fileData['extension'] = $file->getClientOriginalExtension();
                $share->files()->create($fileData);
            }

            // Attach share user
            $share->receivingUsers()->attach($request->user_ids);
            $share->load(['sendingUser', 'receivingUsers', 'files']);

            FilesSharedEvent::dispatch($share);
        });

        return $this->success('The files has been shared successfully.', route('cms.shares.index'));
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
}
