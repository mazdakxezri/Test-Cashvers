@extends($activeTemplate . '.layouts.app')
@section('title', 'Home')

@section('content')
<div style="background: #0a0a0f; min-height: 100vh; position: relative; overflow-x: hidden; overflow-y: auto;">
    
    <!-- Cosmic Background -->
    <div class="cosmic-bg"></div>
    
    <!-- Floating Geometric Shapes -->
    <div class="floating-shape shape-cube" style="top: 15%; left: 8%;"></div>
    <div class="floating-shape shape-ring" style="top: 65%; right: 12%;"></div>
    <div class="floating-shape shape-triangle" style="top: 35%; right: 6%;"></div>
    <div class="floating-shape shape-cube" style="bottom: 20%; left: 15%;"></div>
    
    <!-- Glowing Orbs -->
    <div class="glow-orb" style="top: 10%; right: 15%; background: radial-gradient(circle, rgba(0, 184, 212, 0.4) 0%, transparent 70%); width: 400px; height: 400px;"></div>
    <div class="glow-orb" style="bottom: 10%; left: 10%; background: radial-gradient(circle, rgba(13, 71, 161, 0.3) 0%, transparent 70%); width: 500px; height: 500px;"></div>
    
    <!-- Hero Section -->
    <section class="hero-space" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 80px 20px; position: relative; z-index: 10;">
        <div style="max-width: 1400px; margin: 0 auto; width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
            
            <!-- Left Side: Text Content -->
            <div style="text-align: left;">
                <div style="display: inline-block; background: rgba(0, 184, 212, 0.1); border: 1px solid rgba(0, 184, 212, 0.3); border-radius: 50px; padding: 8px 20px; margin-bottom: 24px;">
                    <span style="color: #00B8D4; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif;">🚀 THE FUTURE OF EARNING</span>
                </div>
                
                <h1 style="font-size: clamp(40px, 6vw, 68px); font-weight: 700; line-height: 1.15; margin-bottom: 24px; color: #ffffff; font-family: 'Inter', sans-serif;">
                    Turn Time Into<br>
                    <span style="background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Crypto Rewards</span>
                </h1>
                
                <p style="font-size: 18px; color: rgba(255, 255, 255, 0.7); max-width: 540px; margin-bottom: 40px; line-height: 1.7; font-family: 'Inter', sans-serif;">
                    Complete tasks, unlock achievements, and cash out in Bitcoin, Ethereum, or USDT. Fast, secure, and built for the crypto generation.
                </p>
                
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="javascript:void(0)" 
                       class="btn-glow"
                       data-bs-toggle="modal" 
                       data-bs-target="#authModal" 
                       onclick="selectCreateAccountTab()">
                        Start Earning Now
                    </a>
                    <a href="#how-it-works" 
                       style="background: rgba(255, 255, 255, 0.05); color: white; padding: 16px 36px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease; display: inline-block; font-family: 'Inter', sans-serif; backdrop-filter: blur(10px);">
                        Learn More
                    </a>
                </div>
            </div>
            
            <!-- Right Side: Hero Avatar -->
            <div style="position: relative; display: flex; align-items: center; justify-content: center;">
                <div class="avatar-container" style="position: relative; animation: float 6s ease-in-out infinite;">
                    <!-- Multiple Glowing Rings -->
                    <div class="glow-ring-1"></div>
                    <div class="glow-ring-2"></div>
                    <div class="glow-ring-3"></div>
                    
                    <!-- Main Glowing background -->
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 500px; height: 500px; background: radial-gradient(circle, rgba(0, 184, 212, 0.3) 0%, rgba(13, 71, 161, 0.2) 50%, transparent 70%); filter: blur(60px); animation: pulse 4s ease-in-out infinite; z-index: 1;"></div>
                    
                    <!-- Avatar Image -->
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/hero-avatar.png') }}?v={{ config('app.version') }}&t={{ time() }}" 
                         alt="Crypto Warrior" 
                         class="hero-avatar"
                         style="position: relative; width: 100%; max-width: 480px; height: auto; z-index: 3; animation: avatarGlow 3s ease-in-out infinite;">
                    
                    <!-- Energy Particles -->
                    <div class="energy-particle particle-1"></div>
                    <div class="energy-particle particle-2"></div>
                    <div class="energy-particle particle-3"></div>
                    <div class="energy-particle particle-4"></div>
                    <div class="energy-particle particle-5"></div>
                    <div class="energy-particle particle-6"></div>
                    
                    <!-- Orbiting Particles -->
                    <div style="position: absolute; width: 10px; height: 10px; background: #00B8D4; border-radius: 50%; top: 10%; left: 15%; animation: orbit 10s linear infinite; box-shadow: 0 0 15px #00B8D4, 0 0 30px rgba(0, 184, 212, 0.5); z-index: 4;"></div>
                    <div style="position: absolute; width: 8px; height: 8px; background: #0D47A1; border-radius: 50%; bottom: 20%; right: 20%; animation: orbit 12s linear infinite reverse; box-shadow: 0 0 12px #0D47A1, 0 0 25px rgba(13, 71, 161, 0.5); z-index: 4;"></div>
                    <div style="position: absolute; width: 12px; height: 12px; background: #00B8D4; border-radius: 50%; top: 55%; right: 8%; animation: orbit 15s linear infinite; box-shadow: 0 0 18px #00B8D4, 0 0 35px rgba(0, 184, 212, 0.5); z-index: 4;"></div>
                    <div style="position: absolute; width: 7px; height: 7px; background: #0D47A1; border-radius: 50%; top: 30%; right: 30%; animation: orbit 9s linear infinite reverse; box-shadow: 0 0 10px #0D47A1, 0 0 20px rgba(13, 71, 161, 0.5); z-index: 4;"></div>
                </div>
            </div>
            
        </div>
    </section>

    <!-- Statistics Section -->
    <section style="padding: 100px 20px; background: rgba(0, 0, 0, 0.3); position: relative; z-index: 10; backdrop-filter: blur(10px);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px;">
                <div class="stat-card-float">
                    <div style="font-size: 42px; font-weight: 700; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        {{ getStatistics()['average_time'] ?? '2 Hours' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Average Time to First Cashout
                    </div>
                </div>
                <div class="stat-card-float">
                    <div style="font-size: 42px; font-weight: 700; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        {{ getStatistics()['average_money'] ?? '$12.50' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Average Earned Yesterday
                    </div>
                </div>
                <div class="stat-card-float">
                    <div style="font-size: 42px; font-weight: 700; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        {{ getStatistics()['total_earned'] ?? '$284,592' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Total Earned on {{ siteName() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" style="padding: 120px 20px; position: relative; z-index: 10;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 80px;">
                <h2 style="font-size: clamp(36px, 5vw, 56px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    How It Works
                </h2>
                <p style="font-size: 18px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Get started in three simple steps
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h4 style="font-size: 24px; font-weight: 600; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                        Create Account
                    </h4>
                    <p style="font-size: 16px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Sign up in 30 seconds and join thousands earning crypto daily
                    </p>
                </div>
                
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h4 style="font-size: 24px; font-weight: 600; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                        Complete Tasks
                    </h4>
                    <p style="font-size: 16px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Choose from thousands of offers, surveys, and games
                    </p>
                </div>
                
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h4 style="font-size: 24px; font-weight: 600; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                        Get Paid
                    </h4>
                    <p style="font-size: 16px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Cash out instantly to Bitcoin, Ethereum, or USDT
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section style="padding: 100px 20px; background: rgba(0, 0, 0, 0.3); position: relative; z-index: 10; backdrop-filter: blur(10px);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 64px;">
                <h2 style="font-size: clamp(36px, 5vw, 56px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    Cash Out Your Way
                </h2>
                <p style="font-size: 18px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Multiple withdrawal options available
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 24px; max-width: 1000px; margin: 0 auto;">
                @foreach ($paymentMethods as $image)
                    <div class="payment-card-hover">
                        <img src="{{ url($image) }}" alt="Payment Method" style="max-width: 100%; max-height: 50px; object-fit: contain; filter: brightness(1.1);">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section style="padding: 120px 20px; position: relative; z-index: 10;">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 64px;">
                <h2 style="font-size: clamp(36px, 5vw, 56px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    Questions?
                </h2>
                <p style="font-size: 18px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Everything you need to know
                </p>
            </div>
            
            <div>
                @foreach ($faqs as $index => $faq)
                    <div class="faq-item">
                        <button type="button" 
                                class="faq-button"
                                data-bs-toggle="collapse" 
                                data-bs-target="#faq{{ $index }}">
                            <span>{{ $faq->question }}</span>
                            <span style="color: #00B8D4; font-size: 24px; font-weight: 300; transition: transform 0.3s ease;">+</span>
                        </button>
                        <div id="faq{{ $index }}" class="collapse">
                            <div style="padding: 0 28px 28px; color: rgba(255, 255, 255, 0.6); line-height: 1.8; font-size: 15px; font-family: 'Inter', sans-serif;">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

<style>
/* Cosmic Background */
.cosmic-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(2px 2px at 20% 30%, white, transparent),
        radial-gradient(2px 2px at 60% 70%, white, transparent),
        radial-gradient(1px 1px at 50% 50%, white, transparent),
        radial-gradient(1px 1px at 80% 10%, white, transparent),
        radial-gradient(2px 2px at 90% 60%, white, transparent),
        radial-gradient(1px 1px at 33% 80%, white, transparent),
        radial-gradient(2px 2px at 70% 40%, white, transparent);
    background-size: 200% 200%;
    animation: stars 200s linear infinite;
    opacity: 0.4;
    z-index: 1;
}

@keyframes stars {
    from { transform: translateY(0); }
    to { transform: translateY(-100px); }
}

/* Floating Geometric Shapes */
.floating-shape {
    position: absolute;
    opacity: 0.15;
    z-index: 2;
}

.shape-cube {
    width: 60px;
    height: 60px;
    border: 2px solid #00B8D4;
    transform: rotate(45deg);
    animation: float 8s ease-in-out infinite;
}

.shape-ring {
    width: 80px;
    height: 80px;
    border: 2px solid #0D47A1;
    border-radius: 50%;
    animation: float 10s ease-in-out infinite reverse;
}

.shape-triangle {
    width: 0;
    height: 0;
    border-left: 40px solid transparent;
    border-right: 40px solid transparent;
    border-bottom: 70px solid rgba(0, 184, 212, 0.3);
    animation: float 12s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-30px) rotate(10deg); }
}

/* Glowing Orbs */
.glow-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    z-index: 1;
    animation: pulse 8s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.1); }
}

@keyframes orbit {
    0% { transform: rotate(0deg) translateX(200px) rotate(0deg); }
    100% { transform: rotate(360deg) translateX(200px) rotate(-360deg); }
}

/* Avatar Glow Animation */
@keyframes avatarGlow {
    0%, 100% { 
        filter: drop-shadow(0 0 30px rgba(0, 184, 212, 0.6)) drop-shadow(0 0 60px rgba(0, 184, 212, 0.3)); 
    }
    50% { 
        filter: drop-shadow(0 0 50px rgba(0, 184, 212, 0.9)) drop-shadow(0 0 100px rgba(0, 184, 212, 0.5)); 
    }
}

/* Glowing Rings */
.glow-ring-1, .glow-ring-2, .glow-ring-3 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 50%;
    border: 2px solid rgba(0, 184, 212, 0.3);
    z-index: 2;
}

.glow-ring-1 {
    width: 520px;
    height: 520px;
    animation: ringRotate 20s linear infinite, ringPulse 3s ease-in-out infinite;
}

.glow-ring-2 {
    width: 580px;
    height: 580px;
    border-color: rgba(13, 71, 161, 0.2);
    animation: ringRotate 25s linear infinite reverse, ringPulse 4s ease-in-out infinite;
}

.glow-ring-3 {
    width: 640px;
    height: 640px;
    border-color: rgba(0, 184, 212, 0.15);
    animation: ringRotate 30s linear infinite, ringPulse 5s ease-in-out infinite;
}

@keyframes ringRotate {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

@keyframes ringPulse {
    0%, 100% { 
        border-width: 2px;
        opacity: 0.3;
    }
    50% { 
        border-width: 3px;
        opacity: 0.6;
    }
}

/* Energy Particles */
.energy-particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #00B8D4;
    border-radius: 50%;
    box-shadow: 0 0 10px #00B8D4, 0 0 20px rgba(0, 184, 212, 0.5);
    z-index: 4;
}

.particle-1 {
    top: 15%;
    left: 25%;
    animation: particleFloat 6s ease-in-out infinite, particleFade 3s ease-in-out infinite;
}

.particle-2 {
    top: 70%;
    left: 15%;
    animation: particleFloat 7s ease-in-out infinite 1s, particleFade 3.5s ease-in-out infinite 0.5s;
}

.particle-3 {
    top: 25%;
    right: 20%;
    animation: particleFloat 8s ease-in-out infinite 2s, particleFade 4s ease-in-out infinite 1s;
}

.particle-4 {
    top: 50%;
    right: 10%;
    animation: particleFloat 6.5s ease-in-out infinite 1.5s, particleFade 3.2s ease-in-out infinite 1.5s;
}

.particle-5 {
    bottom: 25%;
    left: 30%;
    animation: particleFloat 7.5s ease-in-out infinite 0.5s, particleFade 3.8s ease-in-out infinite 0.8s;
}

.particle-6 {
    bottom: 35%;
    right: 25%;
    animation: particleFloat 8.5s ease-in-out infinite 2.5s, particleFade 4.2s ease-in-out infinite 2s;
}

@keyframes particleFloat {
    0%, 100% { transform: translateY(0) translateX(0); }
    25% { transform: translateY(-20px) translateX(10px); }
    50% { transform: translateY(-10px) translateX(-15px); }
    75% { transform: translateY(-25px) translateX(5px); }
}

@keyframes particleFade {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 1; }
}

/* Avatar Container Hover Effect */
.avatar-container:hover .hero-avatar {
    animation: avatarGlow 1.5s ease-in-out infinite, float 6s ease-in-out infinite;
}

.avatar-container:hover .glow-ring-1,
.avatar-container:hover .glow-ring-2,
.avatar-container:hover .glow-ring-3 {
    border-color: rgba(0, 184, 212, 0.6) !important;
}

/* Button with Glow Effect */
.btn-glow {
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    color: white;
    padding: 16px 36px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 0 20px rgba(0, 184, 212, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-glow:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 30px rgba(0, 184, 212, 0.6);
}

/* Stat Cards with Float Effect */
.stat-card-float {
    background: rgba(18, 18, 26, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 40px 32px;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: all 0.4s ease;
}

.stat-card-float:hover {
    transform: translateY(-8px);
    border-color: rgba(0, 184, 212, 0.4);
    box-shadow: 0 20px 40px rgba(0, 184, 212, 0.2);
}

/* Step Cards */
.step-card {
    background: rgba(18, 18, 26, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    padding: 48px 40px;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: all 0.4s ease;
}

.step-card:hover {
    transform: translateY(-8px);
    border-color: rgba(0, 184, 212, 0.3);
    box-shadow: 0 20px 40px rgba(0, 184, 212, 0.15);
}

.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: white;
    margin: 0 auto 28px;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 10px 30px rgba(0, 184, 212, 0.3);
}

/* Payment Cards */
.payment-card-hover {
    background: rgba(18, 18, 26, 0.5);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 16px;
    padding: 32px 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100px;
    transition: all 0.4s ease;
    backdrop-filter: blur(10px);
}

.payment-card-hover:hover {
    border-color: rgba(0, 184, 212, 0.4);
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0, 184, 212, 0.2);
}

/* FAQ Items */
.faq-item {
    background: rgba(18, 18, 26, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: 16px;
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.faq-item:hover {
    border-color: rgba(0, 184, 212, 0.3);
}

.faq-button {
    width: 100%;
    background: transparent;
    border: none;
    color: #ffffff;
    font-size: 17px;
    font-weight: 600;
    padding: 28px;
    text-align: left;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-family: 'Inter', sans-serif;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    /* Hero section - stack text and avatar */
    section > div > div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
        gap: 40px !important;
    }
    
    /* Center text on mobile */
    .hero-space > div > div:first-child {
        text-align: center !important;
    }
    
    /* Adjust avatar size on mobile */
    .hero-avatar {
        max-width: 350px !important;
    }
    
    .avatar-container {
        max-width: 350px !important;
        margin: 0 auto !important;
    }
    
    /* Smaller rings on mobile */
    .glow-ring-1 { width: 380px !important; height: 380px !important; }
    .glow-ring-2 { width: 420px !important; height: 420px !important; }
    .glow-ring-3 { width: 460px !important; height: 460px !important; }
}

@media (max-width: 768px) {
    /* Even smaller on phones */
    .hero-avatar {
        max-width: 280px !important;
    }
    
    .avatar-container {
        max-width: 280px !important;
    }
    
    .glow-ring-1 { width: 320px !important; height: 320px !important; }
    .glow-ring-2 { width: 360px !important; height: 360px !important; }
    .glow-ring-3 { width: 400px !important; height: 400px !important; }
    
    /* Adjust section padding */
    .section-space {
        padding: 60px 16px !important;
    }
    
    .hero-space {
        padding: 60px 16px !important;
    }
}
</style>
@endsection
