<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddMessageController extends Controller
{
    public function setMsg(Request $request)
    {
        // دریافت داده‌ها از درخواست
        $name = $request->input('name', "null");
        $phone = $request->input('phone', "null");
        $city = $request->input('city', "null");
        $loe = $request->input('loe', "null");
        $title_id = $request->input('title_id', "null");
        $reporter_id = $request->input('reporter_id', "null");
        $message = $request->input('message');
        $create_date = jdate(); // استفاده از زمان فعلی
    
        // ذخیره فایل‌ها و دریافت مسیرهای ذخیره شده
        $filesPaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads/messages', 'public'); // ذخیره در storage/app/public/uploads/messages
                $filesPaths[] = $path;
            }
        }
    
        // ذخیره اطلاعات در دیتابیس
        $newRecord = DB::table('crs_msg')->insertGetId([
            'name' => $name,
            'phone' => $phone,
            'city' => $city,
            'loe' => $loe,
            'files_path' => json_encode($filesPaths), // ذخیره مسیر فایل‌ها در دیتابیس
            'title_id' => $title_id,
            'reporter_id' => $reporter_id,
            'message' => $message,
            'create_at' => $create_date
        ]);
    
        // بررسی وضعیت ذخیره‌سازی
        if ($newRecord) {
            return response()->json([
                'status' => '1',
                'message' => 'پیام شما با موفقیت ثبت شد.',
                'data' => $newRecord
            ]);
        } else {
            return response()->json([
                'status' => '2',
                'message' => 'خطایی در ثبت اطلاعات رخ داده. لطفا بعدا امتحان کنید.',
                'data' => null
            ]);
        }
    }
    




    // public function setMsg(Request $request)
    // {
    //     $name = $request->name;
    //     $phone = $request->phone;
    //     $city = $request->city;
    //     $loe = $request->loe;
    //     $title_id = $request->title_id;
    //     $reporter_id = $request->reporter_id;
    //     $message = $request->message;
    //     $files = $request->files;

    //     $create_date = jdate();

    //     // return dd($files);

    //     // if ($files != null) {
    //     //     $year = substr($create_date, 0, 4);
    //     //     $month = substr($create_date, 5, 2);

    //     //     $filesPath = "";
    //     //     $path = 'atachments/' . $year . '/' . $month . '/';
    //     //     // return count($files);
    //     // } else {
    //         $filesPath = 'N/A';
    //     // }

    //     if ($filesPath != null) {

    //         $newRecord = DB::table('crs_msg')
    //             ->insertGetId([
    //                 'name' => $name,
    //                 'phone' => $phone ?? "null",
    //                 'city' => $city ?? "null",
    //                 'loe' => $loe ?? "null",
    //                 'files_path' => $filesPath,
    //                 'title_id' => $title_id ?? 0,
    //                 'reporter_id' => $reporter_id ?? 0,
    //                 'message' => $message,
    //                 'create_at' => $create_date
    //             ]);

    //         if ($newRecord != null) {
    //             return response()->json([
    //                 'status' => '1',
    //                 'message' => 'پیام شما با موفقیت ثبت شد.',
    //                 'data' => $newRecord
    //             ]);
    //         } else {
    //             return response()->json([
    //                 'status' => '2',
    //                 'message' => 'خطایی در ثبت اطلاعات رخ داده. لطفا بعدا امتحان کنید.',
    //                 'data' => null
    //             ]);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => '3',
    //             'message' => 'خطایی در آپلود فایل پیوست رخ داده. لطفا بعدا امتحان کنید.',
    //             'data' => $filesPath
    //         ]);
    //     }
    // }


    // Validate the request
    // $request->validate([
    //     'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048' // Adjust file types and size as needed
    // ]);

    // $uploadedFiles = [];

    // if (!$request->hasFile('files')) {
    //     $year = substr($create_date, 0, 4);
    //     $month = substr($create_date, 5, 2);
    //     $day = substr($create_date, 8, 2);

    //     foreach ($request->file('files') as $file) {
    //         // Store file in the 'uploads' directory inside 'storage/app/public'
    //         $path = $file->store('uploads', 'public');

    //         // Save the file path or any other information if needed
    //         $uploadedFiles[] = [
    //             'original_name' => $file->getClientOriginalName(),
    //             'stored_path' => $path
    //         ];
    //     }

    //     return response()->json([
    //         'message' => 'Files uploaded successfully',
    //         'files' => $uploadedFiles
    //     ], 200);
    // }

    // return response()->json(['message' => 'No files uploaded'], 400);



    // if ($images != null) {


    //     $filePath = "";
    //     $path = 'images/imprest/' . $year . '/' . $month . '/' . $user_imprest . '/' . $insertTransaction . '/';
    //     $formatType = '.jpg';

    //     if (!is_dir($path)) {
    //         mkdir($path, 0777, true);
    //     }

    //     $result = array();

    //     foreach ($images as $image) {
    //         if ($image != null) {
    //             $counter = '(1)';
    //             $fileName = $counter . $formatType;
    //             for ($i = 2; file_exists($path . $fileName); $i++) {
    //                 $counter = '(' . $i . ')';
    //                 $fileName = $counter . $formatType;
    //             }

    //             $filePath = $path . $fileName;
    //             $res = file_put_contents($filePath, base64_decode($image));
    //         } else {
    //             $filePath = 'N/A';
    //         }
    //     }
    // } else {
    //     $filePath = 'N/A';
    // }

    //     if ($filePath != 'N/A') {
    //         DB::table('app_imprest_transaction')
    //             ->where('id', $insertTransaction)
    //             ->update(['img' => $path]);
    //     }
    // }
}



///////////////////////////////////////////////////
/*

            if ($images != null) {
                $year = substr($create_date, 0, 4);
                $month = substr($create_date, 5, 2);

                $filePath = "";
                $path = 'images/imprest/' . $year . '/' . $month . '/' . $user_imprest . '/' . $insertTransaction . '/';
                $formatType = '.jpg';

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $result = array();

                foreach ($images as $image) {
                    if ($image != null) {
                        $counter = '(1)';
                        $fileName = $counter . $formatType;
                        for ($i = 2; file_exists($path . $fileName); $i++) {
                            $counter = '(' . $i . ')';
                            $fileName = $counter . $formatType;
                        }

                        $filePath = $path . $fileName;
                        $res = file_put_contents($filePath, base64_decode($image));
                    } else {
                        $filePath = 'N/A';
                    }
                }
            } else {
                $filePath = 'N/A';
            }

            if ($filePath != 'N/A') {
                DB::table('app_imprest_transaction')
                    ->where('id', $insertTransaction)
                    ->update(['img' => $path]);
            }            if ($images != null) {
                $year = substr($create_date, 0, 4);
                $month = substr($create_date, 5, 2);

                $filePath = "";
                $path = 'images/imprest/' . $year . '/' . $month . '/' . $user_imprest . '/' . $insertTransaction . '/';
                $formatType = '.jpg';

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $result = array();

                foreach ($images as $image) {
                    if ($image != null) {
                        $counter = '(1)';
                        $fileName = $counter . $formatType;
                        for ($i = 2; file_exists($path . $fileName); $i++) {
                            $counter = '(' . $i . ')';
                            $fileName = $counter . $formatType;
                        }

                        $filePath = $path . $fileName;
                        $res = file_put_contents($filePath, base64_decode($image));
                    } else {
                        $filePath = 'N/A';
                    }
                }
            } else {
                $filePath = 'N/A';
            }

            if ($filePath != 'N/A') {
                DB::table('app_imprest_transaction')
                    ->where('id', $insertTransaction)
                    ->update(['img' => $path]);
            }
 
  }
   public function processImages($images, $create_date, $user_imprest, $insertTransaction)
    {
        if ($images != null) {
            $year = substr($create_date, 0, 4);
            $month = substr($create_date, 5, 2);
            $day = substr($create_date, 8, 2);
            $path = 'crs/attached/' . $year . '-' . $month . '-' . $user_imprest . '/' . $insertTransaction . '/';
            $formatType = '.jpg';

            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            foreach ($images as $image) {
                if ($image != null) {
                    $counter = '(1)';
                    $fileName = $counter . $formatType;
                    for ($i = 2; file_exists($path . $fileName); $i++) {
                        $counter = '(' . $i . ')';
                        $fileName = $counter . $formatType;
                    }

                    $filePath = $path . $fileName;
                    file_put_contents($filePath, base64_decode($image));
                }
            }

            DB::table('app_imprest_transaction')
                ->where('id', $insertTransaction)
                ->update(['img' => $path]);
        }
    }
*/