<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 

class RegisteredEmployeeController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        Log::info('Registration request received', $request->all());

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $employee = $this->createEmployee($request->all());
            Log::info('Employee created', $employee->toArray());
            return redirect()->route('dashboard')->with('success', 'Employee registered successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to register employee. Please try again.')->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'position' => ['required', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'email_address' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'address' => ['required', 'string'],
            'user_name' => ['required', 'string', 'max:255', 'unique:employees'],
            'phone_number' => ['required', 'string', 'max:15'],
            'gender' => ['required', 'in:Male,Female'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function createEmployee(array $data)
    {
        $position_id = $this->getPositionId($data['position']);

        return Employee::create([
            'position_id' => $position_id,
            'position' => $data['position'],
            'full_name' => $data['full_name'],
            'email_address' => $data['email_address'],
            'address' => $data['address'],
            'user_name' => $data['user_name'],
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function getPositionId($position)
    {
        switch ($position) {
            case 'Manager':
                return 1;
            case 'Stock Keeper':
                return 2;
            case 'Supermarket':
                return 3;
            default:
                return 0;
        }
    }
}
?>
