window.onload = function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    { pageLanguage: 'ES', layout: google.translate.TranslateElement.InlineLayout.SIMPLE },
    "google_translate_element"
  );
}

function triggerHtmlEvent(element, eventName) {
  var event;
  if (document.createEvent) {
    event = document.createEvent("HTMLEvents");
    event.initEvent(eventName, true, true);
    element.dispatchEvent(event);
  } else {
    event = document.createEventObject();
    event.eventType = eventName;
    element.fireEvent("on" + event.eventType, event);
  }
}
function deleteAllCookies() {
  var cookies = document.cookie.split(";");

  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    var eqPos = cookie.indexOf("=");
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:01 GMT;";
  }
}
$("#language-header").on("change", function (e) {
  e.preventDefault();
  window.location = $(this).children('option:selected').val();
  deleteAllCookies();
  location.reload();
});
