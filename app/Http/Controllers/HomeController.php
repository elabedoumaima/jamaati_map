<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية
     */
    public function index()
    {
        $squares = [
            [
                'id' => 1,
                'name' => 'بوابة العيون',
                'description' => 'بوابة مدينة العيون هي معلم حضري تمثيلي يمثل مدخلًا بارزًا لمدينة العيون، مستوحى من الخيمة الصحراوية كرمز للثقافة الصحراوية الأصيلة.',
                'image' => 'بوابة العيون.png'
            ],
            [
                'id' => 2,
                'name' => 'ساحة المشور (القصر)',
                'description' => 'ساحة كبيرة مزينة بأشجار النخيل ومقاعد، تستضيف مهرجانات واحتفالات رسمية مثل الذكرى الخضراء.',
                'image' => 'ساحة المشور.jpg'
            ],
            [
                'id' => 3,
                'name' => 'ساحة أم السعد',
                'description' => 'مساحة واسعة (حوالي 60 هكتارًا)، تضم مسرحًا بلديًا، دار للجماعة، مجمع تجاري، نافورات، مساحات خضراء.',
                'image' => 'ام السعد.jpg'
            ],
            [
                'id' => 4,
                'name' => 'حديقة الأطفال',
                'description' => 'حديقة الأطفال بمدينة العيون هي فضاء ترفيهي حديث يقع بشارع لالة الياقوت، مجهزة بألعاب متنوعة.',
                'image' => 'حديقة الاطفال.jpg'
            ],
            [
                'id' => 5,
                'name' => 'ساحة العبيدي',
                'description' => 'ساحة العبيدي هي فضاء عمومي بحي الوفاق في مدينة العيون، مخصص للترفيه والتجمعات العائلية.',
                'image' => 'ساحة العبيدي.jpg'
            ]
        ];

        // جلب التعليقات المعتمدة (آخر 10 تعليقات)
        $comments = Comment::approved()
            ->latest()
            ->take(10)
            ->get();

        return view('home', compact('squares', 'comments'));
    }

    /**
     * حفظ تعليق جديد
     */
    public function storeComment(Request $request)
    {
        try {
            // التحقق من صحة البيانات
            $validator = Validator::make($request->all(), [
                'author_name' => 'required|string|max:255|min:2',
                'author_email' => 'required|email|max:255',
                'content' => 'required|string|max:1000|min:5',
            ], [
                'author_name.required' => 'الاسم مطلوب',
                'author_name.min' => 'الاسم يجب أن يكون على الأقل حرفين',
                'author_name.max' => 'الاسم طويل جداً',
                'author_email.required' => 'البريد الإلكتروني مطلوب',
                'author_email.email' => 'البريد الإلكتروني غير صحيح',
                'content.required' => 'التعليق مطلوب',
                'content.min' => 'التعليق قصير جداً',
                'content.max' => 'التعليق طويل جداً',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // إنشاء التعليق الجديد
            $comment = Comment::create([
                'author_name' => strip_tags($request->author_name),
                'author_email' => $request->author_email,
                'content' => strip_tags($request->content),
                'is_approved' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال تعليقك بنجاح! سيتم مراجعته قريباً.',
                'comment_id' => $comment->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إرسال التعليق. يرجى المحاولة مرة أخرى.'
            ], 500);
        }
    }

    /**
     * لوحة إدارة التعليقات (اختيارية)
     */
    public function adminComments()
    {
        $pendingComments = Comment::pending()->latest()->get();
        $approvedComments = Comment::approved()->latest()->get();
        
        return view('admin.comments', compact('pendingComments', 'approvedComments'));
    }

    /**
     * اعتماد التعليق
     */
    public function approveComment(Comment $comment)
    {
        $comment->approve();
        
        return response()->json([
            'success' => true,
            'message' => 'تم اعتماد التعليق بنجاح'
        ]);
    }

    /**
     * حذف التعليق
     */
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'تم حذف التعليق بنجاح'
        ]);
    }
}