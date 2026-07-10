<!-- <script>
    // Wait for the DOM to fully load
    document.addEventListener("DOMContentLoaded", () => {
        // Create the ad banner container
        const adBanner = document.createElement("div");
        adBanner.id = "bottom-leaderboard-ad";
        adBanner.style.position = "fixed";
        adBanner.style.bottom = "-100px"; // Initially hidden
        adBanner.style.left = "0";
        adBanner.style.width = "100%";
        adBanner.style.backgroundColor = "#f4f4f4";
        adBanner.style.boxShadow = "0 -2px 5px rgba(0, 0, 0, 0.2)";
        adBanner.style.padding = "10px 20px";
        adBanner.style.display = "flex";
        adBanner.style.justifyContent = "space-between";
        adBanner.style.alignItems = "center";
        adBanner.style.zIndex = "9999";
        adBanner.style.transition = "bottom 0.5s ease";

        // Ad content
        adBanner.innerHTML = `
    <div style="font-size: 16px; color: #333;">
        <div class="admoloBanner" data-publisher="eyJpdiI6Imh1b1FWVWw3SHJISlJtUGd3MHp3QWc9PSIsInZhbHVlIjoiNjdpMTY4MmVyS0NVdUNqUnd3Y2ZFZz09IiwibWFjIjoiMzBkZjNkZDIxMjhmYmQ0YmQ0YWM3MzI3ODgxNjllNTIwMjU1NDYyYWY2MGExMjc5YTRjMmFmOTBiODI4NWE4OSIsInRhZyI6IiJ9" data-adsize="728x90"></div>
        </div>
    <button id="hide-ad-btn" style="background-color: transparent; border: none; font-size: 18px; cursor: pointer;">\u2B07</button>
  `;

        // Append the ad banner to the body
        document.body.appendChild(adBanner);

        // Slide up the banner after 1 second
        setTimeout(() => {
            adBanner.style.bottom = "0";
        }, 1000);

        // Add click event listener to the hide button
        document.getElementById("hide-ad-btn").addEventListener("click", () => {
            adBanner.style.bottom = "-100px"; // Slide down to hide
        });
    });
</script>
<div>



</div> -->
