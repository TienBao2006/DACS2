<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('student')->orderBy('created_at', 'desc')->paginate(15);
        return view('Admin.payment.index', compact('payments'));
    }

    public function create()
    {
        // Lấy danh sách lớp để filter
        $classes = Student::select('lop')->distinct()->orderBy('lop')->pluck('lop');
        return view('Admin.payment.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_type' => 'required|string',
            'apply_to' => 'required|in:all_students,specific_class',
            'class_filter' => 'nullable|string'
        ]);

        if ($request->apply_to === 'all_students') {
            // Tạo khoản thu cho tất cả học sinh
            $students = Student::all();
            
            foreach ($students as $student) {
                Payment::create([
                    'student_id' => $student->id,
                    'order_id' => rand(100000, 999999),
                    'title' => $request->title,
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'due_date' => $request->due_date,
                    'payment_type' => $request->payment_type,
                    'status' => 'PENDING'
                ]);
            }
            
            $message = 'Tạo khoản thu cho ' . $students->count() . ' học sinh thành công!';
            
        } else {
            // Tạo khoản thu cho lớp cụ thể
            $students = Student::where('lop', $request->class_filter)->get();
            
            foreach ($students as $student) {
                Payment::create([
                    'student_id' => $student->id,
                    'order_id' => rand(100000, 999999),
                    'title' => $request->title,
                    'description' => $request->description,
                    'amount' => $request->amount,
                    'due_date' => $request->due_date,
                    'payment_type' => $request->payment_type,
                    'status' => 'PENDING'
                ]);
            }
            
            $message = 'Tạo khoản thu cho lớp ' . $request->class_filter . ' (' . $students->count() . ' học sinh) thành công!';
        }

        return redirect()->route('admin.payments.index')
            ->with('success', $message);
    }

    public function show($id)
    {
        $payment = Payment::with('student')->findOrFail($id);
        return view('Admin.payment.show', compact('payment'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,COMPLETED,FAILED,CANCELLED'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update(['status' => $request->status]);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Xóa thanh toán thành công!');
    }
}

