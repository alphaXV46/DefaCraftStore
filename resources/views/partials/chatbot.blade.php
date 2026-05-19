<!-- resources/views/partials/chatbot.blade.php -->

<style>
    /* Floating Chat Trigger Button */
    .chatbot-trigger {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border: none;
        outline: none;
        cursor: pointer;
        box-shadow: 0 8px 24px rgba(118, 75, 162, 0.4);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .chatbot-trigger:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 28px rgba(118, 75, 162, 0.5);
    }

    .chatbot-trigger i {
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    /* Pulsing Notification Badge/Indicator */
    .chatbot-trigger::after {
        content: '';
        position: absolute;
        top: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #2ec4b6;
        border: 2px solid #ffffff;
        box-shadow: 0 0 0 0 rgba(46, 196, 182, 0.7);
        animation: pulse-badge 1.8s infinite;
    }

    @keyframes pulse-badge {
        0% {
            box-shadow: 0 0 0 0 rgba(46, 196, 182, 0.7);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(46, 196, 182, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(46, 196, 182, 0);
        }
    }

    /* Chat Window - Premium Glassmorphism */
    .chatbot-window {
        position: fixed;
        bottom: 105px;
        right: 30px;
        width: 380px;
        height: 580px;
        max-height: calc(100vh - 140px);
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        z-index: 9998;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: translateY(20px) scale(0.95);
        opacity: 0;
        pointer-events: none;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .chatbot-window.active {
        transform: translateY(0) scale(1);
        opacity: 1;
        pointer-events: auto;
    }

    /* Chat Header */
    .chatbot-header {
        padding: 18px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .chatbot-profile {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbot-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .chatbot-info h5 {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.3px;
    }

    .chatbot-status {
        font-size: 11px;
        display: flex;
        align-items: center;
        gap: 5px;
        opacity: 0.9;
    }

    .chatbot-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #2ec4b6;
        display: inline-block;
        box-shadow: 0 0 8px #2ec4b6;
        animation: status-blink 1.5s infinite alternate;
    }

    @keyframes status-blink {
        from { opacity: 0.4; }
        to { opacity: 1; }
    }

    .chatbot-close-btn {
        background: transparent;
        border: none;
        color: rgba(255, 255, 255, 0.8);
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chatbot-close-btn:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.15);
        transform: rotate(90deg);
    }

    /* Chat Messages Content Area */
    .chatbot-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        scroll-behavior: smooth;
        background: rgba(255, 255, 255, 0.3);
    }

    /* Scrollbar Customization */
    .chatbot-messages::-webkit-scrollbar {
        width: 6px;
    }
    .chatbot-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    .chatbot-messages::-webkit-scrollbar-thumb {
        background: rgba(118, 75, 162, 0.2);
        border-radius: 10px;
    }
    .chatbot-messages::-webkit-scrollbar-thumb:hover {
        background: rgba(118, 75, 162, 0.4);
    }

    /* Chat Bubbles */
    .message-bubble {
        max-width: 80%;
        padding: 12px 16px;
        font-size: 13.5px;
        line-height: 1.5;
        font-family: 'Inter', sans-serif;
        position: relative;
        animation: bubble-fade-in 0.3s ease forwards;
    }

    @keyframes bubble-fade-in {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-bubble.bot {
        align-self: flex-start;
        background-color: #ffffff;
        color: #2d3748;
        border-radius: 18px 18px 18px 4px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .message-bubble.user {
        align-self: flex-end;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border-radius: 18px 18px 4px 18px;
        box-shadow: 0 4px 15px rgba(118, 75, 162, 0.15);
    }

    .message-time {
        display: block;
        font-size: 9.5px;
        margin-top: 5px;
        opacity: 0.6;
        text-align: right;
    }

    .message-bubble.user .message-time {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Quick/Suggested Questions Panel */
    .chatbot-suggestions {
        padding: 10px 20px;
        background-color: rgba(255, 255, 255, 0.5);
        border-top: 1px solid rgba(0, 0, 0, 0.03);
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .suggestion-pill {
        background-color: #ffffff;
        border: 1px solid rgba(118, 75, 162, 0.2);
        color: #764ba2;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .suggestion-pill:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border-color: transparent;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(118, 75, 162, 0.2);
    }

    /* Chat Input Footer */
    .chatbot-input-area {
        padding: 14px 20px;
        background-color: #ffffff;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chatbot-input-wrapper {
        flex: 1;
        background-color: #f7fafc;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 30px;
        padding: 2px 6px 2px 16px;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .chatbot-input-wrapper:focus-within {
        border-color: #764ba2;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.15);
    }

    .chatbot-input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        padding: 8px 0;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #2d3748;
    }

    .chatbot-input::placeholder {
        color: #a0aec0;
    }

    .chatbot-send-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        border: none;
        outline: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .chatbot-send-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 10px rgba(118, 75, 162, 0.3);
    }

    .chatbot-send-btn i {
        font-size: 13px;
    }

    /* Typing/Loading Indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
    }

    .typing-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #764ba2;
        animation: typing-bounce 1.4s infinite ease-in-out both;
    }

    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes typing-bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }

    /* Responsive UI Adjustments */
    @media (max-width: 480px) {
        .chatbot-window {
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            max-height: 100%;
            border-radius: 0;
        }
        
        .chatbot-trigger {
            bottom: 20px;
            right: 20px;
        }
        
        .chatbot-window.active {
            transform: translateY(0) scale(1);
        }
    }
</style>

<!-- Floating Chat Trigger Button -->
<button id="chatbotTrigger" class="chatbot-trigger" aria-label="Tanya Customer Service">
    <i class="fas fa-comments"></i>
</button>

<!-- Chat Window -->
<div id="chatbotWindow" class="chatbot-window">
    <!-- Chat Header -->
    <div class="chatbot-header">
        <div class="chatbot-profile">
            <div class="chatbot-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="chatbot-info">
                <h5>Defa Craft Assistant</h5>
                <div class="chatbot-status">
                    <span class="chatbot-status-dot"></span>
                    <span>Online &amp; Aktif</span>
                </div>
            </div>
        </div>
        <button id="chatbotClose" class="chatbot-close-btn" aria-label="Tutup Chat">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Chat Messages -->
    <div id="chatbotMessages" class="chatbot-messages">
        <!-- Bot Welcome Message -->
        <div class="message-bubble bot">
            Halo! Selamat datang di <strong>DefaCraftStore</strong>! 🧸✨
            <br><br>
            Saya adalah <strong>Defa Craft Assistant</strong>, asisten AI yang siap membantu menjawab pertanyaan Anda seputar Dunia Blind Box & Figure Impianmu, seri Bunny, Nanci, Hirono, Action Figure favorit, metode pengiriman, hingga cara memesan.
            <br><br>
            Ada yang bisa saya bantu hari ini?
            <span class="message-time" id="welcomeTime">12:00</span>
        </div>
    </div>

    <!-- Quick Suggestions -->
    <div class="chatbot-suggestions">
        <button class="suggestion-pill" data-question="Bagaimana cara memesan produk di DefaCraftStore?">
            🛍️ Cara Pesan
        </button>
        <button class="suggestion-pill" data-question="Apa saja seri Blind Box yang tersedia di sini?">
            🎁 Seri Blind Box
        </button>
        <button class="suggestion-pill" data-question="Apakah semua Action Figure yang dijual di sini 100% original?">
            ⚡ Action Figure
        </button>
        <button class="suggestion-pill" data-question="Bagaimana cara menghitung ongkos kirim dan pengirimannya?">
            📦 Info Ongkir
        </button>
    </div>

    <!-- Chat Input Footer -->
    <div class="chatbot-input-area">
        <div class="chatbot-input-wrapper">
            <input type="text" id="chatbotInput" class="chatbot-input" placeholder="Tulis pesan di sini..." autocomplete="off">
        </div>
        <button id="chatbotSend" class="chatbot-send-btn" aria-label="Kirim Pesan">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trigger = document.getElementById('chatbotTrigger');
        const windowEl = document.getElementById('chatbotWindow');
        const closeBtn = document.getElementById('chatbotClose');
        const input = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSend');
        const messagesContainer = document.getElementById('chatbotMessages');
        const welcomeTime = document.getElementById('welcomeTime');
        const suggestions = document.querySelectorAll('.suggestion-pill');

        // Set waktu saat ini pada welcome message
        const now = new Date();
        const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        if (welcomeTime) {
            welcomeTime.textContent = timeString;
        }

        // Tampilkan/Sembunyikan Window Chat
        trigger.addEventListener('click', function() {
            windowEl.classList.toggle('active');
            scrollToBottom();
            // Hilangkan animasi pulsing/badge notifikasi setelah chat dibuka
            trigger.style.setProperty('--badge-display', 'none');
            trigger.classList.remove('pulse-badge');
            // Tambahkan rule style dinamis untuk sembunyikan pseudo-element ::after
            const style = document.createElement('style');
            style.innerHTML = '.chatbot-trigger::after { display: none !important; }';
            document.head.appendChild(style);
        });

        closeBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Cegah event bubbling
            windowEl.classList.remove('active');
        });

        // Event handler kirim pesan
        sendBtn.addEventListener('click', handleSend);
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleSend();
            }
        });

        // Event handler suggestion pills
        suggestions.forEach(pill => {
            pill.addEventListener('click', function() {
                const question = this.getAttribute('data-question');
                if (question) {
                    sendMessage(question);
                }
            });
        });

        function handleSend() {
            const text = input.value.trim();
            if (text === '') return;
            sendMessage(text);
        }

        function sendMessage(text) {
            // 1. Tampilkan pesan user ke chat box
            appendMessage(text, 'user');
            
            // Bersihkan input field
            input.value = '';
            
            // 2. Tampilkan typing indicator
            const typingId = showTypingIndicator();
            scrollToBottom();

            // 3. Kirim ke Backend Laravel Controller menggunakan Fetch API
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Menggunakan URL relatif '/chatbot/tanya' untuk menghindari CORS / domain mismatch dengan APP_URL
            fetch("/chatbot/tanya", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                },
                body: JSON.stringify({ pesan: text })
            })
            .then(response => {
                if (!response.ok) {
                    // Mencoba membaca pesan error kustom dari controller
                    return response.json()
                        .catch(() => {
                            // Jika gagal parse JSON, kembalikan objek dengan pesan default
                            return { jawaban: "Maaf, sepertinya koneksi terputus atau server sedang sibuk." };
                        })
                        .then(errData => {
                            throw new Error(errData.jawaban || "Terjadi kesalahan pada server AI.");
                        });
                }
                return response.json();
            })
            .then(data => {
                // Hapus typing indicator
                removeTypingIndicator(typingId);

                // Tampilkan jawaban dari AI
                if (data.jawaban) {
                    appendMessage(data.jawaban, 'bot');
                } else {
                    appendMessage("Maaf, saya gagal memahami jawaban tersebut. Coba ulangi kembali.", 'bot');
                }
                scrollToBottom();
            })
            .catch(error => {
                console.error("Error Chatbot:", error);
                removeTypingIndicator(typingId);
                appendMessage(error.message, 'bot');
                scrollToBottom();
            });
        }

        function appendMessage(text, sender) {
            const bubble = document.createElement('div');
            bubble.className = `message-bubble ${sender}`;

            // Formatting sederhana untuk memproses newlines dan bold (**text**)
            let formattedText = escapeHtml(text)
                .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>');

            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            bubble.innerHTML = `${formattedText} <span class="message-time">${timeStr}</span>`;
            messagesContainer.appendChild(bubble);
        }

        function showTypingIndicator() {
            const typingId = 'typing-' + Date.now();
            const bubble = document.createElement('div');
            bubble.className = 'message-bubble bot';
            bubble.id = typingId;
            bubble.innerHTML = `
                <div class="typing-indicator">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                </div>
            `;
            messagesContainer.appendChild(bubble);
            return typingId;
        }

        function removeTypingIndicator(id) {
            const element = document.getElementById(id);
            if (element) {
                element.remove();
            }
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }
    });
</script>
