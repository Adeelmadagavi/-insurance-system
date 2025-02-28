document.addEventListener("DOMContentLoaded", function () {
    const languageSelector = document.getElementById("language");

    languageSelector.addEventListener("change", function () {
        const selectedLanguage = this.value;
        translatePage(selectedLanguage);
    });

    function translatePage(language) {
        const googleTranslateScript = document.createElement("script");
        googleTranslateScript.src = `https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit`;
        document.body.appendChild(googleTranslateScript);

        window.googleTranslateElementInit = function () {
            new google.translate.TranslateElement(
                { pageLanguage: "en", includedLanguages: "hi,kn,mr", layout: google.translate.TranslateElement.InlineLayout.SIMPLE },
                "google_translate_element"
            );
        };

        setTimeout(() => {
            document.getElementById("google_translate_element").querySelector("select").value = language;
            document.getElementById("google_translate_element").dispatchEvent(new Event("change"));
        }, 1000);
    }
});
