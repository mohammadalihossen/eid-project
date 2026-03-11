<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class SalamiController extends Controller
{
    // ১. মূল পেজ লোড করবে
    public function index()
    {
        return view('salami');
    }

    // ২. রোজার ঈদ স্পেশাল ইমেইল পাঠানোর ফাংশন
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string'
        ]);

        $paymentLink = url('/'); 

        $htmlBody = "
            <div style='background-color: #020617; padding: 40px 15px; font-family: Arial, sans-serif; text-align: center;'>
                
                <div style='max-width: 600px; margin: 0 auto; background: #0f172a; padding: 40px 30px; border-radius: 20px; border: 2px solid #eab308; box-shadow: 0 10px 30px rgba(234, 179, 8, 0.2);'>
                    
                    <div style='font-size: 50px; margin-bottom: 10px;'>🌙 🥣 💸</div>
                    <h1 style='color: #facc15; margin-top: 0; font-size: 26px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);'>🚨 চূড়ান্ত সালামি ওয়ার্নিং! 🚨</h1>
                    
                    <hr style='border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 20px 0;'>

                    <h3 style='color: #ffffff; font-size: 20px; text-align: left;'>ওহে কিপ্টা <span style='color: #38bdf8;'>{$request->name}</span>,</h3>
                    
                    <p style='color: #cbd5e1; font-size: 16px; line-height: 1.6; text-align: left;'>
                        পুরো ৩০টা রোজা তো শেষ হতে চললো! সারামাস ইফতারের বিল তো ফাঁকি দিয়েছিস, এবার কি ঈদের সালামিটাও ফাঁকি দেওয়ার ধান্দা? চাঁদ রাতে যদি সালামি না পাই, তবে খবর আছে! 😒
                    </p>

                    <div style='background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 15px; margin: 25px 0; text-align: left; border-radius: 0 8px 8px 0;'>
                        <p style='color: #fca5a5; font-size: 16px; margin: 0 0 10px 0; font-weight: bold;'>⚠️ ২৪ ঘণ্টার মধ্যে সালামি না দিলে যা যা হবে:</p>
                        <ul style='color: #f87171; font-size: 14px; margin: 0; padding-left: 20px; line-height: 1.8;'>
                            <li>তোর সব মানসম্মান হানিকর ছবি ফেসবুকে লিক করা হবে! 📸</li>
                            <li>ঈদের দিন আমার বাসায় আসলে তোর সেমাইয়ের বাটিতে এক চামচ লবণ মিশিয়ে দেওয়া হবে! 🥣🧂</li>
                            <li>আন্টিকে বলে দিব তুই তারাবির কথা বলে বাইরে গিয়ে আড্ডা দিস! 🕌</li>
                            <li>চাঁদ রাতে তোর ক্রাশের কাছে তোর পুরনো কিপ্টামির গল্প ফাঁস করা হবে! 💔</li>
                        </ul>
                    </div>

                    <p style='color: #cbd5e1; font-size: 16px; line-height: 1.6; text-align: left;'>
                        তাই 'বিকাশের লিমিট শেষ', 'ঈদের শপিংয়ে টাকা শেষ'—এইসব বস্তাপচা ডায়লগ বাদ দে। নিচে বিশাল বড় বাটন দেওয়া আছে, ইজ্জত থাকতে পেমেন্ট করে দে!
                    </p>

                    <div style='margin: 40px 0;'>
                        <a href='{$paymentLink}' style='background: linear-gradient(to right, #eab308, #f59e0b); color: #000000; padding: 15px 30px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 18px; display: inline-block; box-shadow: 0 4px 15px rgba(234, 179, 8, 0.4); text-transform: uppercase;'>
                            💸 ইজ্জত বাঁচাতে পেমেন্ট করুন
                        </a>
                    </div>

                    <hr style='border: none; border-top: 1px solid rgba(255, 255, 255, 0.1); margin: 30px 0;'>
                    
                    <p style='font-size: 14px; color: #94a3b8; font-style: italic; margin: 0;'>
                        নো বাকি, অনলি নগদ/বিকাশ/SSLCommerz! 🚀<br><br>
                        বিনীত,<br>
                        <b style='color: #e2e8f0;'>চিফ কালেক্টর, ঈদ সালামি অথরিটি</b>
                    </p>
                </div>
                
            </div>
        ";

        try {
            Mail::html($htmlBody, function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('রোজা তো চলছে... সালামি রেডি তো? 🌙');
            });
            return response()->json(['status' => 'success', 'message' => 'ওয়ার্নিং ইমেইল সফলভাবে পাঠানো হয়েছে! 🚀']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'মেইল পাঠাতে সমস্যা হচ্ছে! কনফিগারেশন চেক করুন।'], 500);
        }
    }

    // ৩. SSLCommerz Payment ইনিশিয়েট করা
    public function payWithSSLCommerz(Request $request)
    {
        $amount = $request->amount; 
        
        if (!$amount || $amount < 10) {
            $amount = 100; // ডিফল্ট ১০০ টাকা
        }

        $post_data = [];
        $post_data['store_id'] = env('SSLC_STORE_ID');
        $post_data['store_passwd'] = env('SSLC_STORE_PASSWORD');
        $post_data['total_amount'] = $amount; 
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = "SALAMI_" . uniqid();
        $post_data['success_url'] = route('sslc.success');
        $post_data['fail_url'] = route('sslc.fail');
        $post_data['cancel_url'] = route('sslc.cancel');
        
        $post_data['cus_name'] = "Kipta Bondhu";
        $post_data['cus_email'] = "kipta@gmail.com";
        $post_data['cus_add1'] = "Dhaka";
        $post_data['cus_city'] = "Dhaka";
        $post_data['cus_postcode'] = "1000";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = "01700000000";
        
        $apiUrl = env('SSLC_MODE') == 'sandbox' 
                ? "https://sandbox.sslcommerz.com/gwprocess/v4/api.php" 
                : "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

        $response = Http::asForm()->post($apiUrl, $post_data);
        $result = $response->json();

        if (isset($result['status']) && $result['status'] == 'SUCCESS') {
            return redirect($result['GatewayPageURL']);
        } else {
            return back()->with('error', 'পেমেন্ট গেটওয়ে কানেক্ট করা যাচ্ছে না!');
        }
    }

    // ৪. SSLCommerz Callbacks (রোজার ঈদ স্পেশাল মেসেজ)
    public function paymentSuccess(Request $request) { 
        return "<div style='text-align:center; margin-top:100px; font-family:sans-serif;'>
                    <h1 style='color:green; font-size:50px;'>🎉💸</h1>
                    <h1 style='color:green;'>সালামি রিসিভড! অনেক ধন্যবাদ!</h1>
                    <p style='color:gray; font-size:18px;'>ঈদের দিন তোমার জন্য স্পেশাল <b>জর্দা-সেমাই আর কাচ্চি বিরিয়ানি</b> থাকবে! চলে এসো! 🍲</p>
                    <a href='".route('home')."' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#eab308; color:black; text-decoration:none; border-radius:5px; font-weight:bold;'>হোমে ফিরে যান</a>
                </div>"; 
    }
    
    public function paymentFail(Request $request) { 
        return "<div style='text-align:center; margin-top:100px; font-family:sans-serif;'>
                    <h1 style='color:red; font-size:50px;'>😡</h1>
                    <h1 style='color:red;'>সালামি দেওয়া ফেইল হয়েছে!</h1>
                    <p style='color:gray; font-size:18px;'>সারামাস রোজা রেখে ঈদের আগে এই কিপ্টামি মানা যায় না! জলদি আবার ট্রাই করেন!</p>
                    <a href='".route('home')."' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#ef4444; color:white; text-decoration:none; border-radius:5px; font-weight:bold;'>আবার ট্রাই করুন</a>
                </div>"; 
    }
    
    public function paymentCancel(Request $request) { 
        return "<div style='text-align:center; margin-top:100px; font-family:sans-serif;'>
                    <h1 style='color:orange; font-size:50px;'>⚠️</h1>
                    <h1 style='color:orange;'>পেমেন্ট ক্যানসেল করেছেন?</h1>
                    <p style='color:gray; font-size:18px;'>পেমেন্ট ক্যানসেল? ঈদের দিন কিন্তু তোর বাসায় গিয়ে তোর ভাগের সেমাই আমি খেয়ে আসব! 😤</p>
                    <a href='".route('home')."' style='display:inline-block; margin-top:20px; padding:10px 20px; background:#f97316; color:white; text-decoration:none; border-radius:5px; font-weight:bold;'>ভুল হয়েছে, আবার পে করব</a>
                </div>"; 
    }
}