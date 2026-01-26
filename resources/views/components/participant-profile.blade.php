<div>
    <div class="input-group mb-3">
        <input type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->getUser()->name) }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('name')
        <span class="error invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="input-group mb-3">
        <input type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->getUser()->email) }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
        @error('email')
        <span class="error invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="input-group mb-3">
        <input type="text" name="department"
               class="form-control @error('department') is-invalid @enderror"
               placeholder="{{ __('Department') }}" value="{{ old('department', auth()->user()->getUser()->department) }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <i class="fas fa-building"></i>
            </div>
        </div>
        @error('department')
        <span class="error invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    @if(auth()->user()->isFaculty())
        <div class="input-group mb-3">
            <input type="text" name="position"
                class="form-control @error('position') is-invalid @enderror"
                placeholder="{{ __('Position') }}" value="{{ old('position', auth()->user()->getUser()->position) }}" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-user-tag"></i>
                </div>
            </div>
            @error('position')
            <span class="error invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    @endif

    @if(auth()->user()->isStudent)
        <div class="input-group mb-3">
            <input type="number" name="year_level"
                class="form-control @error('year_level') is-invalid @enderror"
                placeholder="{{ __('Year Level') }}" value="{{ old('year_level', auth()->user()->getUser()->year_level) }}" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            @error('year_level')
            <span class="error invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <input type="text" name="section"
                class="form-control @error('section') is-invalid @enderror"
                placeholder="{{ __('Section') }}" value="{{ old('section', auth()->user()->getUser()->section) }}" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            @error('section')
            <span class="error invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    @endif

    <div class="input-group mb-3">
        <input type="number" name="contact_number"
               class="form-control @error('contact_number') is-invalid @enderror"
               placeholder="{{ __('Contact Number') }}" value="{{ old('contact_number', auth()->user()->getUser()->contact_number) }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <i class="fas fa-phone-alt"></i>
            </div>
        </div>
        @error('contact_number')
        <span class="error invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    {{-- <div class="input-group mb-3">
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="{{ __('New password') }}">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
        @error('password')
        <span class="error invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="input-group mb-3">
        <input type="password" name="password_confirmation"
               class="form-control @error('password_confirmation') is-invalid @enderror"
               placeholder="{{ __('New password confirmation') }}"
               autocomplete="new-password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div> --}}
</div>