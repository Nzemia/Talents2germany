<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SalaryDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function getAllSalaries()
    {
        try {
            $users = User::with('salaryDetail')->get();
            
            return response()->json([
                'message' => 'Salary details retrieved successfully',
                'data' => $users
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateSalary(Request $request, $userId)
    {
        try {
            $validated = $request->validate([
                'salary_local_currency' => 'sometimes|numeric|min:0',
                'salary_in_euros' => 'sometimes|numeric|min:0',
                'commission' => 'sometimes|numeric|min:0',
            ]);

            $user = User::findOrFail($userId);
            $salaryDetail = $user->salaryDetail;

            if (!$salaryDetail) {
                return response()->json([
                    'message' => 'Salary detail not found for this user'
                ], 404);
            }

            $salaryDetail->update($validated);

            return response()->json([
                'message' => 'Salary details updated successfully',
                'data' => $user->load('salaryDetail')
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getSalaryById($userId)
    {
        try {
            $user = User::with('salaryDetail')->findOrFail($userId);
            
            return response()->json([
                'message' => 'Salary details retrieved successfully',
                'data' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}