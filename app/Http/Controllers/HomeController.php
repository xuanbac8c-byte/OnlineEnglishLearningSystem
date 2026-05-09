<?php
    namespace App\Http\Controllers;
    
    class HomeController extends Controller{

        public function index(){
            $courses = collect([
                (object)[
                    'image' => 'images/products/course-1.png',
                    'level' => 'Cơ bản',
                    'title' => 'Tiếng Anh giao tiếp cơ bản',
                    'lessons' => 24,
                    'rating' => '4.8',
                    'price' => 599000,
                ],

                (object)[
                    'image' => 'images/products/course-2.png',
                    'level' => 'IELTS',
                    'title' => 'Luyện thi IELTS 6.5+',
                    'lessons' => 60,
                    'rating' => '4.9',
                    'price' => 1299000,
                ],

                (object)[
                    'image' => 'images/products/course-3.png',
                    'level' => 'Trung cấp',
                    'title' => 'Tiếng Anh cho người đi làm',
                    'lessons' => 40,
                    'rating' => '4.7',
                    'price' => 899000,
                ],

                (object)[
                    'image' => 'images/products/course-4.png',
                    'level' => 'Nâng cao',
                    'title' => 'Phản xạ giao tiếp nâng cao',
                    'lessons' => 50,
                    'rating' => '5.0',
                    'price' => 1499000,
                ],

                (object)[
                    'image' => 'images/products/course-5.png',
                    'level' => 'TOEIC',
                    'title' => 'TOEIC 700+ cấp tốc',
                    'lessons' => 45,
                    'rating' => '4.9',
                    'price' => 999000,
                ],

                (object)[
                    'image' => 'images/products/course-6.jpg',
                    'level' => 'Business',
                    'title' => 'English For Business',
                    'lessons' => 32,
                    'rating' => '4.8',
                    'price' => 1199000,
                ],

                (object)[
                    'image' => 'images/products/course-7.jpg',
                    'level' => 'Kids',
                    'title' => 'Tiếng Anh trẻ em',
                    'lessons' => 20,
                    'rating' => '4.9',
                    'price' => 699000,
                ],

                (object)[
                    'image' => 'images/products/course-8.jpg',
                    'level' => 'Speaking',
                    'title' => 'Luyện Speaking thực chiến',
                    'lessons' => 35,
                    'rating' => '4.8',
                    'price' => 1099000,
                ],
            ]);
            return view('pages.home', compact('courses'));
        }
    }
?>