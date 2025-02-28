document.addEventListener("DOMContentLoaded", function () {
    const notificationList = document.getElementById("notification-list");

    // Mock data for government & private sector insurance updates
    const notifications = [
        { type: "Government", message: "New subsidy announced for crop insurance under PMFBY." },
        { type: "Private", message: "XYZ Insurance introduces a new weather-based insurance policy." },
        { type: "Government", message: "Farmers can now claim compensation for drought damages." },
        { type: "Private", message: "ABC Insurance launches instant claim settlement for farmers." }
    ];

    // Function to display notifications
    function displayNotifications() {
        notificationList.innerHTML = ""; // Clear existing notifications

        notifications.forEach(notif => {
            const li = document.createElement("li");
            li.innerHTML = `<strong>[${notif.type}]</strong> ${notif.message}`;
            notificationList.appendChild(li);
        });
    }

    // Display notifications on page load
    displayNotifications();
});
