<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Card with Image and Login Form -->
        <div class="card image-card">
            <img src="{{ asset('images/background.jpg') }}" alt="Background Image">
            
            <!-- Login Form Card Inside -->
            <div class="login-card" >
                <!-- Title Icon -->
                <div class="title-icon">
                    <img src="{{ asset('images/profile.png') }}" alt="Profile Icon" class="title-icon">
                </div>
                <h1>Login</h1>
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <!-- Username Field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <img src="{{ asset('images/username1.png') }}" alt="Username Icon">
                        </div>
                        <input type="text" id="username" name="username" placeholder="Enter your username" value="{{ old('username') }}" required>
                        @error('username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="input-group">
                        <div class="input-icon">
                            <img src="{{ asset('images/password.png') }}" alt="Password Icon">
                        </div>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Options -->
                    <div class="options">
                        <label >
                            <input type="checkbox" > Remember Me
                        </label>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
