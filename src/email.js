import * as emailjs from 'emailjs-com'

emailjs.init("JJP4XUwcSe2OyYQpT");

const recipients = {
    "johnraivenolazo@gmail.com": "service_eixtpe8",
    "jrraiven15@gmail.com": "service_lyjfrfk"
    // Add more recipients and service IDs
    // eg. "name@gmail.com": "service_id",
};

const templateID = "template_607131g";

async function sendEmail(serviceID, recipient, fromName, userEmail, userMessage) {
    const templateParams = {
        to_email: recipient,
        from_name: fromName,
        user_name: userEmail,
        message: userMessage
    };

    try {
        const response = await emailjs.send(serviceID, templateID, templateParams);
        console.log("Email sent successfully to", recipient, ":", response);
    } catch (error) {
        console.log("Email failed to send to", recipient, ":", error);
    }
}

function handleFormSubmission(event) {
    event.preventDefault();
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    if (!nameInput.checkValidity() || !emailInput.checkValidity() || !messageInput.checkValidity()) {
        alert("Please fill out all required fields.");
        return;
    }

    for (const [recipient, serviceID] of Object.entries(recipients)) {
        const fromName = "CenDash | Landing Page";
        const userEmail = emailInput.value;
        const userMessage = messageInput.value;

        sendEmail(serviceID, recipient, fromName, userEmail, userMessage);
    }

    alert("🌟 Hooray! Your messages have been sent successfully!");
}

document.getElementById('emailForm').addEventListener('submit', handleFormSubmission);
