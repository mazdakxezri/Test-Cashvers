@extends($activeTemplate . '.layouts.app')
@section('title', 'BitLabs Debug')

@section('content')
<div class="cosmic-bg">
    <div class="stars"></div>
</div>

<section class="section-space" style="padding-top: var(--space-3xl);">
    <div class="container-space">
        <div class="card-float">
            <h2 style="margin-bottom: var(--space-lg);">🔍 BitLabs API Debug Tool</h2>
            
            <div id="debug-results">
                <p>Testing BitLabs API endpoints...</p>
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
const config = {
    token: '{{ env("BITLABS_APP_TOKEN") }}',
    uid: '{{ Auth::user()->uid }}',
};

async function testAllEndpoints() {
    const results = [];
    
    // Test different endpoint combinations
    const tests = [
        {
            name: 'V2 Client Surveys (Path Param)',
            url: `https://api.bitlabs.ai/v2/client/surveys/${config.uid}?platform=WEB_DESKTOP`,
            headers: { 'X-Api-Token': config.token, 'Accept': 'application/json' }
        },
        {
            name: 'V2 Client Surveys (Query Param)',
            url: `https://api.bitlabs.ai/v2/client/surveys?uid=${config.uid}&platform=WEB_DESKTOP`,
            headers: { 'X-Api-Token': config.token, 'Accept': 'application/json' }
        },
        {
            name: 'V1 Surveys',
            url: `https://api.bitlabs.ai/v1/surveys?uid=${config.uid}`,
            headers: { 'X-Api-Token': config.token, 'Accept': 'application/json' }
        },
        {
            name: 'Web URL (Direct Browser)',
            url: `https://web.bitlabs.ai/?token=${config.token}&uid=${config.uid}`,
            headers: {}
        }
    ];
    
    for (const test of tests) {
        try {
            const response = await fetch(test.url, { headers: test.headers });
            const data = await response.text();
            
            results.push({
                name: test.name,
                url: test.url,
                status: response.status,
                success: response.ok,
                response: data.substring(0, 500)
            });
        } catch (error) {
            results.push({
                name: test.name,
                url: test.url,
                status: 'ERROR',
                success: false,
                response: error.message
            });
        }
    }
    
    displayResults(results);
}

function displayResults(results) {
    let html = '<div style="font-family: monospace; font-size: 12px;">';
    
    html += `<h3>Configuration:</h3>`;
    html += `<p>Token: ${config.token ? config.token.substring(0, 20) + '...' : 'MISSING'}</p>`;
    html += `<p>UID: ${config.uid}</p>`;
    html += `<hr>`;
    
    results.forEach((result, index) => {
        const color = result.success ? '#4CAF50' : '#F44336';
        html += `
            <div style="margin-bottom: 20px; padding: 15px; background: rgba(${result.success ? '76,175,80' : '244,67,54'}, 0.1); border-left: 3px solid ${color}; border-radius: 8px;">
                <h4 style="color: ${color}; margin-bottom: 10px;">
                    ${index + 1}. ${result.name}
                    ${result.success ? '✅' : '❌'}
                </h4>
                <p><strong>Status:</strong> ${result.status}</p>
                <p><strong>URL:</strong> ${result.url}</p>
                <details>
                    <summary style="cursor: pointer; color: #00B8D4;">View Response</summary>
                    <pre style="margin-top: 10px; padding: 10px; background: rgba(0,0,0,0.3); border-radius: 4px; overflow: auto; max-height: 300px;">${result.response}</pre>
                </details>
            </div>
        `;
    });
    
    html += `
        <div style="margin-top: 30px; padding: 20px; background: rgba(0, 184, 212, 0.1); border-radius: 8px;">
            <h4 style="color: #00B8D4;">📝 Recommendation:</h4>
            <p style="color: rgba(255, 255, 255, 0.8);">
                If all API endpoints fail (404 or CORS errors), you need to:<br>
                1. Contact BitLabs support to enable backend API access<br>
                2. Or use the offerwall iframe (which always works)<br>
                3. Check if your BitLabs account is fully approved for surveys
            </p>
        </div>
    `;
    
    html += '</div>';
    document.getElementById('debug-results').innerHTML = html;
}

// Run tests on page load
testAllEndpoints();
</script>
@endsection

