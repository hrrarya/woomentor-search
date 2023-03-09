jQuery(function ($) {
  let searchReq = null;
  function debounce(cb, delay = 500) {
    let timer;
    return (...args) => {
      clearTimeout(timer);
      timer = setTimeout(() => {
        cb(...args);
      }, delay);
    };
  }
  const ajaxSearchContainer = $(".woomentor_ajax_search_form");
  //   console.log(WooMentor.ajaxurl);

  ajaxSearchContainer.each(function () {
    const searchInput = $(this).find(".woomentor_ajax_search_form_input");

    searchInput.on(
      "input",
      debounce(function (e) {
        const searchTerm = e.target.value;

        if (searchTerm.length >= 3) {
          const data = {
            action: "woomentor_ajax_search",
            searchTerm,
          };

          if (searchReq) searchReq.abort();

          searchReq = $.ajax({
            url: WooMentor.ajaxurl,
            method: "POST",
            data,
            success: function (res) {
              console.log(res);
            },
            error: function () {
              console.log("something wrong with ajax search");
            },
          });
        }
      })
    );
  });
});
