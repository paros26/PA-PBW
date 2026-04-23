document.addEventListener('DOMContentLoaded', function() {
    const weatherDisplay = document.getElementById('weather-display');

    // Samarinda Coordinates
    const LAT = -0.5021;
    const LON = 117.1536;

    async function fetchWeather() {
        try {
            // Using Open-Meteo API (Free, No Key Required, Reliable)
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${LAT}&longitude=${LON}&current=temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m&timezone=Asia%2FSingapore`;
            
            const response = await fetch(url);
            if (!response.ok) throw new Error('Weather data not available');
            
            const data = await response.json();
            displayWeather(data.current);
        } catch (error) {
            console.error('Error fetching weather:', error);
            weatherDisplay.innerHTML = `
                <div class="weather-error" style="padding: 2rem; color: #ff4444;">
                    <i class="bi bi-exclamation-triangle fs-1 d-block mb-2"></i>
                    <p>Gagal memuat data cuaca. Silakan segarkan halaman.</p>
                </div>
            `;
        }
    }

    function getWeatherInfo(code) {
        // WMO Weather interpretation codes (WW)
        const mapping = {
            0: { desc: 'Cerah', icon: '☀️' },
            1: { desc: 'Cerah Berawan', icon: '🌤️' },
            2: { desc: 'Berawan', icon: '⛅' },
            3: { desc: 'Mendung', icon: '☁️' },
            45: { desc: 'Kabut', icon: '🌫️' },
            48: { desc: 'Kabut Rime', icon: '🌫️' },
            51: { desc: 'Gerimis Ringan', icon: '🌧️' },
            53: { desc: 'Gerimis', icon: '🌧️' },
            55: { desc: 'Gerimis Lebat', icon: '🌧️' },
            61: { desc: 'Hujan Ringan', icon: '🌧️' },
            63: { desc: 'Hujan Sedang', icon: '🌧️' },
            65: { desc: 'Hujan Lebat', icon: '🌧️' },
            80: { desc: 'Hujan Shower Ringan', icon: '🌦️' },
            81: { desc: 'Hujan Shower Sedang', icon: '🌦️' },
            82: { desc: 'Hujan Shower Lebat', icon: '🌦️' },
            95: { desc: 'Badai Petir', icon: '⛈️' },
            96: { desc: 'Badai Petir & Es', icon: '⛈️' },
            99: { desc: 'Badai Petir & Es Lebat', icon: '⛈️' }
        };
        return mapping[code] || { desc: 'Berawan', icon: '☁️' };
    }

    function displayWeather(current) {
        const { temperature_2m, relative_humidity_2m, apparent_temperature, weather_code, wind_speed_10m } = current;
        const weather = getWeatherInfo(weather_code);

        weatherDisplay.classList.remove('weather-loading');
        weatherDisplay.innerHTML = `
            <div class="weather-display-container">
                <div class="weather-temp-main">
                    <div class="weather-icon-large">${weather.icon}</div>
                    <div class="temp-value">${Math.round(temperature_2m)}<span class="temp-unit">°C</span></div>
                    <p style="margin-top: 0.5rem; font-weight: 700; color: #ff8c00; text-transform: uppercase; letter-spacing: 1px;">${weather.desc}</p>
                </div>
                
                <div class="weather-details">
                    <div class="weather-detail-item">
                        <label><i class="bi bi-thermometer-half me-1"></i> Terasa Seperti</label>
                        <span>${Math.round(apparent_temperature)}°C</span>
                    </div>
                    <div class="weather-detail-item">
                        <label><i class="bi bi-droplets me-1"></i> Kelembapan</label>
                        <span>${relative_humidity_2m}%</span>
                    </div>
                    <div class="weather-detail-item">
                        <label><i class="bi bi-wind me-1"></i> Angin</label>
                        <span>${wind_speed_10m} km/h</span>
                    </div>
                    <div class="weather-detail-item">
                        <label><i class="bi bi-geo-alt me-1"></i> Lokasi</label>
                        <span>Samarinda, Kaltim</span>
                    </div>
                </div>
            </div>
        `;
    }

    fetchWeather();
});
