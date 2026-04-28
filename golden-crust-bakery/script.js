document.addEventListener("DOMContentLoaded", () => {
  const bookingForm = document.querySelector(".booking-form");
  const contactForm = document.querySelector(".contact-form");

  if (bookingForm) {
    bookingForm.addEventListener("submit", function (e) {
      const name = document.getElementById("bname").value.trim();
      const phone = document.getElementById("bphone").value.trim();
      const date = document.getElementById("date").value.trim();
      const time = document.getElementById("time").value.trim();
      const seats = document.getElementById("seats").value.trim();

      if (!name || !phone || !date || !time || !seats) {
        e.preventDefault();
        alert("Please fill all booking fields.");
      }
    });
  }

  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const message = document.getElementById("message").value.trim();

      if (!name || !email || !message) {
        e.preventDefault();
        alert("Please fill all contact fields.");
      }
    });
  }
});