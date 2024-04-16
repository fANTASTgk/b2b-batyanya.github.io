

<?php

use Sotbit\B2bCabinet\Helper\Config;

global $USER, $APPLICATION;


if (defined("NEED_AUTH") && NEED_AUTH === true) {
    include_once "auth_footer.php";
    return;
}

if ($_GET['IFRAME']) {
    return;
}

include "footer/content_footer.php";
?>

</div>
<!-- /page content -->

<script type="text/javascript">
const cities = document.querySelectorAll(".city");
const filter = document.querySelector("#cityfilter");

filter.addEventListener("input", () => {
 cities.forEach(city => {
    const cityName = city.querySelector("h4").textContent.toLowerCase(); // Изменено с "h2" на "h4"
    const filterValue = filter.value.toLowerCase();

    if (cityName.includes(filterValue)) {
      city.style.display = "";
    } else {
      city.style.display = "none";
    }
 });
});
</script>

</body>

</html>