<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // =========================================================================
    // ផ្នែកទី ១ - Create (បង្កើតទិន្នន័យ)
    // =========================================================================
    public function createData()
    {
        // 2. បង្កើត object ថ្មីរួចហៅ save()
        $teacher1 = new Teacher();
        $teacher1->name = "ចាន់ សុខា";
        $teacher1->email = "sokha1.chan@example.com";
        $teacher1->phone = "012345678";
        $teacher1->address = "ភ្នំពេញ";
        $teacher1->dob = "1990-05-15";
        $teacher1->gender = "ប្រុស";
        $teacher1->subject = "Mathematics";
        $teacher1->save();

        // 3. ប្រើ Teacher::create() (កំណត់ $fillable ក្នុង Model)
        $teacher2 = Teacher::create([
            "name" => "កែវ សុភា",
            "email" => "sophea.keo@example.com",
            "phone" => "098765432",
            "address" => "សៀមរាប",
            "dob" => "1995-08-20",
            "gender" => "ស្រី",
            "subject" => "Mathematics",
        ]);

        // 4. ប្រើ firstOrCreate() កុំឱ្យជាន់ Email
        $teacher3 = Teacher::firstOrCreate(
            ["email" => "sophea.keo@example.com"],
            [
                "name" => "កែវ សុភា ថ្មី",
                "phone" => "098765432",
                "address" => "សៀមរាប",
                "dob" => "1995-08-20",
                "gender" => "ស្រី",
                "subject" => "Physics",
            ]
        );

        return [
            "2_save" => $teacher1,
            "3_create" => $teacher2,
            "4_firstOrCreate" => $teacher3,
        ];
    }

    // =========================================================================
    // ផ្នែកទី ២ – Update (កែប្រែទិន្នន័យ)
    // =========================================================================
    public function updateData()
    {
        // 5. ស្វែងរកតាម id រួចកែ phone ដោយប្រើ find() និង save()
        $teacher5 = Teacher::find(1);
        if ($teacher5) {
            $teacher5->phone = "088-999-888";
            $teacher5->save();
        }

        // 6. ប្រើ update() កែ address ក្នុងតែមួយជួរបញ្ជា
        Teacher::where("id", 1)->update([
            "address" => "បាត់ដំបង",
        ]);

        // 7. កែ subject ពី Mathematics ទៅ Physics (where()->update())
        Teacher::where("subject", "Mathematics")->update([
            "subject" => "Physics",
        ]);

        // 8. ប្រើ updateOrCreate()
        $teacher8 = Teacher::updateOrCreate(
            ["email" => "dara.heng@example.com"],
            [
                "name" => "ហេង តារា",
                "phone" => "077-112-233",
                "address" => "កំពង់ចាម",
                "dob" => "1992-12-10",
                "gender" => "ប្រុស",
                "subject" => "Chemistry",
            ]
        );

        return [
            "5_find_save" => $teacher5,
            "6_update_one_line" => Teacher::find(1),
            "7_where_update" => Teacher::where("subject", "Physics")->get(),
            "8_updateOrCreate" => $teacher8,
        ];
    }

    // =========================================================================
    // ផ្នែកទី ៣ - Query (ស្វែងរកទិន្នន័យ)
    // =========================================================================
    public function queryData()
    {
        // 9. Teacher::all()
        $allTeachers = Teacher::all();

        // 10. find() និង findOrFail()
        $findTeacher = Teacher::find(1);
        $findOrFailTeacher = Teacher::findOrFail(1);

        // 11. where() រកមុខវិជ្ជា Physics/Mathematics
        $mathTeachers = Teacher::where("subject", "Physics")->get();

        // 12. orderBy() តាម name ពី A-Z
        $orderedTeachers = Teacher::orderBy("name", "asc")->get();

        // 13. where() ច្រើនលក្ខខណ្ឌ (ភេទស្រី + Physics)
        $femaleTeachers = Teacher::where("gender", "ស្រី")
            ->where("subject", "Physics")
            ->get();

        // 14. count() ចំនួនគ្រូសរុប
        $totalTeachers = Teacher::count();

        // 15. paginate(10)
        $paginatedTeachers = Teacher::paginate(10);

        // 16. like ('%...%') ស្វែងរកឈ្មោះមានពាក្យ សុភា
        $likeTeachers = Teacher::where("name", "LIKE", "%សុភា%")->get();

        return [
            "9_all" => $allTeachers,
            "10_find" => $findTeacher,
            "10_findOrFail" => $findOrFailTeacher,
            "11_where_subject" => $mathTeachers,
            "12_orderBy" => $orderedTeachers,
            "13_multi_where" => $femaleTeachers,
            "14_count" => $totalTeachers,
            "15_paginate" => $paginatedTeachers,
            "16_like" => $likeTeachers,
        ];
    }

    // =========================================================================
    // ផ្នែកទី ៤ - Delete (លុបទិន្នន័យ)
    // =========================================================================
    public function deleteData()
    {
        // 17. find() រួច delete()
        $teacher17 = Teacher::find(1);
        if ($teacher17) {
            $teacher17->delete();
        }

        // 18. Teacher::destroy() ជា array
        Teacher::destroy([2, 3]);

        // 19. where()->delete() លុបមុខវិជ្ជា Chemistry
        Teacher::where("subject", "Chemistry")->delete();

        // 20. Soft Delete (ទាញយកទិន្នន័យទាំងដែលបាន Soft Delete មកបង្ហាញ)
        $withDeletedTeachers = Teacher::withTrashed()->get();

        return [
            "17_delete" => "លុប Teacher ID 1 រួចរាល់",
            "18_destroy" => "លុប Teacher ID 2, 3 រួចរាល់",
            "19_where_delete" => "លុប Teacher មុខវិជ្ជា Chemistry រួចរាល់",
            "20_soft_delete_result" => $withDeletedTeachers,
        ];
    }
}