<nav class="navbar">
    <!-- Column 1: Logo -->
     <div class="navbar__logo">
        <a href="/">
            <div class="logo-title">E-Learn</div>
            <span>English Online</span>
        </a>
     </div>

    <!-- Column 2: Navigation Links -->
    <div class="navbar__links">
        <a href="/">Home</a>
        <a href="{{route('courses.index')}}">Courses</a>
        <a href="{{route('roadmap')}}">Road Maps</a>
        <a href="{{route('instructor.index')}}">Instructors</a>
        <a href="{{route('blog.index')}}">Blog</a>
        <a href="{{route('about')}}">About Us</a>
    </div>

    <!-- Column 3: User Actions -->
    <div class="navbar__actions">
        <input type="text" placeholder="search...">
        <a href="{{route('login')}}" class="btn btn--primary">Login</a>
        <a href="{{route('register')}}" class="btn btn--secondary">Register</a>
    </div>
</nav>