<?php

namespace App\Repositories\User;

use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\UserSetting;
use App\Rules\MatchOldPasswordRule;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserRepository implements UserRepositoryInterface
{

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return User|Authenticatable|null
     */
    public function auth(): User|Authenticatable|null
    {
        $user = Auth::user();
        $user->profile;
        $settings = UserSetting::where('user_id', $user->id)->first();
        $user['settings'] = $settings;
        return $user;
    }

    /**
     * @return UserCollection
     */
    public function users(): UserCollection
    {
        return new UserCollection(User::where('id', '!=', auth()->id())->paginate(10));
    }

    /**
     * @return JsonResponse
     */
    public function updateEmail(): JsonResponse
    {
        $this->request->validate([
            'email' => 'required|unique:users|email',
        ]);

        $user = Auth::user();
        $user->email = $this->request->email;
        $user->save();
        return response()->json(['email' => $user->email]);
    }

    /**
     * @return JsonResponse
     */
    public function updatePassword(): JsonResponse
    {
        $this->request->validate([
            'current_password' => ['required', new MatchOldPasswordRule],
            'new_password' => ['required', 'min:8'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($this->request->new_password)]);
        return response()->json(['message' => 'Password changed']);
    }

    /**
     * @return JsonResponse|Exception
     * @throws Exception
     */
    public function updateProfile(): JsonResponse|Exception
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $this->request->validate([
                'name' => 'required',
                'phone' => [
                    'string',
                    'min:9',
                    'nullable',
                    Rule::unique('users')->ignore($user->id)
                ]

            ]);
            $user->phone = $this->request->phone;
            $user->name = $this->request->name;
            $user->profile()->update($this->request->profile);
            $user->save();
            $user->profile;
            DB::commit();
            return response()->json($user);
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }


    /**
     * @return JsonResponse
     */
    public function updateAvatar(): JsonResponse
    {
        $this->request->validate([
            'avatar' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if ($this->request->hasFile('avatar')) {
            $userAvatarFile = $this->request->file('avatar');
            $authUser = Auth::user();
            $avatarName = strtolower($authUser->name.time().'-avatar.'.$userAvatarFile->getClientOriginalExtension());
            $storageFolder = 'images/avatars/';
            $path = env('APP_URL').'/storage/images/avatars/'.$avatarName;
            $authUser->profile()->update(['avatar' => $path]);
            Storage::disk('public')->put($storageFolder.$avatarName, $userAvatarFile->getContent());
            return response()->json();
        }

        return response()->json(['File is empty']);
    }

    public function updatePoster(): JsonResponse
    {
        $this->request->validate([
            'poster' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if ($this->request->hasFile('poster')) {
            $userPosterFile = $this->request->file('poster');
            $authUser = Auth::user();
            $posterName = strtolower($authUser->name.time().'-avatar.'.$userPosterFile->getClientOriginalExtension());
            $storageFolder = 'images/posters/';
            $path = env('APP_URL').'/storage/images/posters/'.$posterName;
            $authUser->profile()->update(['poster' => $path]);
            Storage::disk('public')->put($storageFolder.$posterName, $userPosterFile->getContent());
            return response()->json();
        }

        return response()->json(['File is empty']);
    }

}
