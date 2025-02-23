<?php

namespace App\Http\Controllers\Auth;

use App\Enums\MessageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\HasFile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class RegisteredUserController extends Controller
{
    use HasFile;
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => $this->upload_file($request, 'avatar', 'users'),
            ]);

            $user->student()->create([
                'student_number' => $request->student_number,
                'semester' => $request->semester,
                'batch' => $request->batch,
            ]);

            $user->assignRole('Student');

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            flashMessage(MessageType::CREATED->message('Pendaftaran Berhasil'));
            return redirect(route('dashboard', absolute: false));
        } catch (Throwable $e) {
            DB::rollBack();
            flashMessage(MessageType::ERROR->message($e->getMessage(), 'error'));
            return to_route('login');
        }
    }
}
