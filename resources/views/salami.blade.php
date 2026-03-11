<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ঈদ সালামি পোর্টাল আল্ট্রা প্রো 🌙</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Hind Siliguri', sans-serif; 
            color: white; 
            overflow-x: hidden; 
            margin: 0; 
            background-color: #050814; 
            -webkit-tap-highlight-color: transparent;
        }
        
        #bg-canvas { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -2; }
        
        /* Premium Glassmorphism */
        .glass-card {
            background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            transition: all 0.3s ease;
        }

        /* Money Rain Animation (Opor theke taka pora) */
        .money-drop {
            position: fixed; top: -50px; font-size: 1.5rem; user-select: none; z-index: -1;
            animation: fall linear forwards; opacity: 0.7;
        }
        @keyframes fall { to { transform: translateY(110vh) rotate(360deg); } }

        /* Neon Glow */
        .neon-text { text-shadow: 0 0 15px rgba(250, 204, 21, 0.6); }
        
        /* Custom Scrollbar for Rates */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Button Pulse */
        .btn-pay {
            background: linear-gradient(135deg, #0b5cff, #003db3);
            box-shadow: 0 0 20px rgba(11, 92, 255, 0.3);
        }
        .btn-pay:active { transform: scale(0.95); }

        /* Mobile Input Styling */
        .qty-input {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body class="min-h-screen">

    <canvas id="bg-canvas"></canvas>

    <div class="max-w-6xl mx-auto px-4 pt-6 pb-20 relative z-10">
        
        <header class="text-center mb-8">
            <div class="text-7xl mb-2 animate-bounce drop-shadow-2xl">🌙</div>
            <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-500 neon-text">
                ঈদ মোবারক!
            </h1>
            <div class="mt-4 inline-block bg-white/10 px-6 py-2 rounded-full border border-white/20 backdrop-blur-md">
                <p class="text-sm md:text-lg">সালামি না দিলে এবার খবর আছে! 😎💸</p>
            </div>
        </header>

        <section class="mb-10">
            <h2 class="text-lg font-bold mb-4 text-yellow-400 text-center">📋 অফিসিয়াল সালামি রেট</h2>
            <div class="flex overflow-x-auto gap-4 no-scrollbar snap-x pb-2">
                <div class="glass-card p-5 min-w-[140px] flex-1 text-center border-t-4 border-blue-400 snap-center">
                    <p class="text-blue-300 text-xs font-bold uppercase">সিনিয়র</p>
                    <p class="text-2xl font-black mt-1">৳ ৫০০</p>
                </div>
                <div class="glass-card p-5 min-w-[140px] flex-1 text-center border-t-4 border-purple-400 snap-center">
                    <p class="text-purple-300 text-xs font-bold uppercase">কাজিন</p>
                    <p class="text-2xl font-black mt-1">৳ ৪০০</p>
                </div>
                <div class="glass-card p-5 min-w-[140px] flex-1 text-center border-t-4 border-green-400 snap-center">
                    <p class="text-green-300 text-xs font-bold uppercase">জুনিয়র</p>
                    <p class="text-2xl font-black mt-1">৳ ৩০০</p>
                </div>
                <div class="glass-card p-5 min-w-[140px] flex-1 text-center border-t-4 border-pink-400 snap-center">
                    <p class="text-pink-300 text-xs font-bold uppercase">পিচ্চি</p>
                    <p class="text-2xl font-black mt-1">৳ ১০০</p>
                </div>
            </div>
        </section>

        <div class="grid lg:grid-cols-2 gap-6">
            <section class="glass-card p-6 border-l-4 border-yellow-400">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">🧮 সালামি হিসাব করুন</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center qty-input p-3 rounded-2xl">
                        <span class="font-medium">👨‍💼 সিনিয়র (জন)</span>
                        <div class="flex items-center gap-4">
                            <button onclick="changeVal('sen', -1)" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center font-bold">-</button>
                            <input type="number" id="sen" value="0" class="w-8 bg-transparent text-center font-bold text-lg outline-none" readonly>
                            <button onclick="changeVal('sen', 1)" class="w-8 h-8 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold">+</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center qty-input p-3 rounded-2xl">
                        <span class="font-medium">🤝 কাজিন (জন)</span>
                        <div class="flex items-center gap-4">
                            <button onclick="changeVal('cousin', -1)" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center font-bold">-</button>
                            <input type="number" id="cousin" value="0" class="w-8 bg-transparent text-center font-bold text-lg outline-none" readonly>
                            <button onclick="changeVal('cousin', 1)" class="w-8 h-8 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold">+</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center qty-input p-3 rounded-2xl">
                        <span class="font-medium">👦 জুনিয়র (জন)</span>
                        <div class="flex items-center gap-4">
                            <button onclick="changeVal('jun', -1)" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center font-bold">-</button>
                            <input type="number" id="jun" value="0" class="w-8 bg-transparent text-center font-bold text-lg outline-none" readonly>
                            <button onclick="changeVal('jun', 1)" class="w-8 h-8 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold">+</button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-gray-400 text-xs mb-1 uppercase tracking-widest">Total Salami</p>
                    <h3 class="text-5xl font-black text-green-400 drop-shadow-lg">৳ <span id="total_amount">0</span></h3>
                </div>
            </section>

            <section class="glass-card p-6 border-r-4 border-blue-500 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold mb-4">💳 পেমেন্ট গেটওয়ে</h2>
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="bg-white rounded-xl p-2 h-14 flex items-center justify-center"><img src="https://logos-world.net/wp-content/uploads/2024/10/Bkash-Logo.png" class="h-6"></div>
                        <div class="bg-white rounded-xl p-2 h-14 flex items-center justify-center"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrchrgPgRdGgDn-Shd2XZtvYiLbevsHJ9P-w&s" class="h-8"></div>
                        <div class="bg-white rounded-xl p-2 h-14 flex items-center justify-center"><img src="https://static.vecteezy.com/system/resources/previews/068/706/013/non_2x/rocket-color-logo-mobile-banking-icon-free-png.png" class="h-6"></div>
                    </div>
                </div>

                <form action="{{ route('pay.salami') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" id="form_amount" value="100">
                    <button type="submit" class="w-full btn-pay text-white font-black py-5 rounded-2xl text-xl flex items-center justify-center gap-3 transition-all">
                        <span>সালামি দিন এখনই</span>
                        <span class="bg-white/20 px-2 py-0.5 rounded text-xs">SSL</span>
                    </button>
                </form>
            </section>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <div class="glass-card p-6 bg-cyan-900/10 border-t-4 border-cyan-400">
                <h3 class="font-bold text-cyan-300 mb-4">📧 ডিরেক্ট ওয়ার্নিং ইমেইল</h3>
                <div class="space-y-3">
                    <input type="text" id="target-name" placeholder="বন্ধুর নাম" class="w-full p-3 rounded-xl bg-black/40 border border-white/10 outline-none focus:border-cyan-400">
                    <input type="email" id="target-email" placeholder="বন্ধুর ইমেইল" class="w-full p-3 rounded-xl bg-black/40 border border-white/10 outline-none focus:border-cyan-400">
                    <button onclick="sendDirectEmail()" id="mail-btn" class="w-full bg-cyan-600 font-bold py-3 rounded-xl">🚀 পাঠান</button>
                </div>
            </div>

            <div class="glass-card p-6 bg-emerald-900/10 border-t-4 border-emerald-500 text-center">
                <h3 class="font-bold text-emerald-400 mb-4">🕵️ কিপ্টা বন্ধু ট্র্যাকার</h3>
                <button onclick="startTracking()" id="track-btn" class="w-full bg-emerald-600 font-bold py-3 rounded-xl mb-3">লোকেশন হ্যাক করুন!</button>
                <div id="tracking-status" class="hidden text-xs font-bold text-yellow-300 p-3 bg-black/40 rounded-lg border border-emerald-500/20"></div>
            </div>
        </div>
    </div>

    <script>
        // 1. Three.js Background (Stars) - আগের কোড ঠিক রাখা হয়েছে
        const initThreeJS = () => {
            const canvas = document.getElementById('bg-canvas');
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
            renderer.setSize(window.innerWidth, window.innerHeight);

            const geometry = new THREE.BufferGeometry();
            const posArray = new Float32Array(800 * 3);
            for(let i = 0; i < 2400; i++) { posArray[i] = (Math.random() - 0.5) * 2000; }
            geometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
            
            const material = new THREE.PointsMaterial({ size: 2.5, color: 0xfacc15, transparent: true, opacity: 0.8 });
            const mesh = new THREE.Points(geometry, material);
            scene.add(mesh);
            camera.position.z = 400;

            const animate = () => { requestAnimationFrame(animate); mesh.rotation.y += 0.0006; renderer.render(scene, camera); };
            animate();
        };
        window.addEventListener('DOMContentLoaded', initThreeJS);

        // 2. Money Rain Animation - আগের কোড ঠিক রাখা হয়েছে
        function createFallingMoney() {
            const money = document.createElement('div');
            money.classList.add('money-drop');
            const items = ['৳', '💵', '🪙', '💰'];
            money.innerText = items[Math.floor(Math.random() * items.length)];
            money.style.left = Math.random() * 100 + 'vw';
            money.style.animationDuration = Math.random() * 2 + 3 + 's';
            document.body.appendChild(money);
            setTimeout(() => { money.remove(); }, 5000);
        }
        setInterval(createFallingMoney, 500);

        // 3. Calculator Logic with Mobile vibration
        function changeVal(id, amount) {
            let el = document.getElementById(id);
            let val = parseInt(el.value) + amount;
            if (val >= 0) {
                el.value = val;
                calculateLive();
                if (window.navigator.vibrate) window.navigator.vibrate(15); 
            }
        }

        function calculateLive() {
            let sen = (parseInt(document.getElementById('sen').value) || 0) * 500;
            let cousin = (parseInt(document.getElementById('cousin').value) || 0) * 400;
            let jun = (parseInt(document.getElementById('jun').value) || 0) * 300;
            let total = sen + cousin + jun;
            if(total < 10) total = 0; 
            
            document.getElementById('total_amount').innerText = total.toLocaleString('en-IN');
            document.getElementById('form_amount').value = total;
        }

        // 4. Fake Tracker (Funny Logic)
        function startTracking() {
            const btn = document.getElementById('track-btn');
            const statusDiv = document.getElementById('tracking-status');
            statusDiv.classList.remove("hidden");
            btn.disabled = true;
            
            const logs = ["📡 মোবাইল আইপি খোঁজা হচ্ছে...", "🛰️ স্যাটেলাইট কানেক্ট হচ্ছে...", "📍 লোকেশন পাওয়া গেছে!", "🎯 সে এখন পাঞ্জাবি পরে আয়নার সামনে ভাব নিচ্ছে!"];
            let step = 0;
            const interval = setInterval(() => {
                statusDiv.innerText = logs[step];
                step++;
                if(step >= logs.length) {
                    clearInterval(interval);
                    btn.disabled = false;
                }
            }, 1000);
        }
    </script>
</body>
</html>