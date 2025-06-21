<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user()
        ]);
    }


    /**
     * Update the user's profile information.
     */

     public function update(ProfileUpdateRequest $request): RedirectResponse
{
    Log::info('🔥 Hàm update() đang được gọi');

    $user = $request->user();

    try {
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            Log::info('Đang xử lý avatar mới:', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
            ]);

            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('images/nguoidung');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
                Log::info("Đã tạo thư mục $destinationPath");
            }

            $moved = $file->move($destinationPath, $filename);

            if ($moved) {
                Log::info("Ảnh đã được lưu: $filename");
            } else {
                Log::error("Không thể lưu ảnh avatar.");
            }

            if ($user->avatar && file_exists($destinationPath . '/' . $user->avatar)) {
                unlink($destinationPath . '/' . $user->avatar);
                Log::info("Đã xoá ảnh cũ: " . $user->avatar);
            }

            $user->avatar = $filename;
        }

        $user->save();
        Log::info("Cập nhật thông tin người dùng thành công: ID {$user->id}");

    } catch (\Exception $e) {
        Log::error("Lỗi khi cập nhật profile: " . $e->getMessage());
    }

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
     


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
