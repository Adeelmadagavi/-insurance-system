document.addEventListener("DOMContentLoaded", function () {
    const startVoiceButton = document.getElementById("start-voice");
    const languageSelector = document.getElementById("language");
    
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = "en-IN"; // Default: English-India
    recognition.continuous = false;
    recognition.interimResults = false;

    startVoiceButton.addEventListener("click", () => {
        console.log("Listening...");
        recognition.start();
    });

    recognition.onresult = async function (event) {
        const spokenText = event.results[0][0].transcript;
        console.log("User said:", spokenText);
        await translateText(spokenText, languageSelector.value);
    };

    recognition.onerror = function (event) {
        console.error("Speech Recognition Error:", event.error);
    };

    async function translateText(text, targetLang) {
        const translateAPI = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=en&tl=${targetLang}&dt=t&q=${encodeURIComponent(text)}`;

        try {
            const response = await fetch(translateAPI);
            if (!response.ok) throw new Error("Failed to fetch translation");

            const data = await response.json();
            const translatedText = data[0][0][0];

            console.log("Translated Text:", translatedText);
            speakText(translatedText, targetLang);
        } catch (error) {
            console.error("Translation Error:", error);
        }
    }

    function speakText(text, lang) {
        if (!text) {
            console.warn("No text to speak.");
            return;
        }

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = getVoiceLanguage(lang);

        console.log("Speaking:", text);
        speechSynthesis.speak(utterance);
    }

    function getVoiceLanguage(lang) {
        const voiceLangMap = {
            "hi": "hi-IN", // Hindi
            "kn": "kn-IN", // Kannada
            "mr": "mr-IN", // Marathi
            "en": "en-IN"  // English
        };
        return voiceLangMap[lang] || "en-IN";
    }
});
