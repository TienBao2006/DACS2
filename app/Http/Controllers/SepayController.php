<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class SepayController extends Controller
{
    private $apiUrl;
    private $token;
    private $accountNumber;
    private $bankCode;

    public function __construct()
    {
        $this->apiUrl = env('SEPAY_API_URL', 'https://my.sepay.vn/userapi');
        $this->token = env('SEPAY_TOKEN');
        $this->accountNumber = env('SEPAY_ACCOUNT_NUMBER');
        $this->bankCode = env('SEPAY_BANK_CODE');
    }

    /**
     * Tạo QR code thanh toán qua SePay
     */
    public function createPayment(Request $request)
    {
        Log::info('SePay payment request received', $request->all());
        
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'description' => 'required|string|max:255',
            'order_id' => 'nullable|string'
        ]);

        try {
            // Tạo order_id nếu chưa có
            $orderId = $request->order_id ?? 'ORDER_' . time() . '_' . rand(1000, 9999);
            
            // Tạo payment record
            $payment = Payment::create([
                'student_id' => auth()->user()->student->id ?? null,
                'order_id' => $orderId,
                'title' => $request->description,
                'description' => $request->description,
                'amount' => $request->amount,
                'due_date' => now()->addDays(30),
                'payment_type' => $request->payment_type ?? 'other',
                'status' => 'PENDING',
                'payment_method' => 'sepay'
            ]);

            // Gọi SePay API để tạo QR
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json'
            ])->post($this->apiUrl . '/create-qr', [
                'accountNumber' => $this->accountNumber,
                'amount' => $request->amount,
                'content' => $request->description . ' - ' . $orderId,
                'bankCode' => $this->bankCode
            ]);

            Log::info('SePay API response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return response()->json([
                    'success' => true,
                    'payment_id' => $payment->id,
                    'order_id' => $orderId,
                    'qr_code' => $responseData['qrCode'] ?? null,
                    'qr_url' => $responseData['qrUrl'] ?? null,
                    'amount' => $request->amount,
                    'description' => $request->description
                ]);
            } else {
                Log::error('SePay API failed', ['response' => $response->body()]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể tạo mã QR thanh toán'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Exception in SePay createPayment', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kiểm tra trạng thái thanh toán
     */
    public function checkPaymentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string'
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json'
            ])->get($this->apiUrl . '/check-payment', [
                'orderCode' => $request->order_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Cập nhật trạng thái payment trong database
                $payment = Payment::where('order_id', $request->order_id)->first();
                if ($payment && isset($data['status'])) {
                    $status = $data['status'] === 'SUCCESS' ? 'COMPLETED' : 'PENDING';
                    $payment->update(['status' => $status]);
                }

                return response()->json([
                    'success' => true,
                    'status' => $data['status'] ?? 'PENDING',
                    'amount' => $data['amount'] ?? 0,
                    'transaction_id' => $data['transactionId'] ?? null
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể kiểm tra trạng thái thanh toán'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Exception in checkPaymentStatus', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Webhook nhận thông báo từ SePay
     */
    public function webhook(Request $request)
    {
        Log::info('SePay webhook received', $request->all());

        try {
            $orderId = $request->input('orderCode');
            $status = $request->input('status');
            $amount = $request->input('amount');
            $transactionId = $request->input('transactionId');

            // Tìm payment theo order_id
            $payment = Payment::where('order_id', $orderId)->first();
            
            if ($payment) {
                $newStatus = $status === 'SUCCESS' ? 'COMPLETED' : 'FAILED';
                $payment->update([
                    'status' => $newStatus,
                    'transaction_id' => $transactionId,
                    'paid_at' => $status === 'SUCCESS' ? now() : null
                ]);

                Log::info('Payment status updated', [
                    'payment_id' => $payment->id,
                    'order_id' => $orderId,
                    'status' => $newStatus
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Exception in SePay webhook', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Lấy danh sách giao dịch từ SePay
     */
    public function getTransactions(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json'
            ])->get($this->apiUrl . '/transactions', [
                'limit' => $request->input('limit', 50),
                'page' => $request->input('page', 1)
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy danh sách giao dịch'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Exception in getTransactions', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }
}