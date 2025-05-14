<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
         $user = $request->user();
     
         // Cập nhật thông tin cơ bản từ validated() — KHÔNG có avatar ở đây!
         $user->fill($request->validated());
     
         // Nếu đổi email thì reset xác minh
         if ($user->isDirty('email')) {
             $user->email_verified_at = null;
         }
     
         // Xử lý avatar nếu có file upload
         if ($request->hasFile('avatar')) {
             $file = $request->file('avatar');
             $filename = time() . '_' . $file->getClientOriginalName();
             $destinationPath = public_path('images/nguoidung');
     
             // Tạo thư mục nếu chưa có
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true);
             }
     
             // Lưu file
             $file->move($destinationPath, $filename);
     
             // Xoá ảnh cũ nếu tồn tại
             if ($user->avatar && file_exists($destinationPath . '/' . $user->avatar)) {
                 unlink($destinationPath . '/' . $user->avatar);
             }
     
             // ✅ Gán tên ảnh vào đối tượng User SAU khi fill()
             $user->avatar = $filename;
         }
     
         // Lưu người dùng
         $user->save();
     
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
