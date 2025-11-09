document.addEventListener("DOMContentLoaded", () => {
  const startBtn = document.getElementById("startBtn");
  const sessionInfo = document.getElementById("sessionInfo");
  const videoSection = document.getElementById("videoSection");

  startBtn.addEventListener("click", async () => {
    startBtn.disabled = true;
    startBtn.textContent = "Creating Session...";

    try {
      const res = await fetch("create_session.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({})
      });

      const data = await res.json();

      if (data.success) {
        document.getElementById("sessionId").textContent = data.unique_id;
        const studentLink = document.getElementById("studentLink");
        studentLink.href = data.userurl;
        studentLink.textContent = data.userurl;

        sessionInfo.classList.remove("hidden");
        videoSection.classList.remove("hidden");
        startBtn.textContent = "Session Started";
      } else {
        alert("Error: " + data.message);
        startBtn.disabled = false;
        startBtn.textContent = "START SESSION";
      }
    } catch (err) {
      alert("Failed: " + err.message);
      startBtn.disabled = false;
      startBtn.textContent = "START SESSION";
    }
  });
});
