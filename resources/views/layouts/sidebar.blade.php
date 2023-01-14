<!-- Sidebar -->
<div id="application-sidebar"
    class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 left-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-200 pt-7 pb-10 overflow-y-auto scrollbar-y lg:block lg:translate-x-0 lg:right-auto lg:bottom-0 dark:scrollbar-y dark:bg-gray-800 dark:border-gray-700">
    <div class="px-6">
        <x-app-logo appName=" {{ $setting->getValue('app_name', 'Symanus') }} " />
    </div>

    <x-sidebar-nav>
        <!-- Dashboard -->
        <x-sidebar-nav-link url="{{ route('dashboard') }}" title="Dashboard" uri="dashboard">
            <x-slot name="icon">
                <x-svg.dashboard />
            </x-slot>
        </x-sidebar-nav-link>

        <!-- Student and Guardians -->
        @if ($module->hasModuleGroup('Students & Guardians Managment'))
            <p class="text-sm font-bold">Students & Guardians</p>
            @if ($module->hasModule('Students Management'))
                <x-sidebar-nav-link title="Students" uri="students">
                    <x-slot name="icon">
                        <x-svg.student />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Students" url="{{ route('students.index') }}" uri="students" />
                    <x-sidebar-nav-sublink title="New Student" url="{{ route('students.create') }}"
                        uri="students/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Guardians Managment'))
                <x-sidebar-nav-sublink title="Gurdians" uri="guardians">
                    <x-sidebar-nav-sublink title="List Guaridans" url="{{ route('guardians.index') }}"
                        uri="guardians" />
                    <x-sidebar-nav-sublink title="New Guardian" url="{{ route('guardians.create') }}"
                        uri="guardians/create" />
                </x-sidebar-nav-sublink>
            @endif
        @endif
        <!-- Education -->
        @if ($module->hasModuleGroup('Education Managment'))
            <p class="text-sm font-bold">Education</p>
            @if ($module->hasModule('Attendance Management'))
                <x-sidebar-nav-link title="Attendance" uri="attendance">
                    <x-slot name="icon">
                        <x-svg.attendance />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Attendances" url="{{ route('attendances.index') }}"
                        uri="attendances" />
                    <x-sidebar-nav-sublink title="Take Attendances" url="{{ route('attendances.create') }}"
                        uri="attendances/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Assessment Management'))
                <x-sidebar-nav-link title="Assessment" uri="assessment">
                    <x-slot name="icon">
                        <x-svg.student />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Assessment" url="{{ route('attendances.index') }}"
                        uri="assessments" />
                    <x-sidebar-nav-sublink title="Take Assessment" url="{{ route('attendances.create') }}"
                        uri="assessments/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Courses Management'))
                <x-sidebar-nav-link title="Courses" uri="courses">
                    <x-slot name="icon">
                        <x-svg.course />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Courses" url="{{ route('courses.index') }}" uri="courses" />
                    <x-sidebar-nav-sublink title="New Course" url="{{ route('courses.create') }}"
                        uri="courses/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Classes Management'))
                <x-sidebar-nav-link title="Classes" uri="classes">
                    <x-slot name="icon">
                        <x-svg.class />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Classes" url="{{ route('classes.index') }}" uri="classes" />
                    <x-sidebar-nav-sublink title="New Class" url="{{ route('classes.create') }}"
                        uri="classes/create" />
                </x-sidebar-nav-link>
            @endif
        @endif
        <!-- Accounting -->
        @if ($module->hasModuleGroup('Finance & Accounting Management'))
            <p class="text-sm font-bold">Accounting</p>
            <x-sidebar-nav-link title="Accounting Overview" uri="accouting-overview">
                <x-slot name="icon">
                    <x-svg.dashboard />
                </x-slot>
            </x-sidebar-nav-link>
            @if ($module->hasModule('Fees Collection Management'))
                <x-sidebar-nav-link title="Fees" uri="fees">
                    <x-slot name="icon">
                        <x-svg.payment />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Fees" url="{{ route('fees.index') }}" uri="fees" />
                    <x-sidebar-nav-sublink title="New Fees" url="{{ route('fees.create') }}" uri="fees/create" />
                </x-sidebar-nav-link>
                <x-sidebar-nav-link title="Bills & Payments" uri="bills">
                    <x-slot name="icon">
                        <x-svg.payment />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Bills" url="{{ route('bills.index') }}" uri="bills" />
                    <x-sidebar-nav-sublink title="Generate New Bills" url="{{ route('bills.create') }}"
                        uri="bills/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Expense Management'))
                <x-sidebar-nav-link title="Expense Report" uri="expense-reports">
                    <x-slot name="icon">
                        <x-svg.attendance />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Expense Reports" url="{{ route('staffs.index') }}" />
                    <x-sidebar-nav-sublink title="New Expense Reports" url="{{ route('staffs.create') }}" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Salaries Management'))
                <x-sidebar-nav-link title="Salaries" uri="salaries">
                    <x-slot name="icon">
                        <x-svg.teacher />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Salaries" url="{{ route('staffs.index') }}" />
                    <x-sidebar-nav-sublink title="New Salary" url="{{ route('staffs.create') }}" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Reporting Management'))
                <x-sidebar-nav-link title="Reporting" uri="reporting">
                    <x-slot name="icon">
                        <x-svg.attendance />
                    </x-slot>
                    @if ($module->hasModuleGroup('Finance & Accounting Management'))
                        @if ($module->hasModule('Fees Collection Management'))
                            <x-sidebar-nav-sublink title="Student balances"
                                url="{{ route('reporting.student-balances') }}" uri="reporting/student-balances" />
                            <x-sidebar-nav-sublink title="Fee bills by class"
                                url="{{ route('reporting.bills-by-class') }}" uri="reporting/bills-by-class" />
                            <x-sidebar-nav-sublink title="Fee bills by user"
                                url="{{ route('reporting.bills-by-user') }}" uri="reporting/bills-by-user" />
                            <x-sidebar-nav-sublink title="Income by class"
                                url="{{ route('reporting.income-by-class') }}" uri="reporting/income-by-class" />
                            <x-sidebar-nav-sublink title="Income by user"
                                url="{{ route('reporting.income-by-user') }}" uri="reporting/income-by-user" />
                            @if ($module->hasModule('Expense Management'))
                                <x-sidebar-nav-sublink title="Expense by user" url="{{ route('staffs.index') }}" />
                                <x-sidebar-nav-sublink title="Expense by expense type"
                                    url="{{ route('staffs.index') }}" />
                            @endif
                        @endif
                    @endif
                    @if ($module->hasModule('Bank Account Management'))
                        <x-sidebar-nav-sublink title="Accounts Closure" url="{{ route('staffs.create') }}" />
                    @endif
                </x-sidebar-nav-link>
            @endif
        @endif

        <!-- HRM -->
        @if ($module->hasModuleGroup('Human Resource Management (HR)'))
            <p class="text-sm font-bold">HRM</p>
            @if ($module->hasModule('Users & Roles Management'))
                <x-sidebar-nav-link title="Users" uri="users">
                    <x-slot name="icon">
                        <x-svg.user />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Users" url="{{ route('users.index') }}" uri="users" />
                    <x-sidebar-nav-sublink title="New User" url="{{ route('users.create') }}" uri="users/create" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Staff/Teachers Management'))
                <x-sidebar-nav-link title="Staffs" uri="staffs">
                    <x-slot name="icon">
                        <x-svg.teacher />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Staffs" url="{{ route('staffs.index') }}" />
                    <x-sidebar-nav-sublink title="New Staff" url="{{ route('staffs.create') }}" />
                </x-sidebar-nav-link>
            @endif
            @if ($module->hasModule('Leave Management'))
                <x-sidebar-nav-link title="Leave" uri="leave">
                    <x-slot name="icon">
                        <x-svg.attendance />
                    </x-slot>
                    <x-sidebar-nav-sublink title="List Leave" url="{{ route('staffs.index') }}" />
                    <x-sidebar-nav-sublink title="New Leave" url="{{ route('staffs.create') }}" />
                </x-sidebar-nav-link>
            @endif
        @endif

        <p class="text-sm font-bold">Account & Setup</p>
        <!-- Account -->
        <x-sidebar-nav-link title="Account">
            <x-slot name="icon">
                <x-svg.user />
            </x-slot>
            <x-sidebar-nav-sublink title="Profile" url="{{ route('profile') }}" uri="account/profile" />
            <x-sidebar-nav-sublink title="Update Profile" url="{{ route('update-profile') }}"
                uri="account/update-profile" />
        </x-sidebar-nav-link>

        @if ($module->hasModule('SMS Management'))
            <x-sidebar-nav-link title="SMS" uri="sms">
                <x-slot name="icon">
                    <x-svg.sms />
                </x-slot>
                <x-sidebar-nav-sublink title="List SMS" />
                <x-sidebar-nav-sublink title="Send SMS" />
                <x-sidebar-nav-sublink title="Top-up SMS Units" />
            </x-sidebar-nav-link>
        @endif
        <!-- Setup -->
        <x-sidebar-nav-link title="Setup" uri="setup">
            <x-slot name="icon">
                <x-svg.setting />
            </x-slot>
            <x-sidebar-nav-link title="Modules" url="{{ route('modules.index') }}">
                <x-slot name="icon">
                    <x-svg.course />
                </x-slot>
            </x-sidebar-nav-link>
            <x-sidebar-nav-link title="Settings" url="{{ route('settings.index') }}">
                <x-slot name="icon">
                    <x-svg.setting />
                </x-slot>
            </x-sidebar-nav-link>
            <x-sidebar-nav-link title="Permissions" url="{{ route('permissions.create') }}">
                <x-slot name="icon">
                    <x-svg.permission />
                </x-slot>
            </x-sidebar-nav-link>
            <x-sidebar-nav-link title="Attributes" uri="setup/attributes">
                <x-slot name="icon">
                    <x-svg.database />
                </x-slot>
                <x-sidebar-nav-link title="User Roles" url="{{ route('user-roles.create') }}"
                    uri="setup/attributes/user-roles/create">
                    <x-slot name="icon">
                        <x-svg.arrow-right />
                    </x-slot>
                </x-sidebar-nav-link>

                @if ($module->hasModule('Fees Collection Management'))
                    <x-sidebar-nav-link title="Fee Types" url="{{ route('fee-types.create') }}"
                        uri="setup/attributes/fee-types/create">
                        <x-slot name="icon">
                            <x-svg.arrow-right />
                        </x-slot>
                    </x-sidebar-nav-link>
                @endif

                @if ($module->hasModule('Expense Management'))
                    <x-sidebar-nav-link title="Expense Types" url="{{ route('fee-types.create') }}"
                        uri="setup/attributes/expense-types/create">
                        <x-slot name="icon">
                            <x-svg.arrow-right />
                        </x-slot>
                    </x-sidebar-nav-link>
                @endif
                <x-sidebar-nav-link title="Semesters" url="{{ route('semesters.create') }}"
                    uri="setup/attributes/semesters/create">
                    <x-slot name="icon">
                        <x-svg.arrow-right />
                    </x-slot>
                </x-sidebar-nav-link>
            </x-sidebar-nav-link>
        </x-sidebar-nav-link>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-sidebar-nav-link title="Log Out" :href="route('logout')"
                onclick="event.preventDefault();
        this.closest('form').submit();">
                <x-slot name="icon">
                    <x-svg.logout />
                </x-slot>
            </x-sidebar-nav-link>
        </form>
    </x-sidebar-nav>
</div>
<!-- End Sidebar -->
