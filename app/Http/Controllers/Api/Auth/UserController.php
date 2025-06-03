<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser()
    {
        $userData = '';
        $user = User::with([
            'roles' => function ($q) {
                $q->select('id', 'display_name', 'name');
            },


        ])->find(auth()->user()->id);

        $userData = [
            'id' => $user['id'],
            'code' => $user['code'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => $user['avatar'],
            'roles' => $this->getRoles($user),
            'permissions' => $this->getPermissions($user),
            'organization' => $user->organizations,
            // get user notifications where order by created_at desc and read_at is null

        ];
        return response()->json($userData);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }


    private function getPermissions($user)
    {
        $permissionData = array();
        $permissions = $user->getAllPermissions();
        foreach ($permissions as $key => $perm) {
            $permissionData[$key] = [
                'id' => $perm['id'],
                'name' => $perm['name'],
                'display_name' => $perm['display_name'],
            ];
        }
        return  $permissionData;
    }

    private function getRoles($user): array
    {
        $roleData = array();
        $roles = $user->roles;
        foreach ($roles as $key => $role) {
            $roleData[$key] = [
                'id' => $role['id'],
                'name' => $role['name'],
                'display_name' => $role['display_name'],
            ];
        }
        return  $roleData;
    }
}
