<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function registerEmployee(Request $request)
    {
        $this->employeeValidator($request->all())->validate();

        $employee = $this->createEmployee($request->all());

        // Do not log in the employee directly
        // Instead, redirect to a success page or login page
        return redirect()->route('login')->with('status', 'Employee registered successfully. Please login.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function employeeValidator(array $data)
    {
        return Validator::make($data, [
            'position' => ['required', 'string', 'max:255'],
            'fullName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees,email_address'],
            'address' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:employees,user_name'],
            'phone' => ['required', 'string', 'max:10'],
            'gender' => ['required', 'in:Male,Female'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function createEmployee(array $data)
    {
        return Employee::create([
            'position' => $data['position'],
            'full_name' => $data['fullName'],
            'email_address' => $data['email'],
            'address' => $data['address'],
            'user_name' => $data['username'],
            'phone_number' => $data['phone'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
?>
