<?php

namespace App\Http\Controllers\CMS\Auth;

use App\Constants\UserRoleCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\Auth\LoginRequest;
use App\Services\UserService;
use App\Traits\HasWebResponses;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    use HasWebResponses;

    /**
     * Default service class.
     */
    protected UserService $userService;

    /**
     * Controller module path.
     */
    private string $module;

    /**
     * Controller module title.
     */
    private string $title;

    /**
     * Initiate controller properties value.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->module = 'cms.auth';
        $this->title = 'Sign In';
    }

    /**
     * Display login page.
     */
    public function index(): View
    {
        $view = $this->module . '.login';
        $data['title'] = $this->title;

        return view($view, $data);
    }

    /**
     * Attempt the login credentials.
     */
    public function process(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->credentials();

        // Get user data
        $user = $this->userService->findByUsername($credentials['username']);

        // Check user status
        if (!$user->status) {
            return $this->failed('Your account is inactive.');
        }

        // Check user role
        if ($user->role->code !== UserRoleCode::ADMIN) {
            return $this->failed('Invalid credential or password. Please try again.');
        }

        // Check auth result
        if (!auth('cms')->attempt($credentials)) {
            return $this->failed('Invalid credential or password. Please try again.');
        }

        // Redirect to CMS Dashboard
        return $this->success('Welcome, you are logged in successfully.', route('cms.dashboard'));
    }
}
