document.addEventListener('DOMContentLoaded', function() {
    const weatherDisplay = document.getElementById('weather-display');

    async function fetchWeather() {
        try {
            // Fetch weather for Samarinda in JSON format
            const response = await fetch('https://wttr.in/Samarinda?format=j1&lang=id');
            if (!response.ok) throw new Error('Weather data not available');
            
            const data = await response.json();
            displayWeather(data);
        } catch (error) {
            console.error('Error fetching weather:', error);
            weatherDisplay.innerHTML = `
                <div class="weather-error">
                    <p>Gagal memuat data cuaca. Silakan coba lagi nanti.</p>
                </div>
            `;
        }
    }

    function getWeatherEmoji(desc) {
        desc = desc.toLowerCase();
        if (desc.includes('sun') || desc.includes('clear')) return '☀️';
        if (desc.includes('partly cloudy')) return '⛅';
        if (desc.includes('cloud')) return '☁️';
        if (desc.includes('rain') || desc.includes('drizzle')) return '🌧️';
        if (desc.includes('thunder')) return '⛈️';
        if (desc.includes('mist') || desc.includes('fog')) return '🌫️';
        return '🌡️';
    }

    function displayWeather(data) {
        const current = data.current_condition[0];
        const weatherDesc = current.lang_id ? current.lang_id[0].value : current.weatherDesc[0].value;
        const temp = current.temp_C;
        const humidity = current.humidity;
        const windSpeed = current.windspeedKmph;
        const feelsLike = current.FeelsLikeC;

        const emoji = getWeatherEmoji(current.weatherDesc[0].value);

        weatherDisplay.classList.remove('weather-loading');
        weatherDisplay.innerHTML = `
            <div class="weather-display-container">
                <div class="weather-temp-main">
                    <div class="weather-icon-large">${emoji}</div>
                    <div class="temp-value">${temp}<span class="temp-unit">°C</span></div>
                    <p style="margin-top: 0.5rem; font-weight: 600; color: #fff;">${weatherDesc}</p>
                </div>
                
                <div class="weather-details">
                    <div class="weather-detail-item">
                        <label>Terasa Seperti</label>
                        <span>${feelsLike}°C</span>
                    </div>
                    <div class="weather-detail-item">
                        <label>Kelembapan</label>
                        <span>${humidity}%</span>
                    </div>
                    <div class="weather-detail-item">
                        <label>Kecepatan Angin</label>
                        <span>${windSpeed} km/h</span>
                    </div>
                    <div class="weather-detail-item">
                        <label>Kondisi</label>
                        <span>${weatherDesc}</span>
                    </div>
                </div>
            </div>
        `;
    }

    fetchWeather();
});
