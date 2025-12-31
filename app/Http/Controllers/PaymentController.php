<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function createQR(Request $request)
    {
        \Log::info('Payment QR request received', $request->all());
        
        // Kiểm tra xem có order_id không (từ student payment)
        if ($request->has('order_id')) {
            // Trường hợp từ student payment - tìm payment đã tồn tại
            $request->validate([
                'order_id' => 'required|numeric',
                'amount' => 'required|numeric|min:1000'
            ]);

            // Tìm payment theo ID (order_id thực chất là payment ID)
            $payment = Payment::find($request->order_id);
            
            if (!$payment) {
                return response()->json([
                    'error' => 'Payment not found'
                ], 404);
            }

            $title = $payment->title;
            $amount = $payment->amount;
            
        } else {
            // Trường hợp từ admin - tạo payment mới
            $request->validate([
                'title' => 'required|string|max:255',
                'amount' => 'required|numeric|min:1000',
                'description' => 'nullable|string',
                'payment_type' => 'nullable|in:tuition,activity,exam,book,uniform,other'
            ]);

            // Tạo payment mới tự động (không cần student_id)
            $payment = Payment::create([
                'student_id' => null, // Không gán học sinh cụ thể
                'order_id' => rand(10000, 99999), // Tự động tạo order_id
                'title' => $request->title,
                'description' => $request->description ?? 'Thanh toán được tạo từ QR Generator',
                'amount' => $request->amount,
                'due_date' => now()->addDays(30), // Hạn thanh toán 30 ngày
                'payment_type' => $request->payment_type ?? 'other',
                'status' => 'PENDING'
            ]);

            $title = $payment->title;
            $amount = $payment->amount;
        }

        \Log::info('Payment processed', ['payment_id' => $payment->id, 'title' => $title]);

        // Gọi API VietQR
        try {
            $addInfo = "Thanh toan " . $title;

            $response = Http::post('https://api.vietqr.io/v2/generate', [
                "accountNo"   => "45601062006",
                "accountName" => "NGUYEN VAN TIEN BAO",
                "acqId"       => "970422",
                "amount"      => $amount,
                "addInfo"     => $addInfo,
                "template"    => "compact"
            ]);

            \Log::info('VietQR API response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->failed()) {
                \Log::error('VietQR API failed', ['response' => $response->body()]);
                return response()->json([
                    'error' => 'Failed to generate QR code'
                ], 500);
            }

            return response()->json([
                'payment_id' => $payment->id,
                'order_id' => $payment->order_id,
                'qr' => $response->json()['data']['qrDataURL']
            ]);
        } catch (\Exception $e) {
            \Log::error('Exception in createQR', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Error generating QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkStatus($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        
        return response()->json([
            'payment_id' => $payment->id,
            'order_id' => $payment->order_id,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'created_at' => $payment->created_at
        ]);
    }

    public function updateStatus(Request $request, $paymentId)
    {
        $request->validate([
            'status' => 'required|in:PENDING,COMPLETED,FAILED,CANCELLED'
        ]);

        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Payment status updated successfully',
            'payment' => $payment
        ]);
    }

    public function getPayments()
    {
        $payments = Payment::with('student')->orderBy('created_at', 'desc')->paginate(20);
        
        return response()->json($payments);
    }

    public function getPaymentsList()
    {
        $payments = Payment::with('student')
            ->select('id', 'student_id', 'title', 'amount', 'status', 'due_date')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($payment) {
                return [
                    'id' => $payment->id,
                    'title' => $payment->title,
                    'student_name' => $payment->student ? $payment->student->ho_va_ten : 'N/A',
                    'amount' => $payment->amount,
                    'formatted_amount' => number_format($payment->amount) . ' VNĐ',
                    'status' => $payment->status,
                    'due_date' => $payment->due_date ? $payment->due_date->format('d/m/Y') : null
                ];
            });
        
        return response()->json($payments);
    }
}