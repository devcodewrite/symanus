<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property string $adate
 * @property int $class_id
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\AttendanceFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Query\Builder|Attendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereAdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Attendance withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attendance withoutTrashed()
 */
	class Attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AttendanceStudent
 *
 * @property int $attendance_id
 * @property int $student_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attendance $attendance
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttendanceStudent whereUpdatedAt($value)
 */
	class AttendanceStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Classes
 *
 * @property int $id
 * @property string $name
 * @property int $level
 * @property int|null $staff_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $classUser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Course[] $courses
 * @property-read int|null $courses_count
 * @property-read \App\Models\Staff|null $staff
 * @method static \Database\Factories\ClassesFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes newQuery()
 * @method static \Illuminate\Database\Query\Builder|Classes onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Classes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Classes withoutTrashed()
 */
	class Classes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int|null $classes_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classes $class
 * @method static \Database\Factories\CourseFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Query\Builder|Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereClassesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Course withoutTrashed()
 */
	class Course extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Fee
 *
 * @property int $id
 * @property string $description
 * @property int|null $class_id
 * @property int $fee_type_id
 * @property string $amount
 * @property string $rstatus
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Classes|null $class
 * @method static \Database\Factories\FeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee newQuery()
 * @method static \Illuminate\Database\Query\Builder|Fee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereFeeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereRstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Fee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Fee withoutTrashed()
 */
	class Fee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FeeType
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Fee[] $fees
 * @property-read int|null $fees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\FeeTypeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType newQuery()
 * @method static \Illuminate\Database\Query\Builder|FeeType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FeeType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|FeeType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FeeType withoutTrashed()
 */
	class FeeType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Guardian
 *
 * @property int $id
 * @property string $rstate
 * @property string $title
 * @property string $firstname
 * @property string $surname
 * @property string $sex
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $email
 * @property string|null $dateofbirth
 * @property string|null $occupation
 * @property string|null $avatar
 * @property string|null $linked_files
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\GuardianFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian newQuery()
 * @method static \Illuminate\Database\Query\Builder|Guardian onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereDateofbirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereLinkedFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereRstate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guardian whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Guardian withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Guardian withoutTrashed()
 */
	class Guardian extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $student_id
 * @property string $amount
 * @property string $paid_at
 * @property int $fee_type_id
 * @property string|null $paid_by
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FeeType $feeType
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PaymentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereFeeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Payment withoutTrashed()
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserRole[] $userRoles
 * @property-read int|null $user_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Semester
 *
 * @property int $id
 * @property string $title
 * @property string|null $start
 * @property string|null $end
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SemesterFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester newQuery()
 * @method static \Illuminate\Database\Query\Builder|Semester onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester query()
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Semester whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Semester withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Semester withoutTrashed()
 */
	class Semester extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Setting
 *
 * @property int $key
 * @property string|null $value
 * @property string|null $note
 * @method static \Database\Factories\SettingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Staff
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $rstate
 * @property string|null $employed_at
 * @property string $staffid
 * @property string $title
 * @property string $firstname
 * @property string $surname
 * @property string $sex
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $email
 * @property string|null $dateofbirth
 * @property string|null $job_title
 * @property string|null $salary
 * @property string|null $avatar
 * @property string|null $linked_files
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Classes[] $classes
 * @property-read int|null $classes_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\StaffFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Query\Builder|Staff onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereDateofbirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereEmployedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereLinkedFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereRstate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereStaffid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Staff withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Staff withoutTrashed()
 */
	class Staff extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property int $class_id
 * @property string $rstate
 * @property string|null $admitted_at
 * @property string $studentid
 * @property string $firstname
 * @property string $surname
 * @property string $sex
 * @property string $transit
 * @property string $affiliation
 * @property string|null $address
 * @property string|null $dateofbirth
 * @property string|null $avatar
 * @property string|null $linked_files
 * @property int|null $guardian_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attendance[] $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\Guardian|null $guardian
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\StudentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Query\Builder|Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAdmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAffiliation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDateofbirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereGuardianId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereLinkedFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereRstate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereStudentid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTransit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Student withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Student withoutTrashed()
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $username
 * @property string $firstname
 * @property string $surname
 * @property string|null $phone
 * @property string|null $avatar
 * @property int $user_role_id
 * @property int|null $permission_id
 * @property string $rstatus
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $api_token
 * @property-read \App\Models\Guardian|null $guardian
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Permission|null $permission
 * @property-read \App\Models\Staff|null $staff
 * @property-read \App\Models\UserRole $userRole
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserRole
 *
 * @property int $id
 * @property string $title
 * @property int|null $permission_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Permission|null $permission
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserRole onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UserRole withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserRole withoutTrashed()
 */
	class UserRole extends \Eloquent {}
}

