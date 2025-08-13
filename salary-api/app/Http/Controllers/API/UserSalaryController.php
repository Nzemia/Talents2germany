<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SalaryDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserSalaryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'salary_local_currency' => 'required|numeric|min:0',
            ]);

            // Check if user exists by email
            $user = User::where('email', $validated['email'])->first();

            if ($user) {
                // Update existing user and salary
                $user->update(['name' => $validated['name']]);
                
                $salaryDetail = $user->salaryDetail;
                if ($salaryDetail) {
                    $salaryDetail->update([
                        'salary_local_currency' => $validated['salary_local_currency']
                    ]);
                } else {
                    // Create new salary detail if doesn't exist
                    SalaryDetail::create([
                        'user_id' => $user->id,
                        'salary_local_currency' => $validated['salary_local_currency'],
                    ]);
                }
            } else {
                // Create new user
                $user = User::create($validated);
                
                // Create salary detail
                SalaryDetail::create([
                    'user_id' => $user->id,
                    'salary_local_currency' => $validated['salary_local_currency'],
                ]);
            }

            return response()->json([
                'message' => 'Salary details saved successfully',
                'user' => $user->load('salaryDetail')
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
}