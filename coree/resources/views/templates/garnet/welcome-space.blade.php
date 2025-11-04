@extends($activeTemplate . '.layouts.app')
@section('title', 'Home')

@section('content')
<div style="background: #0a0a0f; min-height: 100vh;">
    
    <!-- Hero Section -->
    <section style="min-height: 90vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 80px 20px;">
        <div style="max-width: 1200px; margin: 0 auto; width: 100%;">
            <h1 style="font-size: clamp(36px, 6vw, 64px); font-weight: 700; line-height: 1.2; margin-bottom: 24px; color: #ffffff; font-family: 'Inter', sans-serif;">
                Turn Time Into<br>
                <span style="background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Crypto Rewards</span>
            </h1>
            <p style="font-size: 18px; color: rgba(255, 255, 255, 0.7); max-width: 580px; margin: 0 auto 40px; line-height: 1.7; font-family: 'Inter', sans-serif;">
                Complete tasks, unlock achievements, and cash out in Bitcoin, Ethereum, or USDT. Fast, secure, and built for the crypto generation.
            </p>
            <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="javascript:void(0)" 
                   style="background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); color: white; padding: 16px 36px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; transition: all 0.3s ease; display: inline-block; font-family: 'Inter', sans-serif;"
                   data-bs-toggle="modal" 
                   data-bs-target="#authModal" 
                   onclick="selectCreateAccountTab()">
                    Start Earning
                </a>
                <a href="#how-it-works" 
                   style="background: rgba(255, 255, 255, 0.05); color: white; padding: 16px 36px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease; display: inline-block; font-family: 'Inter', sans-serif;">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section style="padding: 80px 20px; background: rgba(255, 255, 255, 0.02);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 32px; text-align: center;">
                    <div style="font-size: 36px; font-weight: 700; color: #00B8D4; margin-bottom: 8px; font-family: 'Inter', sans-serif;">
                        {{ getStatistics()['average_time'] ?? 'N/A' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Average Time to First Cashout
                    </div>
                </div>
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 32px; text-align: center;">
                    <div style="font-size: 36px; font-weight: 700; color: #00B8D4; margin-bottom: 8px; font-family: 'Inter', sans-serif;">
                        ${{ getStatistics()['average_money'] ?? '0.00' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Average Earned Yesterday
                    </div>
                </div>
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 32px; text-align: center;">
                    <div style="font-size: 36px; font-weight: 700; color: #00B8D4; margin-bottom: 8px; font-family: 'Inter', sans-serif;">
                        ${{ getStatistics()['total_earned'] ?? '0.00' }}
                    </div>
                    <div style="font-size: 15px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                        Total Earned on {{ siteName() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" style="padding: 100px 20px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 64px;">
                <h2 style="font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    How It Works
                </h2>
                <p style="font-size: 17px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Get started in three simple steps
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 32px;">
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 40px; text-align: center;">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto 24px; font-family: 'Inter', sans-serif;">
                        1
                    </div>
                    <h4 style="font-size: 22px; font-weight: 600; color: #ffffff; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        Create Account
                    </h4>
                    <p style="font-size: 15px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Sign up in 30 seconds and join thousands earning crypto daily
                    </p>
                </div>
                
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 40px; text-align: center;">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto 24px; font-family: 'Inter', sans-serif;">
                        2
                    </div>
                    <h4 style="font-size: 22px; font-weight: 600; color: #ffffff; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        Complete Tasks
                    </h4>
                    <p style="font-size: 15px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Choose from thousands of offers, surveys, and games
                    </p>
                </div>
                
                <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 40px; text-align: center;">
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; margin: 0 auto 24px; font-family: 'Inter', sans-serif;">
                        3
                    </div>
                    <h4 style="font-size: 22px; font-weight: 600; color: #ffffff; margin-bottom: 12px; font-family: 'Inter', sans-serif;">
                        Get Paid
                    </h4>
                    <p style="font-size: 15px; color: rgba(255, 255, 255, 0.6); line-height: 1.7; margin: 0; font-family: 'Inter', sans-serif;">
                        Cash out instantly to Bitcoin, Ethereum, or USDT
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section style="padding: 80px 20px; background: rgba(255, 255, 255, 0.02);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 48px;">
                <h2 style="font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    Cash Out Your Way
                </h2>
                <p style="font-size: 17px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Multiple withdrawal options available
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; max-width: 1000px; margin: 0 auto;">
                @foreach ($paymentMethods as $image)
                    <div style="background: rgba(18, 18, 26, 0.5); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 24px; display: flex; align-items: center; justify-content: center; min-height: 100px; transition: all 0.3s ease;">
                        <img src="{{ url($image) }}" alt="Payment Method" style="max-width: 100%; max-height: 50px; object-fit: contain; filter: brightness(1.1);">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section style="padding: 100px 20px;">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 56px;">
                <h2 style="font-size: clamp(32px, 5vw, 48px); font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">
                    Questions?
                </h2>
                <p style="font-size: 17px; color: rgba(255, 255, 255, 0.6); font-family: 'Inter', sans-serif;">
                    Everything you need to know
                </p>
            </div>
            
            <div>
                @foreach ($faqs as $index => $faq)
                    <div style="background: rgba(18, 18, 26, 0.4); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; margin-bottom: 16px; overflow: hidden; transition: all 0.3s ease;">
                        <button type="button" 
                                style="width: 100%; background: transparent; border: none; color: #ffffff; font-size: 17px; font-weight: 600; padding: 24px; text-align: left; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-family: 'Inter', sans-serif;"
                                data-bs-toggle="collapse" 
                                data-bs-target="#faq{{ $index }}">
                            <span>{{ $faq->question }}</span>
                            <span style="color: #00B8D4; font-size: 24px; font-weight: 300; transition: transform 0.3s ease;">+</span>
                        </button>
                        <div id="faq{{ $index }}" class="collapse">
                            <div style="padding: 0 24px 24px; color: rgba(255, 255, 255, 0.6); line-height: 1.8; font-size: 15px; font-family: 'Inter', sans-serif;">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
@endsection
